
//Handle select location
$('.choose').on('change', function () {
    var action = $(this).attr('id');
    var ma_id = $(this).val();
    var result = '';
    if (action == 'province') {
        result = 'district';
    } else {
        result = 'ward';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        url: deliveryUrl,
        method: 'POST',
        data: { action: action, ma_id: ma_id },
        success: function (data) {
            $('#' + result).html(data);
        }
    });
});