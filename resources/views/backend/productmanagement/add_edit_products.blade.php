@extends('layouts.backend_layouts.layouts')
@section('content')
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
    <form name="productForm" id="productForm" @if(empty($productdata['id'])) action={{url('admin/add-edit-product')}} @else action={{url('admin/add-edit-product/'.$productdata['id'])}} @endif method="post" encType="multipart/form-data">
        @csrf
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{$title}}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>

            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>Select Category</label>
                    <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach ($category as $section)
                        <optgroup label="{{$section['name']}}"></optgroup>
                        @foreach ($section['categories'] as $category)
                            <option value="{{$category['id']}}" @if(!empty(@old('category_id')) && $category['id'] == @old('category_id') ) selected ="" @elseif(!empty($productdata['category_id']) && $productdata['category_id'] ==$category['id'] ) selected ="" @endif class="@error('category') is-invalid @enderror" >&nbsp;&nbsp;&nbsp;{{$category['category_name']}}</option>
                            @foreach ($category['subcategory'] as $subcategory)
                            <option value="{{$subcategory['id']}}" @if(!empty(@old('category_id')) && $subcategory['id'] == @old('category_id') ) selected =""  @elseif(!empty($productdata['category_id']) && $productdata['category_id'] ==$subcategory['id'] ) selected ="" @endif >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subcategory['category_name']}}</option>

                        @endforeach
                        @endforeach
                    @endforeach
                    </select>
                    @error('category_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    <span style="color:red" class="category_id">@error('category_id'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="product_name">Select Product name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" @if(!empty($productdata['product_name'])) value="{{$productdata['product_name']}}" @else value="{{ old('product_name')}}" @endif class="@error('pname') is-invalid @enderror">
                    @error('pname')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    <span style="color:red" class="product_name">@error('product_name'){{$message}}@enderror</span>
                </div>
            </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                    <label for="product_code">Product Code</label>
                    <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product code" @if(!empty($productdata['product_code'])) value="{{$productdata['product_code']}}" @else value="{{ old('product_code')}}" @endif class="@error('pcode') is-invalid @enderror">
                    @error('product_code')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    {{-- <span style="color:red" class="product_code">@error('product_code'){{$message}}@enderror</span> --}}
                </div>
                <div class="form-group">
                    <label for="product_color">Product Color</label>
                    <input type="text" class="form-control" name="product_color" id="product_color" placeholder="Enter Product color" @if(!empty($productdata['product_color'])) value="{{$productdata['product_color']}}" @else value="{{ old('product_color')}}" @endif class="@error('pcolor') is-invalid @enderror">
                    @error('product_color')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    <span style="color:red" class="product_color">@error('product_color'){{$message}}@enderror</span>
                </div>

              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="product_price">Product Price</label>
                    <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter Product Price" @if(!empty($productdata['product_price'])) value="{{$productdata['product_price']}}" @else value="{{ old('product_price')}}" @endif class="@error('pprice') is-invalid @enderror">
                    @error('product_price')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    <span style="color:red" class="product_price">@error('product_price'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="product_discount">Product Discount (%)</label>
                    <input type="text" class="form-control" name="product_discount" id="product_discount" placeholder="Enter Product Discount" @if(!empty($productdata['product_discount'])) value="{{$productdata['product_discount']}}" @else value="{{ old('product_discount')}}" @endif>

                    <span style="color:red" class="product_discount">@error('product_discount'){{$message}}@enderror</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Select Product Main Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="main_image" id="image" class="custom-file-input" id="exampleInputFile" >
                          <input type="hidden" name="hidden_image"   @if(!empty($productdata['main_image'])) value="{{$productdata['main_image']}}"  @else value="{{ old('main_image')}}" @endif >

                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                        @if(!empty($productdata['main_image']))
                        <img id="showImage" src="/storage/images/products_images/{{$productdata['main_image']}}"  width="150px">
                        @endif

                      <span style="color:red" class="main_image">@error('main_image'){{$message}}@enderror</span>
                </div>

              </div>
        </div>

            <div class="row">
              <div class="col-12 col-sm-6">

                <div class="form-group">
                    <label for="product_description">Product Description</label>
                   <textarea class="form-control"  name="description" id="product_description" rows="3" placeholder="Enter ..."> @if(!empty($productdata['description'])) {{$productdata['description']}} @else {{ old('description')}} @endif</textarea>
                </div>

              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6">

                <div class="form-group">
                    <label for="category_name">Meta Title</label>
                    <textarea class="form-control" rows="3" name="meta_title" id="meta_title" placeholder="Enter ..."> @if(!empty($productdata['meta_title'])) {{$productdata['meta_title']}} @else {{ old('meta_title')}} @endif</textarea>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="category_name">Meta Description</label>
                    <textarea class="form-control" rows="3" name="meta_description" id="meta_description" placeholder="Enter ..."> @if(!empty($productdata['meta_description'])) {{$productdata['meta_description']}} @else {{ old('meta_description')}} @endif</textarea>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="category_name">Meta Keywords</label>
                    <textarea class="form-control" rows="3" name="meta_keywords" id="meta_keywords" placeholder="Enter ..."> @if(!empty($productdata['meta_keywords'])) {{$productdata['meta_keywords']}} @else {{ old('meta_keywords')}} @endif</textarea>
                </div>

            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="Is_featured">Feature Item</label>
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" @if(!empty($productdata['is_featured'])  ) checked="" @endif>
                </div>
            </div>

              </div>

            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a type="button" href="/admin/products" class="btn btn-danger">{{__('cancel')}}</a>
          </div>
        </div>
    </form>
    @if(!empty($productdata['id']))
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">List of Attriutes</h3>
        </div>
    <div class="card-body">
        <table id="attribute" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>ID</th>
            <th>size</th>
            <th>code</th>
            <th>Price</th>
            <th>stock</th>


          </tr>
          </thead>
          <tbody>
            @foreach ($productdata['attributes'] as $product)

                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->size}}</td>
                    <td>{{$product->code}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->stock}}</td>


                </tr>
            @endforeach
          </tbody>

        </table>
      </div>


      </div>
      @endif
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
          $("#productForm").validate({
            rules: {
                category_id: {
                    required: true,
                // maxlength: 50
                },product_name: {
                    required: true,
                },product_code: {
                    required: true,

                },product_color:{
                    required :true
                },product_price:{
                    required : true,
                    number: true
                },product_discount:{
                    required : true
                }
            },
            messages: {
                category_id: {
                    required: "Please select category",
                },product_name: {
                    required: "Please enter product name",
                },product_code: {
                    required: "Please enter product code ",

                },product_color:{
                    required : "Please enter product color"
                },product_price:{
                    required : "Please enter product price"
                },product_discount:{
                    required : "Please Enter product discount"
                }
            },
        });
    </script>
  </div>
@endsection
