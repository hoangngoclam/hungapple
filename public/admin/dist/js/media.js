$('.custom-control.image-checkbox .custom-control-input').change(function () {

});
$(document).on('change', '.custom-control.image-checkbox .custom-control-input', function () {
    var $checkedBoxes = $('.custom-control.image-checkbox .custom-control-input:checked');
    if ($checkedBoxes.length > 0) {
        $('#mediaLibraryChooseBtn').css('display', 'block');
    } else {
        $('#mediaLibraryChooseBtn').css('display', 'none');
    }
});


$(document).on('click', '.btn-load-more', function () {
    var page = $(this).data('page');
    $('.btn-load-more').prop("disabled", true);
    $('.btn-load-more').html('Đang tải ...');
    loadMoreMedia(page);
});


function loadMoreMedia(page) {
    $.ajax({
        url: mediaListUrl + "?page=" + page,
        datatype: "html",
        type: "get"
    })
        .done(function (response) {
            $('.btn-load-more').remove();
            $("#mediaList").append(response);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occured');
        });
}