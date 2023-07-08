@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Sacco'])
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Sacco's</p>
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
                                <label>Search Name</label>
                                <input type="text" class="form-control mb-1" name="msearch" placeholder="Search">
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
                        <button class="btn btn-primary btn-sm launchSaccoModal" data-toggle="modal"
                                data-target="#saccoModal">Add Sacco
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Motto</th>
                                <th>Paybill</th>
                                <th>Consumer Key</th>
                                <th>Consumer Secret</th>
                                <th>Passkey</th>
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
    <div class="modal fade" id="saccoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid rgb(200,200,200);">
                    <h4 class="modal-title" id="exampleModalLabel">Manage Sacco</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="border-bottom: 1px solid rgb(200,200,200);">
                    <form action="{{url('sacco/add')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <input type="hidden" name="id" class="form-control" value="0">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Sacco Name"/>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label>Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">+254</div>
                                        </div>
                                        <input type="number" name="phone_number" class="form-control"
                                               placeholder="Phone Number"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label>Sacco Motto/Slogan</label>
                                    <input type="text" name="motto" class="form-control"
                                           placeholder="Sacco Motto/Slogan"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label>Pay Bill</label>
                                    <input type="text" name="pay_bill" class="form-control" placeholder="Paybill"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label>Consumer Key</label>
                                    <input type="text" name="consumer_key" class="form-control"
                                           placeholder="Consumer Key"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label>Consumer Secret</label>
                                    <input type="text" name="consumer_secret" class="form-control"/>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group mb-2">
                                    <label>Passkey</label>
                                    <input type="text" name="passkey" class="form-control"/>
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
            $('.launchSaccoModal').click(function () {
                $('#saccoModal input[name="id"]').val(0);
                $('#saccoModal input[name="name"]').val("");
                $('#saccoModal input[name="phone_number"]').val("");
                $('#saccoModal input[name="motto"]').val("");
                $('#saccoModal input[name="pay_bill"]').val("");
                $('#saccoModal input[name="consumer_key"]');
                $('#saccoModal input[name="consumer_secret"]');
                $('#saccoModal input[name="pass_key"]');
                $('#saccoModal input[name="status"]');
            });
            $(".btnSaveUser").click(function () {
                $('#saccoModal form').submit();
            });


            $("#assignModal .btnSave").click(function () {
                $("#assignModal form").submit();
            });

            $(document).on("click", ".btnEditSacco", function (e) {
                e.preventDefault();
                $(".btnSaveUser").attr("disabled", "disabled");
                var details = $(this).closest("tr");
                // var id = details.find(".id").text();
                var id = details.find("td:nth-child(1)").text();
                var name = details.find("td:nth-child(2)").text();
                var phone_number = details.find("td:nth-child(3)").text();
                var motto = details.find("td:nth-child(4)").text();
                var pay_bill = details.find("td:nth-child(5)").text();
                var consumer_key = details.find("td:nth-child(6)").text();
                var consumer_secret = details.find("td:nth-child(7)").text();
                var passkey = details.find("td:nth-child(8)").text();
                var status = details.find("td:nth-child(9)").text();

                $('#saccoModal input[name="id"]').val(id);
                $('#saccoModal input[name="name"]').val(name).attr('readonly', 'readonly');
                $('#saccoModal input[name="phone_number"]').val(phone_number);
                $('#saccoModal input[name="motto"]').val(motto);
                $('#saccoModal input[name="pay_bill"]').val(pay_bill);
                $('#saccoModal input[name="consumer_key"]').val(consumer_key);
                $('#saccoModal input[name="consumer_secret"]').val(consumer_secret);
                $('#saccoModal input[name="passkey"]').val(passkey);
                $('#saccoModal input[name="status"]').val(status);
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
                                title: 'Sacco Report',
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
                        url: "{{ url('/datatables/saccos') }}",
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
                    {data: "name", name: "name", orderable: false},
                    {data: "phone_number", name: "phone_number", orderable: false},
                    {data: "motto", name: "motto", orderable: false},
                    {data: "pay_bill", name: "pay_bill", orderable: false},
                    {data: "consumer_key", name: "consumer_key", orderable: false},
                    {data: "consumer_secret", name: "consumer_secret", orderable: false},
                    {data: "passkey", name: "passkey", orderable: false},
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
