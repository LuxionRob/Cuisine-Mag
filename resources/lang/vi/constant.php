<?php

return [
    'orderStatus' => [
        'WAITING' => 'Chờ người bán xác nhận có hàng',
        'PACKAGING' => 'Đang đóng gói',
        'PACKAGED' => 'Đã đóng gói xong. Đang chờ bàn giao cho đơn vị vận chuyển',
        'DELIVERING' => 'Đơn hàng đang được vận chuyển',
        'DELIVERED' => 'Đã nhận hàng',
        'CANCELED' => 'Đơn hàng đã được hủy',
    ],
    'paymentMethod' => [
        'CASH' => 'Trả khi nhận hàng',
        'VISA_CARD' => 'Sử dụng thẻ tín dụng',
    ],
];
