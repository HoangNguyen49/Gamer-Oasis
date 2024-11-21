<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Payment Guide</title>
    <meta name="description" content="Detailed guide on the payment process.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('asset/images/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">
    <style>
        .body-wrapper {
            background-color: #f9f9f9;
            line-height: 1.6;
            color: #333;
        }
        .frequently-area {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .frequently-content {
            margin-bottom: 20px;
        }
        .frequently-desc {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .frequently-accordion {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-header {
            background-color: #f9f9f9;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            color: #333;
        }
        .card-body {
            padding: 15px;
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }
        .frequently-accordion .card-header a:after {
            font-family: "Font Awesome 5 Free";
            content: "\f107";
            float: right;
            color: #777;
        }
        .frequently-accordion .card-header a.collapsed:after {
            content: "\f105";
        }
    </style> 
</head>
<body>
        @include('web.layouts.header')
        <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="active">Payment Guide</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="frequently-area pt-60 pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="frequently-content">
                            <div class="frequently-desc">
                                <h3 style="font-size: 26px; line-height: 1.4; color: #007bff; text-align: center;">PAYMENT GUIDE</h3>
                                <p style="font-size: 18px; line-height: 1.6; color: #333;">Welcome to our payment guide! Below are the detailed steps for you to complete your transaction easily and quickly. Please follow each step to ensure that you do not miss any important information.</p>
                            </div>
                        </div>
                        <div class="frequently-accordion">
                            <div id="accordion">
                                <div class="card actives">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <a class="" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Step 1: Choose a product and add to cart
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                            To start, browse through the products on our website. When you find a product you like, click the "Add to Cart" button. You can continue shopping or go to the cart to review the selected products. Make sure you have selected the correct size and color before adding to the cart.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Step 2: Review the cart
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                            In the cart, you will see a list of all the products you have selected. Please check the quantity and type of products carefully. If you want to change the quantity or remove any product, please do so here. Don't forget to check the total order value before proceeding! If you have a discount code, please enter it in the corresponding box to receive the offer.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h5 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Step 3: Enter shipping information
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                        <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                            Please fill in your complete shipping information, including name, address, phone number, and email. This information is very important so that we can deliver to the correct address and contact you when necessary. Ensure that all information is accurate to avoid any issues during delivery. If you have special requests regarding delivery, please note them in this section.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingFour">
                                        <h5 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                Step 4: Choose a payment method
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                        <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                            We offer various payment methods such as credit card, bank transfer, and cash on delivery (COD). Below are detailed instructions for two popular methods:

                                            <h6>1. Payment via VNPAY:</h6>
                                            <p>When choosing the payment method via VNPAY, you will be redirected to VNPAY's secure payment page. Here, you need to enter your credit card information, including card number, expiration date, and CVV. After completing, click the "Pay" button to finalize the transaction. You will receive a confirmation notification via email as soon as the transaction is successful. Please ensure that you have double-checked your card information before submitting.</p>

                                            <h6>2. Cash on delivery (COD):</h6>
                                            <p>With the COD method, you will pay directly to the delivery staff upon receiving the product. Please prepare cash or a card for payment. Ensure that you are present at the delivery address at the scheduled time to receive the goods and make the payment. If you cannot be present, please inform us to reschedule.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingFive">
                                        <h5 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                Step 5: Confirm the order
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                        <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                            Before finalizing, please check all your order information once again. If everything is correct, click the "Confirm" button to complete the transaction. You will receive an order confirmation email as soon as the transaction is successful. If you do not receive the email, please check your spam folder or contact us for assistance.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingSix">
                                        <h5 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                Step 6: Track your order
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                                        <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                            After placing an order, you can track the status of your order through our website. We will send you notifications about the delivery status, and you can contact us if you have any questions. Please keep your order code for easy reference.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @include('web.layouts.footer')
    </div>
    @include('web.layouts.css-script')
</body>
</html>