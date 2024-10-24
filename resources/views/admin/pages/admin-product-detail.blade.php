<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>

    <div class="popup-container">
        <div class="popup-content">
            <div class="popup-img">
                @if($product->images->count() > 0)
                    <img src="{{ asset('storage/' . $product->images->first()->Image_path) }}" alt="{{ $product->Product_name }}">
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
                <p><strong>Stock Quantity:</strong> {{ $product->Stock_Quantity }}</p>
            </div>
        </div>
    </div>
</body>
</html>
