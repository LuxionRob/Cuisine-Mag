<?php

return [
    'Quantity' => 'Sô lượng',
    'Total' => 'Tổng cộng (:totalQuantity sản phẩm)',
    'Payment Method' => 'Phương thức thanh toán',
    'Amount' => 'Đơn giá',
    'id' => 'Mã',
    'empty' => 'Không tìm thấy đơn hàng nào',
    'validation' => [
        'status' => [
            'notAbleCancel' => 'Đơn hàng không thể thay đổi'
        ],
    ],
    'index' => [
        'title' => 'Đơn hàng',
    ],
    'show' => [
        'title' => 'Đơn hàng #:id',
    ],
    'create' => [
        'title' => 'Tạo đơn hàng',
        'cart' => [
            'required' => 'Không có sản phẩm để tạo đơn',
        ],
        'button' => 'Đặt hàng',
    ],
    'update' => [
        'success' => 'Tạo đơn hàng thành công',
        'fail' => 'Tạo đơn hàng không thành công',
    ],
    'store' => [
        'fail' => 'Tạo đơn hàng không thành công',
        'success' => 'Tạo đơn hàng thành công',
    ],
    'cancel' => [
        'button' => 'Hủy đơn',
        'success' => 'Đã hủy đơn hàng thành công',
        'message' => 'Sản phẩm không đã bị xóa',
    ],
];
