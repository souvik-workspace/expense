@include('admin.includes.header')
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.includes.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.includes.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">View Expenses</h1>
                    </div>

                    <div class="row">

                        <div class="col-lg-12">
                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-2 font-weight-bold text-primary float-left">Expense list for {{$user->name}}</h6>
                                    <a href="{{url('admin/viewUser')}}" class="float-right btn btn-warning">Back</a>
                                </div>
                                <div class="card-header py-2">
                                    <div class="col-4 p-0 float-left">
                                        <h6 class="m-2 font-weight-bold text-success ">Today Expenses : <span style="color:grey;">₹ {{$today_expenses}}</span></h6>
                                    </div>
                                    <div class="col-4 p-0 float-left">
                                        <h6 class="m-2 font-weight-bold text-warning ">Monthly Expenses : <span style="color:grey;">₹ {{$monthly_expenses}}</span></h6>
                                    </div>
                                    <div class="col-4 p-0 float-left">
                                        <h6 class="m-2 font-weight-bold text-danger ">Total Expenses : <span style="color:grey;">₹ {{$total_expenses}}</span></h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Sl No.</th>
                                                    <th>Expenses Date</th>
                                                    <th>Group Name</th>
                                                    <th>Item Name</th>
                                                    <th>Amount</th>
                                                    <th>Pay Method</th>
                                                    <th>Note</th>                                                    
                                                    {{-- <th>Edit</th>
                                                    <th>Delete</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($expenses as $key => $row)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$row->expense_date}}</td>
                                                    <td>{{$row->group_name}}</td>
                                                    <td>{{$row->item_name}}</td>
                                                    <td>{{$row->amount}}</td>
                                                    <td>{{$row->pay_method}}</td>
                                                    <td>{{$row->note}}</td>                                                    
                                                    {{-- <td><a href="{{url('editExpense/'.$row->id)}}" class="btn btn-primary">Edit</a></td>
                                                    <td><a href="{{url('delExpense/'.$row->id)}}" class="btn btn-warning" onclick="return confirm(' you want to delete?');">Delete</a></td> --}}
                                                </tr> 
                                                @endforeach                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


@include('admin.includes.footer')