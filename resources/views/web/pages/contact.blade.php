<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Contact</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">

    <style>
        /* Đảm bảo modal được hiển thị ở giữa màn hình */
        .modal-dialog {
            top: 20%;
        }
    </style>
</head>

<body>
    @include('web.layouts.header')

    <div class="contact-main-page mt-60 mb-40 mb-md-40 mb-sm-40 mb-xs-40">
        <div class="container mb-60">
            <!-- Nhúng Google Maps qua iframe -->
            <iframe
                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDaOulQACiJzBfqumbsqg_-vKha8fCnL-s&q=10.78638265263099,106.66604740363539"
                width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="">
            </iframe>

        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-5 offset-lg-1 col-md-12 order-1 order-lg-2">
                    <div class="contact-page-side-content">
                        <h3 class="contact-page-title">Contact Us</h3>
                        <p class="contact-page-message mb-25">If you have any questions about our products like laptops,
                            PlayStation, or DualSense controllers, feel free to reach out to us! Our team is always
                            ready to assist you with your shopping experience.</p>
                        <div class="single-contact-block">
                            <h4><i class="fa fa-map-marker"></i> Address</h4>
                            <p>
                                <a href="https://www.google.com/maps?q=10.78638265263099,106.66604740363539"
                                    target="_blank">
                                    590 Cách Mạng Tháng 8 Street, Ward 11, District 3, Ho Chi Minh City, Vietnam
                                </a>
                            </p>

                        </div>
                        <div class="single-contact-block">
                            <h4><i class="fa fa-phone"></i> Phone</h4>
                            <p>Mobile: <a href="tel:+84931313229">(+84) 981 578 920</a></p>
                            <p>Hotline: <a href="tel:+84911789450">(+84) 931 313 329</a> (for urgent inquiries)</p>
                        </div>
                        <div class="single-contact-block last-child">
                            <h4><i class="fa fa-envelope-o"></i> Email</h4>
                            <p>For general inquiries: <a href="mailto:aptech.fpt@fe.edu.vn">aptech.fpt@fe.edu.vn</a></p>
                            <p>For support: <a href="mailto:support@fe.edu.vn">support@fe.edu.vn</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 order-2 order-lg-1">
                    <div class="contact-form-content pt-sm-55 pt-xs-55">
                        <h3 class="contact-page-title">Tell Us Your Message</h3>
                        <div class="contact-form">
                            <form id="contact-form" action="{{ url('/contact') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Your Name <span class="required">*</span></label>
                                    <input type="text" name="customerName" id="customername" required>
                                </div>
                                <div class="form-group">
                                    <label>Your Email <span class="required">*</span></label>
                                    <input type="email" name="customerEmail" id="customerEmail" required>
                                </div>
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" name="contactSubject" id="contactSubject">
                                </div>
                                <div class="form-group mb-30">
                                    <label>Your Message</label>
                                    <textarea name="contactMessage" id="contactMessage"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" value="submit" id="submit" class="li-btn-3"
                                        name="submit">send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thông báo gửi thành công -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your message has been sent successfully! We will get back to you soon.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('web.layouts.footer')

    @include('web.layouts.css-script')

    <!-- Thêm Bootstrap JS và Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Hiển thị modal khi gửi thành công
        @if (session('success'))
            var myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
        @endif
    </script>

</body>

</html>
