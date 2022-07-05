<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>E-commerce</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

	<!-- Front style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	<link id="callCss" rel="stylesheet" href="/css/front_user/front.min.css" media="screen"/>
	<link href="/css/front_user/base.css" rel="stylesheet" media="screen"/>
	<!-- Front style responsive -->
    <link href="/js/front_user/google-code-prettify/prettify.css" rel="stylesheet"/>
	<link href="/css/front_user/front-responsive.min.css" rel="stylesheet"/>
	<link href="/css/front_user/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link href={{ asset('css/front_user/front_user.css') }} rel="stylesheet" type="text/css">

  <!-- Google Font: Source Sans Pro -->

	<!-- fav and touch icons -->
	<link rel="shortcut icon" href="/images/front_user/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/front_user/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/front_user/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/front_user/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/images/front_user/ico/apple-touch-icon-57-precomposed.png">
	<style type="text/css" id="enject"></style>
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=62b163a6fe3bb900199aab9b&product=sticky-share-buttons" async="async"></script>
</head>
<body>
@include('layouts.front_layouts.header')
<!-- Header End====================================================================== -->
@include('fronted.home_banner')
<div id="mainBody">
	<div class="container">
		<div class="row">
			<!-- Sidebar ================================================== -->
		@include('layouts.front_layouts.sidebar')
			<!-- Sidebar end=============================================== -->

            @yield('content')
		</div>
	</div>
</div>
<!-- Footer ================================================================== -->
@include('layouts.front_layouts.footer')
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="/js/front_user/jquery.js" type="text/javascript"></script>
<script src="/js/front_user/front.min.js" type="text/javascript"></script>
<script src="/js/front_user/google-code-prettify/prettify.js"></script>

<script src="/js/front_user/front.js"></script>
<script src="{{ asset('js/front_user/section.js') }}"></script>
<script src="/js/front_user/jquery.lightbox-0.5.js"></script>

</body>
</html>
