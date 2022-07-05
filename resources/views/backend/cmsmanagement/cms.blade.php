@extends('layouts.backend_layouts.layouts')
@section('content')

<!-- Main content -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CMS Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">CMS Management</li>
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
                    <h3 class="card-title">List of Banner</h3>
                    <a href="/admin/add-edit-cms" class="btn btn-block btn-success" style="max-width: 150px;float:right; display:inline-block">Add Banner</a>
                  </div>


              <!-- /.card-header -->
              <div class="card-body">
                <table id="banner" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($banners as $banner)

                        <tr>
                            <td>{{$banner['id']}}</td>
                            <td><img src="/storage/images/banner_images/{{ $banner['image'] }}" style="width:100px"></td>
                            <td>{{$banner['banner-title']}}</td>
                            <td>
                                @if($banner['status'] == 1)
                                    <a href="javascript:void(0)" class="updatebanner" banner_id="{{$banner['id']}}" id="banner-{{$banner['id']}}">Active</a>
                                @else
                                    <a href="javascript:void(0)" class="updatebanner" banner_id="{{$banner['id']}}" id="banner-{{$banner['id']}}">InActive</a>
                                @endif
                                &nbsp;&nbsp;
                                <a href="{{ url('admin/add-edit-cms/'.$banner['id'])}}">Edit</a>&nbsp;&nbsp;
                                <a href="javascript:void(0)" record="banner" recordid="{{$banner['id']}}" name="banner" class="confirm_delete">Delete</a>

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
