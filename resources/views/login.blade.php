@extends('layouts.simple')

@section('content')


<div class="container" id="login-form">
    <a href="index.html" class="login-logo"><img src="assets/img/logo-big.png"></a>
    <div class="row">
        <form action="{{ url('/') }}/login" class="form-horizontal" method="post" id="validate-form">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>Login Form</h2>
                    </div>
                    <div class="panel-body">


                        <div class="form-group mb-md">
                            <div class="col-xs-12">
                                <div class="input-group">							
                                    <span class="input-group-addon">
                                        <i class="ti ti-user"></i>
                                    </span>
                                    <!--{!! Form::text('email', null, ['class' => 'form-control']) !!}-->
                                    <input type="text" name="email" class="form-control" placeholder="Username" data-parsley-minlength="6" placeholder="At least 6 characters" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-md">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="ti ti-key"></i>
                                    </span>
                                    <!--{!! Form::password('password', null, ['class' => 'form-control']) !!}-->
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <div class="clearfix">
                            <a href="extras-registration.html" class="btn btn-default pull-left">Register</a>
                            <!--<a href="extras-login.html" class="btn btn-primary pull-right">Login</a>-->
                            <button name="submit" class="btn btn-primary pull-right">Login</button>
                            <!--<input type="submit" name="submit" value="Login" class="btn btn-primary pull-right" />-->
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="#" class="btn btn-label btn-social btn-facebook mb-md"><i class="ti ti-facebook"></i>Connect with Facebook</a>
                    <a href="#" class="btn btn-label btn-social btn-twitter mb-md"><i class="ti ti-twitter"></i>Connect with Twitter</a>
                </div>
            </div>
        </form>
    </div>
</div>




@endsection