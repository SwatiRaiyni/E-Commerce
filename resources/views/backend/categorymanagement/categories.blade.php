@extends('layouts.backend_layouts.layouts')
@section('content')

<!-- Main content -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>

          </div>
        </div>
        @if(Session::get('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Hey!</strong> {{Session::get('status')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(Session::get('status1'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Hey!</strong> {{Session::get('status1')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Categories</h3>
                <a href="/admin/add-edit-category" class="btn btn-block btn-success" style="max-width: 150px;float:right; display:inline-block">Add Category</a>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="category" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Parent Category </th>
                    <th>Section</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $category)
                    @if(!isset($category->parentcategory->category_name))
                    <?php $parent_category ="Root"; ?>
                    @else
                    <?php $parent_category =$category->parentcategory->category_name; ?>
                    @endif
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->category_name}}</td>
                            <td>{{$parent_category}}</td>
                            <td>{{$category->section->name}}</td>
                            <td>{{$category->url}}</td>
                            <td>
                                @if($category->status == 1)
                                    <a href="javascript:void(0)" class="updatecategory" category_id="{{$category->id}}" id="category-{{$category->id}}">Active</a>
                                @else
                                    <a href="javascript:void(0)" class="updatecategory" category_id="{{$category->id}}" id="category-{{$category->id}}">InActive</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('admin/add-edit-category/'.$category->id)}}">Edit</a>&nbsp;&nbsp;
                                <a href="javascript:void(0)" record="category" recordid="{{$category->id}}" name="category" class="confirm_delete">Delete</a>
                               {{-- // href="{{ url('admin/delete-category/'.$category->id)}}" --}}
                            </td>
                        </tr>
                    @endforeach
                  </tbody>

                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
