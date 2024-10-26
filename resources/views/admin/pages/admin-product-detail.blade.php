<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .popup-container .popup-content {
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .popup-container .popup-img {
            text-align: center;
            margin-bottom: 20px;
        }

        .popup-container .popup-img img {
            width: 100%;
            max-width: 200px;
            border-radius: 10px;
        }

        .popup-container .popup-info p {
            margin: 10px 0;
        }

        .popup-container .popup-info strong {
            color: #333;
        }

        .popup-container .popup-close {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

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
                <p><strong>Description:</strong> {{ $product->Product_description }}</p>
                <p><strong>Price:</strong> ${{ number_format($product->Price, 2) }}</p>
                <p><strong>Stock Total Quantity:</strong> {{ $product->Stock_Quantity }}</p>

                <p><strong>Available Colors:</strong></p>
                <div>
                    @foreach ($product->colors as $color)
                        <div style="margin-bottom: 5px;">
                            <span
                                style="display: inline-block; width: 20px; height: 20px; background-color: {{ $color->Color_name }}; border-radius: 50%;"></span>
                            {{ $color->Color_name }} - Quantity: {{ $color->Quantity }}
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</body>

</html>
