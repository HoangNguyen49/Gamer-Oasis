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
                                    <input class="form-control" type="text" name="product_name" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Quantity</label>
                                    <input class="form-control" type="number" name="stock_quantity" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Category</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="">Choose Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->Category_id }}">{{ $category->Category_name }}</option>
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
                                    <input class="form-control" type="text" name="price" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Product Color</label>
                                    <input class="form-control" type="text" name="colors[]">
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
                                    <label class="control-label">Product Descriptions</label>
                                    <textarea class="form-control" name="product_description" id="mota" required></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <button class="btn btn-save" type="submit">Save</button>
                                    <a class="btn btn-cancel" href="">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include('admin.layout.footer')
</body>

</html>
