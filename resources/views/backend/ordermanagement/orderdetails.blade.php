<?php use App\Models\Product; ?>
@extends('layouts.backend_layouts.layouts')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order #{{$orderdetails['id']}} Detail</li>
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
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Order details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Order Date</td>
                            <td> {{date('d-m-Y',strtotime($orderdetails['created_at']))}}</td>
                        </tr>
                        <tr>
                            <td>Order Total</td>
                            <td>Rs. {{$orderdetails['grand_total']}}</td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>{{$orderdetails['payment_method']}}</td>
                        </tr>
                        <tr>
                            <td>Payment Gateway</td>
                            <td>{{$orderdetails['payment_gatway']}}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>

              </div>
              <!-- /.card -->

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Delivery Address</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{$orderdetails['name']}}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{$orderdetails['address']}}</td>
                        </tr>
                        <tr>
                            <td>pincode</td>
                            <td>{{$orderdetails['pincode']}}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{$orderdetails['mobile']}}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Custmer Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{$userdetails['name']}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{$userdetails['email']}}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{$userdetails['phone']}}</td>
                        </tr>

                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Update Order Status</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <form action="{{ url('admin/update-order-status') }}" method="post" >
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $orderdetails['id'] }}">
                                <select name="order_status" required>
                                    <option value="">Select Status</option>
                                    <option value="1"  @if(isset( $orderdetails['order_status'])  && $orderdetails['order_status'] == 1 ) selected="" @endif>Pending</option>
                                    <option value="2"  @if(isset( $orderdetails['order_status'])  && $orderdetails['order_status'] == 2 ) selected="" @endif>Assigned</option>
                                    <option value="2"  @if(isset( $orderdetails['order_status'])  && $orderdetails['order_status'] == 3) selected="" @endif>Cancelled</option>
                                    <option value="4"  @if(isset( $orderdetails['order_status'])  && $orderdetails['order_status'] == 4 ) selected="" @endif>Complete</option>
                                </select>&nbsp;&nbsp;

                                <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                @foreach ($orderLog as $log)
                                    <strong>
                                        @if($log['order_status'] == 1)
                                            pending
                                        @elseif($log['order_status'] == 2)
                                            Assigned
                                        @elseif($log['order_status'] == 3)
                                            Cancelled
                                        @elseif ($log['order_status'] == 4)
                                            Completed
                                        @endif
                                    </strong>
                                    @if($log['reason'] != "")
                                    <br>
                                    {{$log['reason']}}
                                    @endif
                                    <br/>
                                    {{date('d-m-Y',strtotime($log['created_at']))}}<hr><br>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>

            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Ordered Product details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Productcode</th>
                                <th>Prdouct Name</th>
                                <th>Product Size</th>
                                <th>Product color</th>
                                <th>Prodcut Qty</th>
                                <th>Item Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderdetails['orderproduct'] as $product)
                            <tr>
                                <td><?php $image =  Product::getproductimage($product['product_id']) ?>
                                    <img src="/storage/images/products_images/{{ $image}}" alt="" style="width:80px"/>
                                </td>
                                <td> {{$product['product_code']}}</td>
                                <td>{{$product['product_name']}}</td>
                                <td>{{$product['product_size']}}</td>
                                <td>{{$product['product_color']}}</td>
                                <td>{{$product['product_qty']}}</td>
                                <td>{{$product['item_status']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>



          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>

  </div>

@endsection
