<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary head elements -->
    @include('admin.layout.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <!-- Include Navbar -->
    @include('admin.layout.navbar')
    <!-- Sidebar menu-->
    @include('admin.layout.sidebar')
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <main class="app-content">
        <div class="app-title">
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><a href="{{ route('contacts.index') }}"><b>Contacts List</b></a></li>
                <li class="breadcrumb-item active"><b>Contact Details</b></li>
            </ul>
            <div id="clock"></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <h3 class="tile-title">Contact Details</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $contact->id }}</td>
                                </tr>
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $contact->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $contact->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th>Contact Subject</th>
                                    <td>{{ $contact->contact_subject }}</td>
                                </tr>
                                <tr>
                                    <th>Contact Message</th>
                                    <td>{{ $contact->contact_message }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($contact->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($contact->status == 'processed')
                                            <span class="badge bg-success">Processed</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created Time</th>
                                    <td>{{ $contact->created_at }}</td>
                                </tr>
                            </table>
                        </div>
                        <a href="{{ route('contacts.index') }}" class="btn btn-primary mt-3"
                            style="padding: 0.500rem; margin-right:120px">Back to Contacts List</a>
                        <a href="mailto:{{ $contact->customer_email }}?subject=Response [{{ $contact->contact_subject }}]&body=Hello, {{ $contact->customer_name }},%0D%0A%0D%0A"
                            class="btn btn-success mt-3 ml-2" style="padding: -0.500rem">Reply Customer</a>
                        <a href="{{ route('contacts.updateStatus', $contact->id) }}"
                            style="padding: -0.500rem" class="btn btn-info mt-3 ml-2" title="Change Status">Change Status</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Include Footer -->
    @include('admin.layout.footer')

    <script>
        // Hàm cập nhật đồng hồ
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString();
            document.getElementById('clock').innerHTML = time;
        }

        // Gọi hàm updateClock khi trang tải
        window.onload = function() {
            updateClock();
            setInterval(updateClock, 1000);
        };
    </script>

</body>

</html>
