<!doctype html>
<html class="no-js" lang="eng">

<!-- login-register31:27-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login Register</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <div class="body-wrapper">

        @include('web.layouts.header')

        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Login Register</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-section mb-60">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb-30">
                        <!-- Login Form s-->
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="login-form">
                                <h4 class="login-title">Login</h4>
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-20">
                                        <label>Email Address*</label>
                                        <input class="mb-0" type="email" name="email" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 mb-20">
                                        <label>Password</label>
                                        <input class="mb-0" type="password" name="password" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <button class="register-button mt-0" type="submit">Login</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                        <form action="{{ route('users.store') }}" method="POST" class="row">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="login-form">
                                <h4 class="login-title">Register</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-20">
                                        <label>First Name</label>
                                        <input class="mb-0" type="text" placeholder="First Name" name="first_name"
                                            required>
                                    </div>
                                    <div class="col-md-6 col-12 mb-20">
                                        <label>Last Name</label>
                                        <input class="mb-0" type="text" placeholder="Last Name" name="last_name"
                                            required>
                                    </div>
                                    <div class="col-md-12 mb-20">
                                        <label>Email Address*</label>
                                        <input class="mb-0" type="email" placeholder="Email Address" name="email"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label>Password</label>
                                        <input class="mb-0" type="password" placeholder="Password" name="password"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-20">
                                        <label>Confirm Password</label>
                                        <input class="mb-0" type="password" placeholder="Confirm Password"
                                            name="password_confirmation" required>
                                    </div>
                                    <input type="hidden" name="role" value="customer">
                                    <div class="col-12">
                                        <button class="register-button mt-0" type="submit">Register</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Add Logout Form Here -->
                    <div class="col-12 mb-20">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('web.layouts.footer')

    </div>

    @include('web.layouts.css-script')
</body>



</html>
