<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sacco;
use App\Models\Status;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

    }

    public function index()
    {
        $users = User::all();
        $saccos = Sacco::all();
        $statuses = Status::all();
        $todaysMpesaCollection = 0;
        $collectionPercentage = 0;
        $customerCount = 0;
        $totalCustomerBalances = 0;
        $routes = [];
        $customerTypes = [];
        $pickUpPoints = [];
        return view('blades.vehicles', compact('statuses', 'pickUpPoints', 'customerTypes', 'routes', 'users', 'saccos', 'todaysMpesaCollection', 'collectionPercentage', 'customerCount', 'totalCustomerBalances'));
    }

    public function getUsers(Request $request){
        $page = $request->has('page')?intval($request->page)-1:0;
        $records = $request->has('records')?$request->records:10;
        //$search = $request->has('records')?$request->search:"";
        $users = User::with(['roles','gender'])->where(function($query) use($request){
            $query->where('firstname', 'LIKE', '%'.$request->search.'%')
            ->orWhere('lastname', 'LIKE', '%'.$request->search.'%')
            ->orWhere('email', 'LIKE', '%'.$request->search.'%')
            ->orWhere('phone', 'LIKE', '%'.$request->search.'%');
        })->skip($records*$page)->take($records)->get();
        return response()->json(['users'=>$users, 'records'=>$records,
        'recordsTotal'=>$users->count(), 'recordsFiltered'=>$users->count(),
        'page'=>$page+1]);
    }
    public function addUser(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'integer|required|min:0',
            'firstname'=>'string|required',
            'lastname'=>'string|required',
            'email'=>'required|email|unique:users,email,'.$request->id,
            'phone'=>'required|digits:10|unique:users,phone,'.$request->id,
            'status'=>'required|min:0|max:1|integer',
            'dob'=>'date|before:today|required',
            'gender'=>'required|integer',
            'role'=>'required|integer'
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->messages()], 400);
        }
        $user = new User;
        if($request->id > 0){
            $user = User::find($request->id);
        }
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->gender_id = $request->gender;
        if($request->id == 0){
            $user->password = app('hash')->make('12345678');
        }
        $user->dob = Carbon::parse($request->dob);
        if($user->save()){
            if($request->role > 1){
                $role = Role::where('id',$request->role->id??$request->role)->pluck('name');
                $user->syncRoles($role);
            }
            return response()->json(['success'=>'User updated successfully!']);
        }else{
            return response()->json(['error'=>'Unable to update user'], 401);
        }
    }

    public function getUser(Request $request){
        $user = User::with('gender', 'roles', 'permissions')->where('id', $request->id)->first();
        $permissions = Permission::all();
        return response()->json(['user'=>$user, 'permissions'=>$permissions]);
    }
}
