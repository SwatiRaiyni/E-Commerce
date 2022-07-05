@extends('layouts.backend_layouts.layouts')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CMs Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">CMS Management</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
    <form name="productForm" id="productForm" @if(empty($productdata['id'])) action={{url('admin/add-edit-cms')}} @else action={{url('admin/add-edit-cms/'.$productdata['id'])}} @endif method="post" encType="multipart/form-data" onsubmit="return checkForm(this);">
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


              <div class="col-md-6">
                <div class="form-group">
                    <label>Select Banner Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="image" id="image" class="custom-file-input" id="exampleInputFile" >
                          <input type="hidden" name="hidden_image"   @if(!empty($productdata['image'])) value="{{$productdata['image']}}"  @else value="{{ old('image')}}" @endif class="form-control" >

                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                        @if(!empty($productdata['image']))
                        <img id="showImage" src="/storage/images/banner_images/{{$productdata['image']}}"  width="150px">
                        @endif

                      <span style="color:red" class="image">@error('image'){{$message}}@enderror</span>
                </div>

              </div>


            <div class="row">
              <div class="col-12 col-sm-6">

                <div class="form-group">
                    <label for="product_description">banner title</label>
                    <input type="text" class="form-control" name="banner-title" id="banner_title" placeholder="Enter banner title" @if(!empty($productdata['banner-title'])) value="{{$productdata['banner-title']}}" @else value="{{ old('banner-title')}}" @endif>
                    <span style="color:red" class="banner-title">@error('banner-title'){{$message}}@enderror</span>
                </div>

              </div>
              <!-- /.col -->

              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="">banner Description</label>
                    <textarea class="form-control" rows="3" name="banner-description" id="banner-description" placeholder="Enter ..."> @if(!empty($productdata['banner-description'])) {{$productdata['banner-description']}} @else {{ old('banner-description')}} @endif</textarea>
                    <span style="color:red" class="banner-description">@error('banner-description'){{$message}}@enderror</span>
                </div>
              </div>


              </div>

            </div>

          </div>

          <div class="card-footer">
            <button type="submit" name="myButton" class="btn btn-primary">Submit</button>
            <a type="button" href="/admin/cmsmanagement" class="btn btn-danger">{{__('cancel')}}</a>
          </div>
        </div>
    </form>

</div>

      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
