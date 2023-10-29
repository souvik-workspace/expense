@include('admin.includes.header')
<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image">
                        <img src="{{asset('img/exp.jpg')}}" alt="" srcset="" style="width:100%;height: 100%;">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form action="{{url('userReg')}}" method="POST" class="user regform">
                                @csrf
                                <div class="form-group row regformInput">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="username" name="username"
                                            placeholder="User Name">
                                        <span class="errorMsg">{{$errors->first('username')}}</span>  
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="name" name ="name"
                                            placeholder="Your Name">
                                            <span class="errorMsg">{{$errors->first('name')}}</span> 
                                    </div>
                                </div>
                                <div class="form-group row regformInput">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="mobile" name="mobile"
                                            placeholder="Mobile Number">
                                        <span class="errorMsg">{{$errors->first('mobile')}}</span> 
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" class="form-control form-control-user" id="email" name="email"
                                        placeholder="Email Address">
                                        <span class="errorMsg">{{$errors->first('email')}}</span>
                                    </div>
                                </div>
                                <div class="form-group row regformInput">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" name ="password"
                                            id="password" placeholder="Password">
                                        <span class="errorMsg">{{$errors->first('password')}}</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name ="cnfpassword"
                                            id="cnfpassword" placeholder="Repeat Password">
                                        <span class="errorMsg">{{$errors->first('cnfpassword')}}</span>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Register Account" name="submit">
                                <hr>
                                
                            </form>
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
                            <hr>
                            <div class="text-center">
                                <a class="small" href="javascript:;">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{url('/')}}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@include('admin.includes.footer')