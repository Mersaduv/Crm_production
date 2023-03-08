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

    <body>


        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">

            <div class="card">
                <div class="card-body">

                    <div class="text-center">
                        <a href="index.html" class="logo logo-admin">
                            <img src="{{ asset('/public/assets/images/logo.png') }}" width="150" height="auto"
                                alt="logo">
                        </a>
                    </div>

                    @include('messages.message')

                    <div class="px-3 pb-3">
                        <form class="form-horizontal m-t-20" method="post" action="{{ route('signIn') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="text" required="" name="email"
                                        placeholder="Email" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="password" name="password" required=""
                                        placeholder="Password" />
                                </div>
                            </div>

                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-danger btn-block waves-effect waves-light" type="submit">Log
                                        In</button>
                                </div>
                            </div>

                            {{-- <div class="form-group m-t-10 mb-0 row">
                                <div class="col-sm-7 m-t-20">
                                    <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i>
                                        <small>Forgot your password ?</small></a>
                                </div>
                                <div class="col-sm-5 m-t-20">
                                    <a href="{{ route('register') }}" class="text-muted"><i
                                            class="mdi mdi-account-circle"></i> <small>Create an account ?</small></a>
                                </div>
                            </div> --}}

                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- jQuery  -->
        @include('partials.scripts')

    </body>

</html>