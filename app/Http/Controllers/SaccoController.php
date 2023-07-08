<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sacco;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SaccoController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:sacco-list|sacco-create|sacco-edit|sacco-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:sacco-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sacco-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sacco-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $saccos = Sacco::all();
        $statuses = Status::all();
        $todaysMpesaCollection = 0;
        $collectionPercentage = 0;
        $customerCount = 0;
        $totalCustomerBalances = 0;
        $routes = [];
        $customerTypes = [];
        $pickUpPoints = [];
        return view('blades.saccos', compact('statuses', 'pickUpPoints', 'customerTypes', 'routes', 'saccos', 'todaysMpesaCollection', 'collectionPercentage', 'customerCount', 'totalCustomerBalances'));
    }

    public function addSacco(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|min:0|integer',
            'name' => 'required|string|unique:saccos,name,' . $request->id,
            'phone_number' => 'string|nullable',
            'motto' => 'string|nullable',
            'pay_bill' => 'string|nullable',
            'consumer_key' => 'string|nullable',
            'consumer_secret' => 'string|nullable',
            'passkey' => 'string|nullable',
            'status' => 'required|min:0|max:1|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sacco = new Sacco;
        if ($request->id > 0) {
            $sacco = Sacco::findOrFail($request->id);
        }

        $sacco->name = $request->name;
        $sacco->phone_number = $request->phone_number;
        $sacco->motto = $request->motto;
        $sacco->pay_bill = $request->pay_bill;
        $sacco->consumer_key = $request->consumer_key;
        $sacco->consumer_secret = $request->consumer_secret;
        $sacco->passkey = $request->passkey;
        $sacco->status = $request->status;
        $sacco->created_by = Auth::user()->id;

        if ($sacco->save()) {
            return redirect()->back()->with('success', 'Sacco updated successfully');
        } else {
            return redirect()->back()->with('error', 'Unable to update Sacco');
        }
    }


    public function getSacco(Request $request)
    {
        $sacco = Sacco::findOrFail($request->id);
        return response()->json(['sacco' => $sacco]);
    }

    /*public function getSaccos(Request $request){
        $page = $request->has('page')?intval($request->page)-1:0;
        $records = $request->has('records')?$request->records:10;
        $search = $request->has('records')?$request->search:"";
        $saccos = Sacco::where('name', 'LIKE', '%'.$search.'%')->skip($records*$page)->take($records)->get();
        return response()->json(['saccos'=>$saccos, 'records'=>$records,
            'recordsTotal'=>$saccos->count(), 'recordsFiltered'=>$saccos->count(),'page'=>$page+1]);
    }*/

    public function getSaccos(Request $request)
    {
//        $isDatatable = $request->has('is_datatable') ? true : false;
        Log::info($request->all());
        $saccos =
            Sacco::with('created_by');

        if ($request->has('from_date') && !empty($request->from_date)) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $saccos = $saccos->whereDate('created_at', '>=', $from_date);
        }

        if ($request->has('to_date') && !empty($request->to_date)) {
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $saccos = $saccos->whereDate('created_at', '<=', $to_date);
        }

        $saccos = $saccos->when($request->has('status') && $request->status != '', function ($query) use ($request) {
            return $query->where('status', $request->status);
        });
        $saccos = $saccos->distinct()->orderBy("status", "desc");


        /*       if ($isDatatable) {
                   return $this->datatableResponse($saccos, null);
               } else {
                   return response()->json(['saccos' => $saccos->get()]);
               }
        */

        return Datatables::of($saccos)
            ->filter(function ($query) use ($request) {
                if (strlen($request->search) > 0) {
                    $query->where(function ($q) use ($request) {
                        $q->where("saccos.name", "LIKE", "%" . $request->search . "%");
                    });
                }
            })->addColumn("status", function ($item) {
                if ($item->status == 1) {
                    return '<span class="badge badge-success">
                                <span class="status">Active</span>
                            </span>';
                } else {
                    return '<span class="badge badge-danger">
                                <span class="status">Deactivated</span>
                            </span>';
                }
            })
            ->addColumn("action", function ($item) {
                $status = $item->enable_statuses ? 0 : 1;
                $name = $item->enable_statuses ? "Disable Extra" : "Enable Extra";
                return '<div class="text-right">
                            <span class="d-none id">' . $item->id . '</span>
                            <span class="d-none town_id">' . $item->town_id . '</span>
                            <span class="d-none status">' . $item->status . '</span>
                            <button class="btn btn-outline-primary btnEditSacco pr-1 pl-1" data-toggle="modal" data-target="#saccoModal"><i class="fas fa-edit"></i></button>
                            <a href="' . url('/sacco/' . $item->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> &nbsp;View</a>
                        </div>';
            })
            ->escapeColumns([])->make();
    }

    public function datatableResponse($query, $buttons): JsonResponse
    {
        return Datatables::of($query)->addColumn('butttons', function ($q) use ($buttons) {
            return $buttons;
        })->escapeColumns([])->make();
    }

}
