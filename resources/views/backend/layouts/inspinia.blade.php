<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ app_name() }} | @yield('title')</title>

	@yield('before-styles-start')
	{{ Html::style("vendor/bootstrap/css/bootstrap.min.css") }}
	{{ Html::style("vendor/font-awesome/css/font-awesome.min.css") }}
	@yield('styles')
    {{ Html::style("vendor/animate.css/animate.min.css") }}
	{{ Html::style("css/inspinia.css") }}
	@yield('after-styles-end')
</head>

<body class="skin-{{ config('backend.theme') }}">
    <div id="wrapper">
		@include('backend.includes.inspinia-sidebar')
		<div id="page-wrapper" class="gray-bg">
        	@include('backend.includes.inspinia-header')
        	<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>@yield('title')</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">This is</a>
                        </li>
                        <li class="active">
                            <strong>Breadcrumb</strong>
                        </li>
                        {!! Breadcrumbs::renderIfExists() !!}
                    </ol>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <a href="#" class="btn btn-primary">This is action area</a>
                    </div>
                </div>
            </div>
            <div class="wrapper wrapper-content">
            	@yield('content')
                <div class="middle-box text-center animated fadeInRightBig">
                    <h3 class="font-bold">This is page content</h3>
                    <div class="error-desc">
                        You can create here any grid layout you want. And any variation layout you imagine:) Check out
                        main dashboard and other site. It use many different layout.
                        <br/><a href="index.html" class="btn btn-primary m-t">Dashboard</a>
                    </div>
                </div>
            </div>
			@include('backend.includes.inspinia-footer')
        </div>
    </div>

    <!-- Mainly scripts -->
    @yield('before-scripts-start')
    {{ Html::script('vendor/jquery/jquery.min.js') }}
    {{ Html::script('vendor/bootstrap/js/bootstrap.min.js') }}
    {{ Html::script('vendor/metisMenu/metisMenu.min.js') }}
    {{ Html::script('vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}
	@yield('scripts')
    <!-- Custom and plugin javascript -->
    {{ Html::script('js/inspinia.js') }}
    {{ Html::script('vendor/PACE/pace.min.js') }}
	@yield('after-scripts-end')

</body>

</html>
