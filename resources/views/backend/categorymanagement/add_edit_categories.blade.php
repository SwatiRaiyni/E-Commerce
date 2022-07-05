@extends('layouts.backend_layouts.layouts')
@section('content')
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
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
    <form name="categoryForm" id="categoryForm" @if(empty($categorydata['id'])) action={{url('admin/add-edit-category')}} @else action={{url('admin/add-edit-category/'.$categorydata['id'])}} @endif method="post" encType="multipart/form-data">
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
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name" @if(!empty($categorydata['category_name'])) value="{{$categorydata['category_name']}}" @else value="{{ old('category_name')}}" @endif>
                    <span style="color:red" class="category_name">@error('category_name'){{$message}}@enderror</span>
                </div>
                <div id="appendcategorylevel">
                    @include('backend.categorymanagement.category_level')
                </div>

            </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                    <label>Select Section</label>
                    <select name="section_id" id="section_id" class="form-control select2" style="width: 100%;">

                      <option value="">Select</option>
                      @foreach ($section as $section1 )
                          <option value="{{$section1->id}}" @if(!empty($categorydata['section_id']) && $categorydata['section_id'] == $section1->id) selected @endif>{{$section1->name}}</option>
                      @endforeach
                      </select>
                      <span style="color:red" class="section_id">@error('section_id'){{$message}}@enderror</span>
                  </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label>Select Category Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="category_image" id="image" class="custom-file-input" id="exampleInputFile" >
                          <input type="hidden" name="hidden_image"   @if(!empty($categorydata['category_image'])) value="{{$categorydata['category_image']}}"  @else value="{{ old('category_image')}}" @endif class="form-control" >

                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                        @if(!empty($categorydata['category_image']))
                        <img id="showImage" src="/storage/images/category_images/{{$categorydata['category_image']}}"  width="150px">
                        @endif

                      <span style="color:red" class="category_image">@error('category_image'){{$message}}@enderror</span>
                </div>

              </div>

            </div>

            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="category_name">Category Discount</label>
                    <input type="text" name="category_discount" class="form-control" id="category_discount" placeholder="Enter Category Discount" @if(!empty($categorydata['category_discount'])) value="{{$categorydata['category_discount']}}" @else value="{{ old('category_discount')}}" @endif>
                </div>
                <div class="form-group">
                    <label for="category_name">Category Description</label>
                   <textarea class="form-control"  name="description" id="category_description" rows="3" placeholder="Enter ..."> @if(!empty($categorydata['description'])) {{$categorydata['description']}} @else {{ old('description')}} @endif</textarea>

                </div>

              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="category_name">Category URL</label>
                    <input type="text" class="form-control" name="url" id="url" placeholder="Enter Category URL" @if(!empty($categorydata['url'])) value="{{$categorydata['url']}}" @else value="{{ old('url')}}" @endif>
                    <span style="color:red" class="url">@error('url'){{$message}}@enderror</span>
                </div>
                <div class="form-group">
                    <label for="category_name">Meta Title</label>
                    <textarea class="form-control" rows="3" name="meta_title" id="meta_title" placeholder="Enter ..."> @if(!empty($categorydata['meta_title'])) {{$categorydata['meta_title']}} @else {{ old('meta_title')}} @endif</textarea>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="category_name">Meta Description</label>
                    <textarea class="form-control" rows="3" name="meta_description" id="meta_description" placeholder="Enter ..."> @if(!empty($categorydata['meta_description'])) {{$categorydata['meta_description']}} @else {{ old('meta_description')}} @endif</textarea>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="category_name">Meta Keywords</label>
                    <textarea class="form-control" rows="3" name="meta_keywords" id="meta_keywords" placeholder="Enter ..."> @if(!empty($categorydata['meta_keywords'])) {{$categorydata['meta_keywords']}} @else {{ old('meta_keywords')}} @endif</textarea>
                </div>
            </div>

              </div>

            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a type="button" href="/admin/categories" class="btn btn-danger">{{__('cancel')}}</a>
          </div>
        </div>
    </form>



      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
