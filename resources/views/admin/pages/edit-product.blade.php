<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.head')
</head>
<body>
    
    
    <div class="container">
        <h1>Edit Product</h1>
        
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->Product_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 
            
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->Category_id }}" {{ $category->Category_id == $product->Category_id ? 'selected' : '' }}>
                            {{ $category->Category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select name="brand_id" id="brand_id" class="form-control">
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->Brand_id }}" {{ $brand->Brand_id == $product->Brand_id ? 'selected' : '' }}>
                            {{ $brand->Brand_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" value="{{ $product->Product_name }}" required>
            </div>

            <div class="form-group">
                <label for="product_description">Product Description</label>
                <textarea name="product_description" id="ckeditor3" class="form-control" required>{{ $product->Product_description }}</textarea>
            </div>

            <div class="form-group">
                <label for="product_specifications">Product Specifications</label>
                <textarea name="specifications[]" id="ckeditor4" class="form-control" rows="5" required
                    placeholder="Please enter product specifications.">
                    @foreach ($product->specifications as $spec)
                        {{ $spec->Spec_name }}
                    @endforeach
                </textarea>
                <small id="specificationsError" class="form-text text-danger" style="display: none; font-size:16px">Product Specifications can not be blank.</small>
            </div>
            
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $product->Price }}" min="0" max="10000" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ $product->Stock_Quantity }}" min="0" max="100" required>
            </div>

            <div class="form-group">
                <label for="images">Images</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
            <button type="button" class="btn btn-primary" onclick="confirmCancel()">Cancel</button>
        </form>
    </div>

    @include('admin.layout.footer')
</body>

<script>
    function confirmCancel() {
        if (confirm("Are you sure you want to cancel?")) {
            window.location.href = "{{ route('products.indexAdmin') }}"; 
        } else {}
    }
</script>
<script src="{{ asset('admin-asset/ckeditor/ckeditor.js') }}"></script>
    <script>
      CKEDITOR.replace('ckeditor3');
      CKEDITOR.replace('ckeditor4');
  </script>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        var textarea = document.getElementById('ckeditor4');
        var errorMessage = document.getElementById('specificationsError');
        
        if (textarea.value.trim() === '') {
            errorMessage.style.display = 'block'; // Hiển thị thông báo lỗi
            event.preventDefault(); // Ngừng gửi form
        } else {
            errorMessage.style.display = 'none'; // Ẩn thông báo lỗi nếu có dữ liệu
        }
    });
</script>
</html>