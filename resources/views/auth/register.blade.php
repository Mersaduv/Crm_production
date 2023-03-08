<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>CRM</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="assets/images/favicon.ico">
        @include('partials.stylesheet')

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">

            <div class="card">
                <div class="card-body">

                    <div class="text-center">
                        <a href="index.html" class="logo logo-admin">
                        	<img src="{{ asset('/public/assets/images/logo.png') }}" 
                        		 width="150" height="auto" alt="logo">
                        </a>
                    </div>

                    @include('messages.message')

                    <div class="p-3">
                        <form class="form-horizontal" method="post" action="{{ route('signUp') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" 
                                           type="text" 
                                           name="name" 
                                           required="required" 
                                           placeholder="Full Name" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" 
                                           type="email" 
                                           name="email" 
                                           required="required" 
                                           placeholder="Email" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <select class="form-control" name="role" required="required">
                                        <option value="">Select Role:</option>
                                        <option value="manager">Manager</option>
                                        <option value="finance">Finance</option>
                                        <option value="noc">NOC</option>
                                        <option value="sales">Sales</option>
                                        <option value="support">Support</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" 
                                    	   type="password"
                                           name="password" 
                                    	   required="required" 
                                    	   placeholder="Password" />
                                </div>
                            </div>

                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Register</button>
                                </div>
                            </div>

                            <div class="form-group m-t-10 mb-0 row">
                                <div class="col-12 m-t-20 text-center">
                                    <a href="{{ route('login') }}" class="text-muted">
                                        Already have account?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- jQuery  -->
        @include('partials.scripts')

    </body>
</html>