<?php

return [
    'Quantity' => 'Quantity',
    'Total' => 'Total (:totalQuantity products)',
    'Payment Method' => 'Payment Method',
    'id' => '#',
    'empty' => 'Order list is empty',
    'validation' => [
        'status' => [
            'notAbleCancel' => 'Order can\'t be changed'
        ],
    ],
    'index' => [
        'title' => 'Orders',
    ],
    'show' => [
        'title' => 'Order #:id',
    ],
    'create' => [
        'title' => 'Create order',
        'cart' => [
            'required' => 'Cart item is required',
        ],
        'button' => 'Order',
    ],
    'update' => [
        'success' => 'Order created successfully',
        'fail' => 'Something went wrong when updating order',
    ],
    'store' => [
        'fail' => 'Something went wrong when creating order',
        'success' => 'Order created successfully',
    ],
    'cancel' => [
        'button' => 'Cancel Order',
        'success' => 'Order canceled successfully',
        'message' => 'Product was deleted',
    ],
];
