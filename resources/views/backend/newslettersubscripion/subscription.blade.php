@extends('layouts.backend_layouts.layouts')
@section('content')

<!-- Main content -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Newsletter Subscription</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Newsletter Subscription </li>
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
                    <a href="#" onclick="html_table_to_excel('xlsx');" class="btn btn-block btn-success" style="max-width: 150px;float:right; display:inline-block">Export</a>
                  </div>


              <!-- /.card-header -->
              <div class="card-body">
                <table id="newsletter_subscriber" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Subscribe on</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $data1)

                        <tr>
                            <td>{{$data1['id']}}</td>
                            <td>{{$data1['email']}}</td>
                            <td>{{ date('d-m-Y h:i:s',strtotime($data1['created_at'])) }}</td>
                            <td>
                                @if($data1['status'] == 1)
                                    <a href="javascript:void(0)" class="updatesubscriber" subscriber_id="{{$data1['id']}}" id="subscriber-{{$data1['id']}}">Active</a>
                                @else
                                    <a href="javascript:void(0)" class="updatesubscriber" subscriber_id="{{$data1['id']}}" id="subscriber-{{$data1['id']}}">InActive</a>
                                @endif
                                &nbsp;&nbsp;

                                <a href="javascript:void(0)" record="subscriber" recordid="{{$data1['id']}}" name="subscriber" class="confirm_delete">Delete</a>

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







