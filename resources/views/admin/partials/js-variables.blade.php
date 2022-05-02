<script>
    var csrfToken = "{{ csrf_token(); }}";
    // API url
    var categoriesLv2APIUrl = "{{ route('admin.api.categoriesLv2', false) }}";
    var serviceCategoriesLv2APIUrl = "{{ route('admin.api.serviceCategoriesLv2', false) }}";
    var mediaListUrl = '{{ route("admin.media") }}';
</script>