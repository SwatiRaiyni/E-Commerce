@extends('layouts.backend_layouts.layouts')
@section('content')

<!-- Main content -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
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
                <h3 class="card-title">List of products</h3>
                <a href="/admin/add-edit-product" class="btn btn-block btn-success" style="max-width: 150px;float:right; display:inline-block">Add Product</a>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="product" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product name</th>
                    <th> Product code</th>
                    <th>Product color</th>
                    <th> Product Image</th>
                    <th>category</th>
                    <th>section</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $product)

                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->product_code}}</td>
                            <td>{{$product->product_color}}</td>
                            <td>

                                @if(!empty($product['main_image']))
                                <img id="showImage" src="/storage/images/products_images/{{$product['main_image']}}"  width="100px">
                                @else
                                <img id="showImage" src="/storage/images/products_images/noimage.png"  width="100px">
                                @endif
                            </td>
                            <td>{{$product->category->category_name}}</td>
                            <td>{{$product->section->name}}</td>
                            <td>
                                @if($product->status == 1)
                                    <a href="javascript:void(0)" class="updateproduct" product_id="{{$product->id}}" id="product-{{$product->id}}">Active</a>
                                @else
                                    <a href="javascript:void(0)" class="updateproduct" product_id="{{$product->id}}" id="product-{{$product->id}}">InActive</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('admin/add-attributes/'.$product->id)}}"><i class="fas fa-plus"></i></a>&nbsp;&nbsp;
                                <a href="{{ url('admin/add-edit-product/'.$product->id)}}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                <a href="javascript:void(0)" record="product" recordid="{{$product->id}}" name="product" class="confirm_delete"><i class="fas fa-trash"></i></a>
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
