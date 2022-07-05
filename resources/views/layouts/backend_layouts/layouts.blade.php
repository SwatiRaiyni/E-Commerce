<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>
  <style>
    .error{
     color: #FF0000;
    }
  </style>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/backend_user/pagination.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href=" {{ asset('plugins/select2/css/select2.min.css') }}">
  <!-- Ionicons -->
  {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
  <!-- Tempusdominus Bootstrap 4 -->
  {{-- <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}"> --}}
  <!-- iCheck -->
  {{-- <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}"> --}}
  <!-- JQVMap -->
  {{-- <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css')}}"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/backend_user/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  {{-- <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}"> --}}
  <!-- Daterange picker -->
  {{-- <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}"> --}}
  <!-- summernote -->
  {{-- <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}"> --}}
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" >



  <!-- Navbar -->
  @include('layouts.backend_layouts.header')
  <!-- /.navbar -->

<!-- Main Sidebar Container -->
  @include('layouts.backend_layouts.sidebar')
<!-- /.sidebar -->


  <!-- Content Wrapper. Contains page content -->
    @yield('content')
  <!-- /.content-wrapper -->
  @include('layouts.backend_layouts.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->


<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>


<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- <script src="{{ asset('js/backend_user/pages/dashboard.js') }}"></script> --}}
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function () {
      $("#section").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,

      });
      $('.select2').select2()

    });

    $(function () {
      $("#category").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });
    $(function () {
      $("#orders").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });
    $(function () {
      $("#productdetails").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });
    $(function () {
      $("#product").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });

    $(function () {
      $("#attribute").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });
    $(function () {
      $("#banner").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });
    $(function () {
      $("#newsletter_subscriber").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });
    $(function () {
      $("#review").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });
    $(function () {
      $("#return_request").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });
    $(function () {
      $("#exchange_request").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
    });
    });
  </script>

<!-- ChartJS -->
{{-- <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script> --}}
<!-- Sparkline -->
{{-- <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script> --}}
<!-- JQVMap -->
{{-- <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> --}}
<!-- jQuery Knob Chart -->
{{-- <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script> --}}
<!-- daterangepicker -->
{{-- <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
<!-- Tempusdominus Bootstrap 4 -->
{{-- <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> --}}
<!-- Summernote -->
{{-- <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script> --}}

<!-- AdminLTE App -->
<script src="{{ asset('js/backend_user/adminlte.js') }}"></script>
<script src="{{ asset('js/backend_user/section.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
</body>
</html>
