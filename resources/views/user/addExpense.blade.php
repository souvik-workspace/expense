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
                        <h1 class="h3 mb-0 text-gray-800">Add Expense</h1>
                    </div>

                    <div class="row"> 

                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Add Expense</h6>
                                </div>
                                <div class="card-body" style="min-height:200px;">
                                    <div class="container">
                                        <form action="{{url('addExpenses')}}" method="POST">
                                            @csrf  
                                            <div class="form-group">
                                                <label for="expense_date">Expense Date:</label>
                                                <input type="datetime-local" name="expense_date" class="form-control" id="expense_date" style="color: red" value="<?php echo date("Y-m-d\TH:i", strtotime("now")); ?>" placeholder="Enter expense date">
                                                <span class="errorMsg">{{$errors->first('expense_date')}}</span>
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
                                            <span class="errorMsg">{{$errors->first('group_id')}}</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="item_id">Item:</label>                                            
                                                <select name="item_id" class="form-control" id="item_id">                                            
                                                </select> 
                                                <span class="errorMsg">{{$errors->first('item_id')}}</span>                                           
                                            </div>

                                            <div class="form-group">
                                                <label for="amount">Amount:</label>
                                                <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter expenses amount">
                                                <span class="errorMsg">{{$errors->first('amount')}}</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="pay_method">Payment Method:</label>                                            
                                                <select name="pay_method" class="form-control" id="pay_method"> 
                                                    <option value="cash">Cash</option>                                           
                                                    <option value="bank">Bank</option>                                           
                                                </select>    
                                                <span class="errorMsg">{{$errors->first('pay_method')}}</span>                                        
                                            </div>

                                            <div class="form-group">
                                                <label for="note">Note:</label>
                                                <input type="text" name="note" class="form-control" id="note" placeholder="Enter any note">
                                                <span class="errorMsg">{{$errors->first('note')}}</span>
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
                                        </form>                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Expenses Record</h6>
                                </div>
                                <div class="card-body" style="min-height:200px;">
                                    <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Today Expenses </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 display-5">
                                                <?php
                                                if(!empty($today_expenses)){
                                                    echo "₹ ".$today_expenses;
                                                }else{
                                                    echo "₹ 0";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Current Month Expenses</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 display-5">
                                                <?php
                                                if(!empty($monthly_expenses)){
                                                    echo "₹ ".$monthly_expenses;
                                                }else{
                                                    echo "₹ 0";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Total Expenses </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 display-5">
                                                <?php
                                                if(!empty($total_expenses)){
                                                    echo "₹ ".$total_expenses;
                                                }else{
                                                    echo "₹ 0";
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

            

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
           
            $('#group_id').on('change', function () {
                var group_id = this.value; 
                $("#item_id").html('');
                $.ajax({
                    url: '/getItem/'+group_id,
                    type: "GET",
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        $('#item_id').html('<option value="">-- Select Item --</option>');
                        $.each(result, function (key, value) {
                            $("#item_id").append('<option value="' + value
                                .id + '">' + value.item_name + '</option>');
                        });                        
                    }
                });
            });  
        });
    </script>

    

@include('user.includes.footer')