<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', '后台管理')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{cdn_asset('assets/admin-lte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{cdn_asset('assets/admin-lte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{cdn_asset('assets/admin-lte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{cdn_asset('assets/admin-lte/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{cdn_asset('assets/admin-lte/dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{cdn_asset('assets/plugins/toastr/toastr.min.css')}}">

    <link rel="stylesheet" href="{{cdn_asset('assets/css/reset.css')}}">
    <link rel="stylesheet" href="{{cdn_asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{cdn_asset('assets/plugins/sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{ cdn_asset('/assets/admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ cdn_asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- jQuery 3 -->
    <script src="{{cdn_asset('assets/admin-lte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{cdn_asset('assets/admin-lte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- SlimScroll -->
    <script src="{{cdn_asset('assets/admin-lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{cdn_asset('assets/admin-lte/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{cdn_asset('assets/admin-lte/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{cdn_asset('assets/admin-lte/dist/js/demo.js')}}"></script>
    <!-- toastr -->
    <script src="{{cdn_asset('assets/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{cdn_asset('assets/plugins/layui/layer.js')}}"></script>
    <script src="{{cdn_asset('assets/plugins/sweetalert/sweetalert-dev.js')}}"></script>
    <script src="{{cdn_asset('assets/plugins/jquery-form/jquery.form.js')}}"></script>
    <script src="{{ cdn_asset('/assets/admin/js/select2.min.js') }}"></script>
    <script src="{{ cdn_asset('/assets/admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ cdn_asset('/assets/admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js?v=3') }}"></script>
    <script src="{{ cdn_asset('/assets/js/plugincommon.js?v=3') }}"></script>
    @yield('css')
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    @include('layouts.left')
    @include('layouts.header')
    @yield('content')
    @include('layouts.footer')
    @include('layouts.tip')

</div>
<!-- ./wrapper -->
</body>
</html>
@yield('script')
<script>
    $('.select2').select2();
    addDateRangePicker($('#daterange'));
    addDateRangePicker($('#daterange2'));
    $(function () {
        var daterange = "{{old('daterange')}}";
        if (daterange) {
            $('#daterange').val(daterange);
        }
        var daterange2 = "{{old('daterange2')}}";
        if (daterange2) {
            $('#daterange2').val(daterange2);
        }
    })
</script>
