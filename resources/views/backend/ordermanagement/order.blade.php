@extends('layouts.backend_layouts.layouts')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Orders | &nbsp;  <a href="{{url('admin/view-orders-charts')}}" >View Orders Report</a></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Orders</li>
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
                <h3 class="card-title">List of Orders</h3>

              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="orders" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th> Customer Name</th>
                    <th>Customer Email</th>
                    <th>Order Product</th>
                    <th>Order Amount</th>
                    <th>Payment Method</th>
                    <th>Payment Status</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $order)

                        <tr>
                            <td>{{$order['id']}}</td>
                            <td> {{date('d-m-Y',strtotime($order['created_at']))}}</td>
                            <td>{{$order['name']}}</td>
                            <td>{{$order['email']}}</td>
                            <td>
                                @foreach ($order['orderproduct'] as $pro)
                                    {{$pro['product_code']}} ({{$pro['product_qty']}})<br>
                                @endforeach
                            </td>
                            <td>{{$order['grand_total']}}</td>
                            <td>{{$order['payment_method']}}</td>
                            <td> @if ($order['order_status'] == 1)
                                pending
                                @elseif ($order['order_status'] == 2)
                                Assigned
                                @elseif ($order['order_status'] == 3)
                                Cancelled
                                @elseif($order['order_status'] == 4)
                                Completed
                                @endif
                            </td>
                            <td>
                                <a title="View Order details" href="{{ url('/admin/orders/'.$order['id'])}}"><i class="fas fa-file"></i></a>&nbsp;&nbsp;
                                {{-- @if( $order['order_status'] ==  1 || $order['order_status'] == 2) --}}
                                <a title="View Order Invoice" target="_blank" href="{{ url('/admin/view-order-invoice/'.$order['id'])}}"><i class="fas fa-print"></i></a>
                               &nbsp;&nbsp;
                                <a title="Print PDF Invoice" href="{{ url('/admin/print-pdf-invoice/'.$order['id'])}}"><i class="far fa-file-pdf"></i></a>&nbsp;&nbsp;
                                {{-- @endif --}}
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
