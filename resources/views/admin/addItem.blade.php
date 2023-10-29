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
                        <h1 class="h3 mb-0 text-gray-800">Add Item</h1>
                    </div>

                    <div class="row"> 

                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Add Item</h6>
                                </div>
                                <div class="card-body" style="min-height:300px;">
                                    <div class="container">
                                        <form action="{{url('admin/addItems')}}" method="POST">
                                            @csrf
                                          <div class="form-group">
                                            <label for="item_name">Item Name:</label>
                                            <input type="text" name="item_name" class="form-control" id="item_name" placeholder="Enter Item Name">
                                            <span class="errorMsg">{{$errors->first('item_name')}}</span>
                                          </div>
                                          <div class="form-group">
                                            <label for="group_id">Group:</label>                                            
                                            <select name="group_id" class="form-control" id="group_id">
                                            <option value="">Select Group</option>
                                            @if(!empty($groups))
                                            @foreach($groups as $row)
                                                <option value="{{$row->id}}">{{$row->group_name}}</option>
                                            @endforeach
                                            @endif
                                            </select>
                                            <span class="errorMsg">{{$errors->first('group_name')}}</span>
                                          </div>
                                          @if (\Session::has('success'))
                                            <div class="alert alert-success">
                                                <ul>
                                                    <li>{!! \Session::get('success') !!}</li>
                                                </ul>
                                            </div>
                                        @endif
                                        @if (\Session::has('error'))
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <li>{!! \Session::get('error') !!}</li>
                                                </ul>
                                            </div>
                                        @endif  
                                          <button type="submit" name="submit" value="submit" class="btn btn-success">Submit</button>
                                          <button class="btn btn-warning"onclick="history.back()">Back</button>
                                        </form>                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Total Items</h6>
                                </div>
                                <div class="card-body" style="min-height:300px;">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Items </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 display-2">
                                                <?php
                                                if(!empty($total_item)){
                                                    echo $total_item;
                                                }else{
                                                    echo "0";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
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