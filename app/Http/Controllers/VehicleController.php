<?php

namespace App\Http\Controllers;

use App\Models\Sacco;
use App\Models\Vehicle;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class VehicleController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:vehicle-list|vehicle-create|vehicle-edit|vehicle-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:vehicle-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:vehicle-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:vehicle-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        $vehicles = Vehicle::all();
        $saccos = Sacco::all();
        $statuses = Status::all();
        $todaysMpesaCollection = 0;
        $collectionPercentage = 0;
        $customerCount = 0;
        $totalCustomerBalances = 0;
        $routes = [];
        $customerTypes = [];
        $pickUpPoints = [];
        return view('blades.vehicles', compact('statuses', 'pickUpPoints', 'customerTypes', 'routes', 'vehicles', 'saccos', 'todaysMpesaCollection', 'collectionPercentage', 'customerCount', 'totalCustomerBalances'));
    }

    public function addVehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|min:0|integer',
            'plate' => 'required|string|unique:vehicles,plate,' . $request->id,
            'fleet_no' => 'string|nullable',
            'till_number' => 'integer|nullable',
            'merchant_short_code' => 'integer|nullable',
            'status' => 'required|min:0|max:1|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $vehicle = new Vehicle;
        if ($request->id > 0) {
            $vehicle = Vehicle::findOrFail($request->id);
        }
        $vehicle->plate = $request->plate;
        $vehicle->till_number = $request->till_number;
        $vehicle->fleet_no = $request->fleet_no;
        $vehicle->merchant_short_code = $request->merchant_short_code;
        $vehicle->user_id = Auth::user()->id;
        $vehicle->status = $request->status;
        $vehicle->sacco_id = $request->has('sacco_id') ? $request->sacco_id : 0;

        if ($vehicle->save()) {
            return redirect()->back()->with('success', 'Vehicle updated successfully');
        } else {
            return redirect()->back()->with('error', 'Unable to update vehicle');
        }
    }


    public function getVehicle(Request $request)
    {
        $sacco = Vehicle::findOrFail($request->id);
        return response()->json(['sacco' => $sacco]);
    }

    /*public function getVehicles(Request $request){
        $page = $request->has('page')?intval($request->page)-1:0;
        $records = $request->has('records')?$request->records:10;
        $search = $request->has('records')?$request->search:"";
        $vehicles = Vehicle::where('name', 'LIKE', '%'.$search.'%')->skip($records*$page)->take($records)->get();
        return response()->json(['saccos'=>$vehicles, 'records'=>$records,
            'recordsTotal'=>$vehicles->count(), 'recordsFiltered'=>$vehicles->count(),'page'=>$page+1]);
    }*/

    public function getVehicles(Request $request)
    {
//        $isDatatable = $request->has('is_datatable') ? true : false;
        $vehicles =
            Vehicle::with(['sacco','user']);

        if ($request->has('from_date') && !empty($request->from_date)) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $vehicles = $vehicles->whereDate('created_at', '>=', $from_date);
        }

        if ($request->has('to_date') && !empty($request->to_date)) {
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $vehicles = $vehicles->whereDate('created_at', '<=', $to_date);
        }

        $vehicles = $vehicles->when($request->has('status') && $request->status != '', function ($query) use ($request) {
            return $query->where('status', $request->status);
        });
        $vehicles = $vehicles->distinct()->orderBy("status", "desc");


        /*       if ($isDatatable) {
                   return $this->datatableResponse($vehicles, null);
               } else {
                   return response()->json(['saccos' => $vehicles->get()]);
               }
        */

        return Datatables::of($vehicles)
            ->filter(function ($query) use ($request) {
                if (strlen($request->search) > 0) {
                    $query->where(function ($q) use ($request) {
                        $q->where("vehicles.plate", "LIKE", "%" . $request->search . "%")

                        ;
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
                            <button class="btn btn-outline-primary btnEditVehicle pr-1 pl-1" data-toggle="modal" data-target="#vehicleModal"><i class="fas fa-edit"></i></button>
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
