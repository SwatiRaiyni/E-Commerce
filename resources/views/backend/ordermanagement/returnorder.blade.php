@extends('layouts.backend_layouts.layouts')
@section('content')



    <!-- Main content -->


                    <div class="content-wrapper">
                        <!-- Content Header (Page header) -->
                        <section class="content-header">
                          <div class="container-fluid">
                            <div class="row mb-2">
                              <div class="col-sm-6">
                                <h1>Return Request</h1>
                              </div>
                              <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                                  <li class="breadcrumb-item active">Return request</li>
                                </ol>
                              </div>
                            </div>
                          </div><!-- /.container-fluid -->
                        </section>

                        <!-- Main content -->
                        <section class="content">
                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-12">


                                <div class="card">
                                  <div class="card-header">
                                    <h3 class="card-title">List of request</h3>
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
                                  <!-- /.card-header -->
                                  <div class="card-body">
                                    <table id="return_request" class="table table-bordered table-striped">
                                      <thead>
                                      <tr>
                                        <th>ID</th>
                                        <th>Order id</th>
                                        <th>User id</th>
                                        <th>product size</th>
                                        <th>prodcut code</th>
                                        <th>Return reason</th>
                                        <th>Return status</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th>Approved/Reject</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($return_request as $request)
                                            <tr>
                                                <td>{{$request['id']}}</td>
                                                <td>{{$request['order_id']}}</td>
                                                <td>{{$request['user_id']}}</td>
                                                <td>{{$request['product_size']}}</td>
                                                <td>{{$request['product_code']}}</td>
                                                <td>{{$request['return_reason']}}</td>
                                                <td>{{$request['return_status']}}</td>
                                                <td>
                                                    @if(!empty($request['comment']))
                                                        {{$request['comment']}}
                                                    @endif
                                                </td>
                                                <td>{{date('d-m-Y',strtotime($request['created_at']))}}</td>
                                                <td>
                                                    <form action="{{url('admin/return-request/update')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="return_id" value="{{$request['id']}}">
                                                    <select name="return_status" class="form-contorl" id="">
                                                        <option @if($request['return_status'] == "Approved") selected="" @endif value="Approved">Approved</option>
                                                        <option @if($request['return_status'] == "Rejected") selected="" @endif  value="Rejected">Rejected</option>
                                                        <option @if($request['return_status'] == "Pending") selected="" @endif  value="Pending">Pending</option>
                                                    </select>
                                                    <input type="submit" value="Update" style="margin-top:10px;" class="btn btn-primary">

                                                </form>
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
