@extends('layouts.backend_layouts.layouts')
@section('content')



    <!-- Main content -->


                    <div class="content-wrapper">
                        <!-- Content Header (Page header) -->
                        <section class="content-header">
                          <div class="container-fluid">
                            <div class="row mb-2">
                              <div class="col-sm-6">
                                <h1>Ratings and Reviews</h1>
                              </div>
                              <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                                  <li class="breadcrumb-item active">Ratings and Reviews</li>
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
                                    <h3 class="card-title">List of reviews</h3>
                                  </div>
                                  <!-- /.card-header -->
                                  <div class="card-body">
                                    <table id="review" class="table table-bordered table-striped">
                                      <thead>
                                      <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>User Email</th>
                                        <th>Review</th>
                                        <th>Ratings</th>
                                        <th>Status</th>

                                      </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data as $section)
                                            <tr>
                                                <td>{{$section->id}}</td>
                                                <td>{{$section->product_name}}</td>
                                                <td>{{$section->email}}</td>
                                                <td>{{$section->review}}</td>
                                                <td>{{$section->ratings}}</td>
                                                <td>
                                                    @if($section->status == 1)
                                                        <a href="javascript:void(0)" class="updaterating" rating_id="{{$section->id}}" id="rating-{{$section->id}}"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                    @else
                                                        <a href="javascript:void(0)" class="updaterating" rating_id="{{$section->id}}" id="rating-{{$section->id}}"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                                    @endif
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
