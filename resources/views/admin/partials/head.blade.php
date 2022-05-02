<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Favicon icon -->
<link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/x-icon">
<title>{{isset($pageName)?$pageName:'Quản Lý'}} | Hung Apple</title>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;1,700&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ url('admin/dist/css/bootstrap-image-checkbox.min.css') }}">
<!-- Data table -->
<link href="{{ url('admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<!-- Custom CSS -->
<link href="{{ url('admin/dist/css/style.min.css') }}" rel="stylesheet">
<link href="{{ url('admin/dist/css/custom.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

<style>
    .topbar {
        z-index: 999;
    }

</style>
@yield('style')
