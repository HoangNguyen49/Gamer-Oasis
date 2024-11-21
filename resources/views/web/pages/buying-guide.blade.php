<!doctype html>
<html class="no-js" lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Technology Purchase Guide</title>
        <meta name="description" content="Detailed guide on how to effectively purchase technology products.">
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
        <div class="body-wrapper">
            @include('web.layouts.header')
            <div class="breadcrumb-area">
                <div class="container">
                    <div class="breadcrumb-content">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li class="active">Buying Guide</li>
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
                                    <h3 style="font-size: 26px; line-height: 1.4; color: #007bff; text-align: center;">PURCHASE GUIDE</h3>
                                    <p style="font-size: 18px; line-height: 1.6; color: #333;">Welcome to our purchase guide! Below are the essential steps for you to make transactions easily and effectively. Let's explore!</p>
                                </div>
                            </div>
                            <div class="frequently-accordion">
                                <div id="accordion">
                                    <div class="card actives">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <a class="" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Step 1: Register an Account
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                                To get started, you need to create an account on our website. This helps you track orders, receive notifications, and enjoy special offers. 
                                                <br> 
                                                Just fill in basic information such as name, email address, and phone number. Make sure to use a strong password to protect your account. 
                                                <br>
                                                Once completed, you can start using your account immediately.
                                                <br>
                                                <strong>Note:</strong> If you already have an account, please log in to save time.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Step 2: Explore Technology Products
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                            <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                                Browse through our diverse range of technology products. You can use the search function to find products by name, type, or price. 
                                                <br>
                                                Don't forget to check reviews from other customers to make the best decision! If you need more information, click on each product to see detailed descriptions, images, and specifications. 
                                                <br>
                                                If you have questions about the product, use the Q&A function or contact our customer support.
                                                <br>
                                                <strong>Tip:</strong> Save your favorite products to your wishlist for easy access later.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Step 3: Add to Cart
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                                Once you have selected your desired technology products, add them to your cart. You can continue shopping or proceed to checkout immediately. 
                                                <br>
                                                Your cart will save all selected products. Please check the quantity and product information carefully before checkout. 
                                                <br>
                                                If you want to change the quantity, use the increase/decrease buttons next to the product in the cart.
                                                <br>
                                                <strong>Note:</strong> Don't forget to check for promotional or discounted products in your cart.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingFour">
                                            <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                    Step 4: Checkout
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                            <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                                After checking your cart, proceed to checkout. You will need to fill in shipping information and choose a payment method. 
                                                <br>
                                                We support various secure and convenient payment methods such as credit cards, bank transfers, and cash on delivery. 
                                                <br>
                                                Ensure that your shipping information is accurate to avoid issues during delivery. If you have a discount code, enter it in the corresponding box to receive the offer.
                                                <br>
                                                <strong>Tip:</strong> Double-check your payment information before confirming to ensure there are no errors.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingFive">
                                            <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                    Step 5: Track Your Order
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                            <div class="card-body" style="font-size: 18px; line-height: 1.6; color: #555;">
                                                After placing your order, you can track the status of your order in your account. 
                                                <br>
                                                You can view the status of your order updated in the order history in your account. 
                                                <br>
                                                If there are any issues, please contact our customer support for timely assistance. You can also check your order history in your account to review previous orders.
                                                <br>
                                                <strong>Note:</strong> Check regularly to update the status of your order.
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
