<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        <style>

        /* Căn chỉnh và định dạng chung */
        .popup-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .popup-container .popup-content {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            box-sizing: border-box;
            margin: auto;
        }

        /* Phần hình ảnh sản phẩm */
        .popup-container .popup-img {
            text-align: center;
            margin-bottom: 20px;
        }

        .popup-container .popup-img img {
            width: 100%;
            max-width: 200px;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
        }

        /* Phần thông tin sản phẩm */
        .popup-container .popup-info {
            margin-bottom: 20px;
        }

        .popup-container .popup-info p {
            margin: 10px 0;
            line-height: 1.6;
            font-size: 14px;
            color: #333;
        }

        .popup-container .popup-info p strong {
            display: inline-block;
            color: #333333;
            font-weight: bold;
        }

        .popup-container .popup-info .description {
            width: 100%;
            text-align: justify;
            color: #555555;
            overflow-wrap: break-word;
        }

        .popup-container .popup-info img {
            max-width: 100% !important;
            height: auto !important;
        }

        /* Nút đóng hoặc các nút liên quan */
        .popup-container .popup-close {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .popup-container .popup-close button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .popup-container .popup-close button:hover {
            background-color: #0056b3;
        }

        /* Phần màu sắc sản phẩm */
        .popup-container .product-colors {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .popup-container .product-colors .color-circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 8px;
            border: 1px solid #ccc;
        }

        /* Đảm bảo độ phản hồi (Responsive Design) */
        @media (max-width: 768px) {
            .popup-container .popup-content {
                padding: 15px;
            }

            .popup-container .popup-info p {
                font-size: 13px;
            }

            .popup-container .popup-close button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }

        @media (max-width: 480px) {
            .popup-container {
                padding: 10px;
            }

            .popup-container .popup-content {
                padding: 10px;
            }

            .popup-container .popup-info p {
                font-size: 12px;
            }

            .popup-container .popup-close button {
                font-size: 12px;
                padding: 6px 12px;
            }
        }
    </style>


    </style>
</head>

<body>

    <div class="popup-container">
        <div class="popup-content">
            <div class="popup-img">
                @if ($product->images->count() > 0)
                    <img src="{{ asset('storage/' . $product->images->first()->Image_path) }}"
                        alt="{{ $product->Product_name }}">
                @else
                    <p>No image available</p>
                @endif
            </div>
            <div class="popup-info">
                <p><strong>Name:</strong> {{ $product->Product_name }}</p>
                <p><strong>Category:</strong> {{ $product->category->Category_name }}</p>
                <p><strong>Brand:</strong> {{ $product->brand->Brand_name }}</p>
                <p class="description">
                    <strong>Description:</strong>
                    {!! $product->Product_description !!}
                </p>
                <p><strong>Price:</strong> ${{ number_format($product->Price, 2) }}</p>
                <p><strong>Stock Total Quantity:</strong> {{ $product->Stock_Quantity }}</p>
            </div>

        </div>
    </div>

</body>

</html>
