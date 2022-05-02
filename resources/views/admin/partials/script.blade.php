<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{url('admin/assets/libs/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{url('admin/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{url('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- apps -->
<script src="{{url('admin/dist/js/app.min.js')}}"></script>
<script src="{{url('admin/dist/js/app.init.light-sidebar.js')}}"></script>
<script src="{{url('admin/dist/js/app-style-switcher.js')}}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{url('admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{url('admin/assets/extra-libs/sparkline/sparkline.js')}}"></script>
<!--Wave Effects -->
<script src="{{url('admin/dist/js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{url('admin/dist/js/sidebarmenu.js')}}"></script>
<script src="{{url('admin/dist/js/media.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{url('admin/dist/js/custom.min.js')}}"></script>
<!-- Datatable -->
<script src="{{url('admin/assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{url('admin/dist/js/pages/datatable/datatable-basic.init.js')}}"></script>

@include('admin.partials.js-variables')

<!--This page JavaScript -->
<script>
    const PUBLISH_PATH = "{{ config('app.url') }}";
</script>

@yield('script')