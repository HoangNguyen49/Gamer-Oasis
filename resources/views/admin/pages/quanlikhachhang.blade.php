<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary head elements -->
    @include('admin.layout.head')
    
</head>

<body>
    <!-- Include Navbar -->
    @include('admin.layout.navbar')

    <div class="app-wrapper">
        <!-- Include Sidebar -->
        @include('admin.layout.sidebar')

        <main class="app-content">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb side">
                    <li class="breadcrumb-item active"><a><b>Customer List</b></a></li>
                </ul>
                
                <div id="clock"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">

                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th width="10"><input type="checkbox" id="all"></th>
                                        <th>Customer_Id</th>
                                        <th>Customer_Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Function</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach ($users as $user)
                                        @if($user->Role == 'customer')
                                            <tr
                                                onclick="showCustomerDetails({{ $user->User_id }}, '{{ $user->Name }}', '{{ $user->Email }}', '{{ $user->Phone }}', '{{ $user->Address }}', '{{ $user->created_at }}')">
                                                <!-- Thêm sự kiện click vào hàng -->
                                                <td width="10"><input type="checkbox" name="check1"
                                                        value="{{ $user->User_id }}"></td> 
                                                <td>{{ $user->User_id }}</td> 
                                                <td>{{ $user->Name }}</td> 
                                                <td>{{ $user->Email }}</td> 
                                                <td>{{ $user->Phone }}</td> 
                                                <td>{{ $user->Address }}</td> 
                                                <td>
                                                   
                                                    <div class="text-center">
                                                        <button class="btn btn-primary btn-sm" type="button" title="Detail" data-toggle="modal" data-target="#customerModal{{ $user->User_id }}"><i class="fas fa-eye"></i></button>
                                                    </div>
                                                    <div class="modal fade" id="customerModal{{ $user->User_id }}" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel{{ $user->User_id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="customerModalLabel{{ $user->User_id }}" style="font-weight: bold; color: #4CAF50;">Customer Details</h4>
                                                                   
                                                                </div>
                                                                <div class="modal-body" style="padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group mb-4">
                                                                                <label for="name" class="font-bold text-dark" style="font-size: 18px; margin-bottom: 10px;"><strong>Name:</strong></label>
                                                                                <p id="name" class="text-gray-800" style="font-size: 16px; color: #333; margin-bottom: 20px;">{{ $user->Name }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="email" class="font-bold text-dark" style="font-size: 18px; margin-bottom: 10px;"><strong>Email:</strong></label>
                                                                                <p id="email" class="text-gray-800" style="font-size: 16px; color: #333; margin-bottom: 20px;">{{ $user->Email }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="phone" class="font-bold text-dark" style="font-size: 18px; margin-bottom: 10px;"><strong>Phone:</strong></label>
                                                                                <p id="phone" class="text-gray-800" style="font-size: 16px; color: #333; margin-bottom: 20px;">{{ $user->Phone }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="address" class="font-bold text-dark" style="font-size: 18px; margin-bottom: 10px;"><strong>Address:</strong></label>
                                                                                <p id="address" class="text-gray-800" style="font-size: 16px; color: #333; margin-bottom: 20px;">{{ $user->Address }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="registeredOn" class="font-bold text-dark" style="font-size: 18px; margin-bottom: 10px;"><strong>Registered On:</strong></label>
                                                                                <p id="registeredOn" class="text-gray-800" style="font-size: 16px; color: #333; margin-bottom: 20px;">{{ $user->created_at }}</p>
                                                                            </div>
                                                                            <div class="form-group mb-4">
                                                                                <label for="role" class="font-bold text-dark" style="font-size: 18px; margin-bottom: 10px;"><strong>Role:</strong></label>
                                                                                <p id="role" class="text-gray-800" style="font-size: 16px; color: #333; margin-bottom: 20px;">{{ $user->Role }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer" style="background-color: #f9f9f9; border-top: 1px solid #ddd; padding: 10px; text-align: right;">
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal" style="padding: 10px 20px; font-size: 16px; border-radius: 5px;">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    </div>
    @include('admin.layout.footer')
    </div>

</html>
