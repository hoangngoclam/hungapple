<?php

return [
    'sort_by' => [
        'default' => ['by' => 'created_at', 'type' => 'desc', 'text' => 'Mặc định'],
        'popular' => ['by' => 'sold', 'type' => 'desc', 'text' => 'Bán chạy'],
        'newest' => ['by' => 'created_at', 'type' => 'desc', 'text' => 'Mới nhất'],
        'price' => ['by' => 'price', 'type' => 'asc', 'text' => 'Giá từ thấp đến cao'],
        'priceDesc' => ['by' => 'price', 'type' => 'desc', 'text' => 'Giá từ cao đến thấp']
    ]
];
