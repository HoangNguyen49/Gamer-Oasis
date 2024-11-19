<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.head')
</head>

<body>
    @include('admin.layout.navbar')

    <div class="app-wrapper">
        @include('admin.layout.sidebar')
        <main class="app-content">
            <div class="app-title">
                <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.indexAdmin') }}">Product List</a></li>
                    <li class="breadcrumb-item"><a href="">Add Product</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <h3 class="tile-title">Add New Product</h3>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="tile-body">
                            <form class="row" action="{{ route('products.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-md-3">
                                    <label class="control-label">Product Name</label>
                                    <input class="form-control" type="text" name="product_name" required
                                        value="{{ old('product_name') }}">
                                    @if ($errors->has('product_name'))
                                        <span class="text-danger">{{ $errors->first('product_name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Quantity</label>
                                    <input class="form-control" type="number" name="stock_quantity" min="0"
                                        max="100" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Category</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="">Choose Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->Category_id }}">{{ $category->Category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Brand</label>
                                    <select class="form-control" name="brand_id" required>
                                        <option value="">Choose Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->Brand_id }}">{{ $brand->Brand_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Price</label>
                                    <input class="form-control" type="text" name="price" id="price" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="control-label">Product Images</label>
                                    <div id="myfileupload">
                                        <input type="file" id="uploadfile" name="images[]" multiple
                                            onchange="readURL(this);" />
                                    </div>
                                    <div id="thumbbox">
                                        <img height="450" width="400" alt="Thumb image" id="thumbimage"
                                            style="display: none" />
                                        <a class="removeimg" href="javascript:"></a>
                                    </div>
                                    <div id="boxchoice">
                                        <a href="javascript:" class="Choicefile"><i class="fas fa-cloud-upload-alt"></i>
                                            Choose image</a>
                                        <p style="clear:both"></p>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="control-label">Product Specifications</label>
                                    <textarea class="form-control" name="specifications[]" id="ckeditor1" placeholder="Enter product specifications"
                                        required></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="control-label">Product Descriptions</label>
                                    <textarea class="form-control" name="product_description" id="ckeditor2" placeholder="Enter product Descriptions"
                                        required></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <button class="btn btn-save" type="submit" id="submitBtn">Save</button>
                                    <a class="btn btn-cancel" href="{{ route('products.indexAdmin') }}">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include('admin.layout.footer')

    <script>
        document.getElementById('price').addEventListener('input', function(e) {
            const input = e.target;
            let value = input.value;

            // Loại bỏ ký tự không phải số và dấu thập phân
            value = value.replace(/[^0-9.]/g, '');

            // Kiểm tra nếu số chữ số vượt quá 10 (bao gồm phần thập phân)
            if (value.length > 10) {
                alert("Price can be a maximum of 10 digits.");
                input.value = value.substring(0, 10); // Giới hạn số chữ số
            } else if (parseFloat(value) > 99999999.99) {
                // Kiểm tra giá trị không vượt quá 99999999.99
                alert("Price cannot exceed 99999999.99.");
                input.value = '99999999.99'; // Giới hạn giá trị
            } else {
                input.value = value; // Cập nhật giá trị hợp lệ
            }
        });
    </script>
    <script src="{{ asset('admin-asset/ckeditor/ckeditor.js') }}"></script>
    <script>
      CKEDITOR.replace('ckeditor1');
      CKEDITOR.replace('ckeditor2');
  </script>

<script>
    document.getElementById('submitBtn').addEventListener('click', function (e) {
        // Lấy giá trị từ CKEditor
        const specifications = CKEDITOR.instances.ckeditor1.getData().trim();
        const description = CKEDITOR.instances.ckeditor2.getData().trim();

        // Kiểm tra nếu trống thì hiển thị thông báo
        let errorMessage = "";

        if (!specifications) {
            errorMessage += 'The "Product Specifications" field cannot be empty.\n';
        }

        if (!description) {
            errorMessage += 'The "Product Descriptions" field cannot be empty.\n';
        }

        if (errorMessage) {
            // Hiển thị thông báo lỗi
            alert(errorMessage);
            e.preventDefault(); // Ngăn form gửi đi
        }
    });
</script>

</body>

</html>
