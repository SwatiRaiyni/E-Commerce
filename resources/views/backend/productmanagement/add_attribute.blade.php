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
              <li class="breadcrumb-item active">Products attributes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
    <form name="addattributeForm" id="attributeForm"  method="post" action="{{url('admin/add-attributes/'.$productdata['id'])}}" encType="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{$productdata['id']}}">
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
              <div class="col-md-6">

                <div class="form-group">
                    <label for="product_name">Select Product name: {{$productdata['product_name']}}</label>
                </div>
                <div class="form-group">
                    <label for="product_code">Product Code: {{$productdata['product_code']}}</label>
                </div>
                <div class="form-group">
                    <label for="product_color">Product Color : {{$productdata['product_color']}}</label>
                </div>

              </div>

                <div class="col-md-6">
                <div class="form-group">
                    <img id="showImage" src="/storage/images/products_images/{{$productdata['main_image']}}"  width="150px">
                </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="field_wrapper">
                            <div>
                                <input id="size" type="text" name="size[]" value="" placeholder="size" style="width: 120px" required/>
                                <input id="code" type="text" name="code[]" value="" placeholder="code" style="width: 120px" required/>
                                <input id="price" type="number" name="price[]" value="" placeholder="price" style="width: 120px" required/>
                                <input id="stock" type="number" name="stock[]" value="" placeholder="stock" style="width: 120px" required/>
                                <a href="javascript:void(0);" class="add_button" title="size">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add Attribute</button>
            <a type="button" href="/admin/products" class="btn btn-danger">{{__('cancel')}}</a>
          </div>
        </div>
    </form>

    <form  name="editattributeForm" method="post" action="{{url('admin/edit-attriute/'.$productdata['id'])}}">
        @csrf
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
            <th>Action</th>

          </tr>
          </thead>
          <tbody>
            @foreach ($productdata['attributes'] as $product)
                <input type="text" style="display: none" name="attrId[]" value="{{$product['id']}}">
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->size}}</td>
                    <td>{{$product->code}}</td>
                    <td><input type="number" name="price[]" value="{{$product->price}}" required></td>
                    <td><input type="number" name="stock[]" value="{{$product->stock}}" required></td>
                    <td>
                        @if($product->status == 1)
                            <a href="javascript:void(0)" class="updateattriute" attribute_id="{{$product->id}}" id="attribute-{{$product->id}}">Active</a>
                        @else
                            <a href="javascript:void(0)" class="updateattriute" attribute_id="{{$product->id}}" id="attribute-{{$product->id}}">InActive</a>
                        @endif
                        <a href="javascript:void(0)" record="attribute" recordid="{{$product->id}}" name="attribute" class="confirm_delete"><i class="fas fa-trash"></i></a>
                    </td>

                </tr>
            @endforeach
          </tbody>

        </table>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Update Attribute</button>
        <a type="button" href="/admin/products" class="btn btn-danger">{{__('cancel')}}</a>
      </div>
     <!--  container-fluid -->
    </form>
 </div>
     </section>
    <!-- /.content -->
  </div>
@endsection
