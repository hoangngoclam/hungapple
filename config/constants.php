<?php
return [
    'pagination' => [
        'ITEMS_PER_PAGE' => 9,
        'MEDIA_THUMBS_PER_PAGE' => 16
    ],
    'json_response' => [
        'SUCCESS_STATUS' => 1,
        'FAIL_STATUS' => 0
    ],
    'slider' => [
        'MAX_ITEMS' => 5
    ],
    'order' => [
        'SHIPPING_FEE' => 0
    ],
    'payment_method' => [
        'POSTPAID' => 1,
        'TRANSFER' => 0
    ],
    'TEMP_IMAGE_EXPIRATION' => now()->addMinutes(30)
];
