@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Vehicle'])
    <div class="container-fluid">

        <?php
        $date = \Carbon\Carbon::today()->format('Y-m-d');
        ?>

        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Mpesa Collection</p>
                                    <h5 class="font-weight-bolder">
                                        Ksh {{$todaysMpesaCollection}}
                                    </h5>
                                    <p class="mb-0">
                                        <span
                                            class="text-success text-sm font-weight-bolder">{{$collectionPercentage}}%</span>
                                        since yesterday
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-mobile-button text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Vehicle's</p>
                                    <h5 class="font-weight-bolder">
                                        {{$customerCount}}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder"></span>
                                        since week one
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-ruler-pencil text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Credit</p>
                                    <h5 class="font-weight-bolder">
                                        Ksh {{$totalCustomerBalances}}
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-danger text-sm font-weight-bolder"></span>
                                        since last quarter
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                                    <h5 class="font-weight-bolder">
                                        $103,430
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div
                                    class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="card border">

                    <div class="card-body">
                        <form class='search-form row'>
                            <div class="col-sm-2 col-md-2">
                                <label>Search</label>
                                <input type="text" class="form-control mb-1" name="search" placeholder="Search">
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <label>From Date</label>
                                <input type="date" class="form-control mb-1" id="from_date" name="from_date">
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <label>From Time</label>
                                <input type="time" class="form-control mb-1" id="from_time" name="from_time" step="1">
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <label>To Date</label>
                                <input type="date" class="form-control mb-1" id="to_date" name="to_date">
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <label>To Time</label>
                                <input type="time" class="form-control mb-1" id="to_time" name="to_time" step="1">
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <label>Status</label>
                                <select name="status" class="form-control mb-1">
                                    <option value="">Select status...</option>
                                    @foreach ($statuses as $status)
                                        {
                                        <option value={{$status->id}}>{{$status->name}}</option>
                                        }
                                    @endforeach
                                </select>
                            </div>
                            <div class='col-sm-1 text-right'>
                                <button class='btn btn-primary m-2'>Search</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-sm-3 text-right">
                        <button class="btn btn-primary btn-sm launchVehicleModal" data-toggle="modal"
                                data-target="#vehicleModal">Add Vehicle
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Plate</th>
                                <th>Fleet #</th>
                                <th>Till #</th>
                                <th>Merchant Short Code</th>
                                <th>Vehicle</th>
                                <th>Status</th>
                                <th class='text-right not-export'>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid rgb(200,200,200);">
                    <h4 class="modal-title" id="exampleModalLabel">Manage Vehicle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="border-bottom: 1px solid rgb(200,200,200);">
                    <form action="{{url('vehicle/add')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <input type="hidden" name="id" class="form-control" value="0">
                                    <label>Number Plate</label>
                                    <input type="text" name="plate" class="form-control" placeholder="Number Plate"/>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group mb-2">
                                    <div class="form-group mb-2">
                                        <label>Fleet No</label>
                                        <input type="text" name="fleet_no" class="form-control" placeholder="Fleet No"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <div class="form-group mb-2">
                                        <input type="hidden" name="id" class="form-control" value="0">
                                        <label>Till #</label>
                                        <input type="number" name="till_number" class="form-control"
                                               placeholder="Till No"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <div class="form-group mb-2">
                                        <input type="hidden" name="id" class="form-control" value="0">
                                        <label>Merchant Short Code</label>
                                        <input type="number" name="merchant_short_code" class="form-control"
                                               placeholder="Till No"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sacco</label>
                                    <select name="sacco_id" class="form-control">
                                        @foreach($saccos as $sacco)
                                            <option
                                                value="{{$sacco->id}}">{{$sacco->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-2 pb-2">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btnSaveUser">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('from_date').valueAsDate = new Date();
        document.getElementById('from_time').value = "00:00:00";
        document.getElementById('to_date').valueAsDate = new Date();
        document.getElementById('to_time').value = "23:59:59";

        $(document).ready(function () {
            $('.launchVehicleModal').click(function () {
                $('#vehicleModal input[name="id"]').val(0);
                $('#vehicleModal input[name="plate"]').val("");
                $('#vehicleModal input[name="fleet_no"]').val("");
                $('#vehicleModal input[name="till_number"]').val("");
                $('#vehicleModal input[name="merchant_short_code"]').val("");
                $('#vehicleModal input[name="sacco_id"]');
                $('#vehicleModal input[name="status"]');
            });
            $(".btnSaveUser").click(function () {
                $('#vehicleModal form').submit();
            });


            $("#assignModal .btnSave").click(function () {
                $("#assignModal form").submit();
            });

            $(document).on("click", ".btnEditVehicle", function (e) {
                e.preventDefault();
                $(".btnSaveUser").attr("disabled", "disabled");
                var details = $(this).closest("tr");
                // var id = details.find(".id").text();
                var id = details.find("td:nth-child(1)").text();
                var plate = details.find("td:nth-child(2)").text();
                var fleet_no = details.find("td:nth-child(3)").text();
                var till_number = details.find("td:nth-child(4)").text();
                var merchant_short_code = details.find("td:nth-child(5)").text();
                var sacco_id = details.find("td:nth-child(6)").text();
                var status = details.find("td:nth-child(9)").text();

                $('#vehicleModal input[name="id"]').val(id);
                $('#vehicleModal input[name="plate"]').val(plate).attr('readonly', 'readonly');
                $('#vehicleModal input[name="fleet_no"]').val(fleet_no);
                $('#vehicleModal input[name="till_number"]').val(till_number);
                $('#vehicleModal input[name="merchant_short_code"]').val(merchant_short_code);
                $('#vehicleModal input[name="sacco_id"]').val(sacco_id);
                $('#vehicleModal input[name="status"]').val(status);
                $(".btnSaveUser").removeAttr("disabled");
            });


            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                oLanguage: {sProcessing: "<i class='fas fa-spinner fa-pulse'></i> Processing..."},
                dom: 'lBrtip',
                buttons: [
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file"></i> CSV',
                        className: 'btn btn-primary dt-button-right',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-primary dt-button-right',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    }, {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-primary dt-button-right',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        },
                        customize: function (doc) {
                            // Set the document properties
                            doc.info = {
                                title: 'Vehicle Report',
                            };

                            // Set the layout of the PDF
                            doc.content[0].layout = 'lightHorizontalLines'; // try 'lightHorizontalLines'

                            // Set the font size
                            doc.defaultStyle.fontSize = 10; // you can change the font size here

                            // Modify the title of the PDF
                            doc.content[0].text = 'Customer Report';
                        }
                    }
                ],
                "lengthMenu": [[20, 100, 250, 500, 1000], [20, 100, 250, 500, 1000]],
                ajax:
                    {
                        url: "{{ url('/datatables/vehicles') }}",
                        data: function (d) {
                            d.search = $('input[name=search]').val();
                            d.from_date = $('input[name=from_date]').val();
                            d.from_time = $('input[name=from_time]').val();
                            d.to_date = $('input[name=to_date]').val();
                            d.to_time = $('input[name=to_time]').val();
                            d.status = $('select[name=status]').val();
                            d.d = $('select[name=d]').val();
                            d.is_datable = true;
                        }
                    },
                columns: [
                    {data: "id", name: "id", orderable: false},
                    {data: "plate", name: "plate", orderable: false},
                    {data: "fleet_no", name: "fleet_no", orderable: false},
                    {data: "till_number", name: "till_number", orderable: false},
                    {data: "merchant_short_code", name: "merchant_short_code", orderable: false},
                    {
                        data: "sacco",
                        name: "sacco.name", // use dot notation here for the name property
                        orderable: false,
                        render: function (data, type, row) {
                            return data ? data.name : ''; // access the name property of the sacco object
                        }
                    },
                    {data: "status", name: "status", orderable: false},
                    {data: "action", name: "action", orderable: false}
                ]
            });
            $('.search-form').submit(function (e) {
                e.preventDefault();
                table.draw();
            });
            var timer = null;
            $('input[name=search]').keyup(function () {
                clearTimeout();
                timer = setTimeout(function () {
                    table.draw();
                }, 2000);
            });
            $('select[name=userrole]').change(function () {
                table.draw();
            });
        });
    </script>
@endpush
