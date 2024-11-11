<!doctype html>
<html class="no-js" lang="eng">

<!-- account:31:27-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>My Account</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>

    <div class="body-wrapper">

        @include('web.layouts.header')

        <!-- Check if user is logged in -->
        @if(auth()->check())
            <!-- Display success message -->
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="breadcrumb-area">
                <div class="container">
                    <div class="breadcrumb-content">
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li class="active">Account</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="page-section mb-60">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-10 mb-30">
                            <h2 class="account-title text-center mb-4">{{ $user->Name }}</h2>
                            <form action="{{ route('user.update') }}" method="POST" class="account-form">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group mb-4">
                                                    <label for="full_name" class="account-info-label">Full Name:</label>
                                                    <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $user->Name }}">
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="email" class="account-info-label">Email Address:</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->Email }}" readonly>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="phone" class="account-info-label">Phone Number:</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->Phone }}">
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="address" class="account-info-label">Address:</label>
                                                    <textarea class="form-control" id="address" name="address">{{ $user->Address }}</textarea>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="password" class="account-info-label">Password:</label>
                                                    <input type="password" class="form-control" id="password" name="password">
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="password_confirmation" class="account-info-label">Confirm Password:</label>
                                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4 text-center mt-4"> <!-- Added mt-4 for spacing -->
                                    <button type="submit" class="btn btn-primary mr-2 mb-2" style="width: 50%;" onclick="alert('Update successful!')">Update Profile</button>
                                </div>
                                <div class="form-group mb-4 text-center mt-4"> <!-- Added mt-4 for spacing -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @include('web.layouts.footer')
        @else
            <div class="alert alert-info text-center" style="background-color: #f8f9fa; border-color: #f8f9fa; color: #6B7280;">
                Please login to view your account information. <a href="{{ route('login.register') }}" class="alert-link">Login/Register</a>
            </div>
            @include('web.layouts.footer')
        @endif

    </div>

    @include('web.layouts.css-script')
</body>

</html>
