<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    @include('admin.layout.navbar')

    <div class="app-wrapper">
        @include('admin.layout.sidebar')

        <main class="app-content">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb side">
                    <li class="breadcrumb-item active"><a href="{{ route('contacts.index') }}"><b>Contacts List</b></a></li>
                </ul>
                <div id="clock"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row element-button">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <form action="{{ route('contacts.index') }}" method="GET" class="form-inline mb-3">
                                        <input style="height:32px" type="text" name="search" class="form-control mr-2" placeholder="Customer Name/Subject" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary" style="height:32px;">Search</button>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Contact Subject</th>
                                        <th>Status</th>
                                        <th>Created Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->id }}</td>
                                            <td>{{ $contact->customer_name }}</td>
                                            <td>{{ $contact->customer_email }}</td>
                                            <td>{{ $contact->contact_subject }}</td>
                                            <td>
                                                @if ($contact->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($contact->status == 'processed')
                                                    <span class="badge bg-success">Processed</span>
                                                @endif
                                            </td>
                                            <td>{{ $contact->created_at }}</td>
                                            <td>
                                                <a href="{{ route('contacts.showDetail', $contact->id) }}" class="btn btn-primary btn-sm view" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('contacts.updateStatus', $contact->id) }}" class="btn btn-primary btn-sm view" title="Change Status">
                                                    <i class="fa-solid fa-arrows-rotate"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Phân trang -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p>There are {{ $contacts->total() }} contacts currently</p>
                                        </div>
                                        <div>
                                            <nav>
                                                <ul class="pagination">
                                                    {{-- Nút đến trang đầu tiên --}}
                                                    @if ($contacts->currentPage() > 1)
                                                        <li><a href="{{ $contacts->url(1) }}">&laquo;</a></li>
                                                    @endif

                                                    {{-- Nút quay lại --}}
                                                    @if ($contacts->onFirstPage())
                                                        <li class="disabled"><span>&lt;</span></li>
                                                    @else
                                                        <li><a href="{{ $contacts->previousPageUrl() }}">&lt;</a></li>
                                                    @endif

                                                    {{-- Các nút phân trang --}}
                                                    @foreach ($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
                                                        <li class="{{ $page == $contacts->currentPage() ? 'active' : '' }}">
                                                            <a href="{{ $url }}">{{ $page }}</a>
                                                        </li>
                                                    @endforeach

                                                    {{-- Nút tiếp theo --}}
                                                    @if ($contacts->hasMorePages())
                                                        <li><a href="{{ $contacts->nextPageUrl() }}">&gt;</a></li>
                                                    @else
                                                        <li class="disabled"><span>&gt;</span></li>
                                                    @endif

                                                    {{-- Nút đến trang cuối cùng --}}
                                                    @if ($contacts->currentPage() < $contacts->lastPage())
                                                        <li><a href="{{ $contacts->url($contacts->lastPage()) }}">&raquo;</a></li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('admin.layout.footer')
        
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString();
            document.getElementById('clock').innerHTML = time;
        }

        window.onload = function() {
            updateClock();
            setInterval(updateClock, 1000);
        };
    </script>
</body>

</html>
