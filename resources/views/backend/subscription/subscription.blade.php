@extends('layouts.backend_layouts.layouts')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Subscription</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Subscription</li>
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
                <h3 class="card-title">List of Subscription</h3>

              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="orders" class="table table-bordered table-striped">
                  <thead>
                  <tr>

                    <th> Subscripion id </th>
                    <th>user name</th>

                    <th>Moible</th>
                    <th>Subscription plan</th>
                    <th>Subscription amount</th>
                    <th>Subscription Date</th>
                    <th>Duration</th>
                    <th>Is_subscibed</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $order)

                        <tr>

                            <td>{{$order->subscription_id}}</td>
                            <td>{{$order->name}}</td>

                            <td>{{$order->phone}}</td>
                            <td>{{$order->subscription_plan}}</td>
                            <td>{{$order->amount}}</td>
                            <td> {{date('d-m-Y',strtotime($order->subscribed_at))}}</td>
                            <td>{{$order->duration}} Month</td>
                            <td>
                                @if($order->is_subscribe == 1)
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                            <td>

                                <a title="View Subscription Invoice" target="_blank" href="{{ url('/admin/view-subscribe-invoice/'.$order->id)}}"><i class="fas fa-print"></i></a>


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
