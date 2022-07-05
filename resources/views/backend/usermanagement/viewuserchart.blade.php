@extends('layouts.backend_layouts.layouts')
@section('content')
<div class="content-wrapper">

    <?php

    $months = array();
    $count = 0;
    while ($count <= 3 ) {
        $months[] = date('M Y',strtotime("-".$count." month"));
        $count++;
    }
    //echo '<pre>';print_r($months); die;

        $dataPoints = array(
        array("y" => $userdata[3], "label" => $months[3]),
        array("y" => $userdata[2], "label" => $months[2]),
        array("y" => $userdata[1], "label" => $months[1]),
        array("y" => $userdata[0], "label" => $months[0])
        );
    ?>
    <script>
        window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Push-ups Over a Month"
            },
            axisY: {
                title: "Number of Push-ups"
            },
            data: [{
                type: "line",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        }
        </script>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Reports</li>
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
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of User Reports</h3>
                </div>
              <div class="card-body">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endsection
