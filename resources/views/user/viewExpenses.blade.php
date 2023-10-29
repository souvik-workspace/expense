@include('user.includes.header')
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('user.includes.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('user.includes.topbar')
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
                                    <h6 class="m-0 font-weight-bold text-primary">Expense list</h6>
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
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($expenses as $key => $row)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td><?php echo date('d-M-y',strtotime($row->expense_date));?></td>
                                                    <td>{{$row->group_name}}</td>
                                                    <td>{{$row->item_name}}</td>
                                                    <td>{{$row->amount}}</td>
                                                    <td>{{$row->pay_method}}</td>
                                                    <td>{{$row->note}}</td>                                                    
                                                    <td><a href="{{url('editExpense/'.$row->id)}}" class="btn btn-primary">Edit</a></td>
                                                    <td><a href="{{url('delExpense/'.$row->id)}}" class="btn btn-warning" onclick="return confirm(' you want to delete?');">Delete</a></td>
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


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


@include('user.includes.footer')