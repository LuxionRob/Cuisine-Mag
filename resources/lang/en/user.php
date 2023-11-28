<?php

return [
    'button' => 'Create a user',
    'username' => 'Username',
    'fullname' => 'Full name',
    'password' => "Password",
    'firstName' => 'First name',
    'lastName' => 'Last name',
    'index' => [
        'title' => 'Users list',
        'table' => [
            'id' => '#',
            'username' => 'Username',
            'actions' => 'Actions'
        ],
    ],
    'show' => [
        'title' => 'User Information',
    ],
    'edit' => [
        'title' => 'Edit user',
    ],
    'update' => [
        'success' => 'User updated successfully!',
    ],
    'create' => [
        'title' => 'Add New User',
    ],
    'store' => [
        'success' => 'User created successfully!',
    ],
    'destroy' => [
        'success' => 'User deleted successfully!',
    ],
    'products' => [
        'button' => 'Create A Product',
        'Product inventory' => 'Product inventory',
        'table' => [
            'id' => '#',
            'name' => 'Name',
            'price' => 'Price',
            'images' => 'Image',
            'numberStock' => 'Number in Stock',
        ],
        'delete' => [
            'success' => 'Delete product successfully',
        ],
    ],
];
