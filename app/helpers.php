<?php

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount, $type)
    {
        if (!isset($type)) {
            $type = App::getLocale();
        }
        switch ($type) {
            case 'vi':
                return number_format($amount * 23000, 0, ',', '.') . '₫';
            case 'en':
                return '$' . number_format($amount, 2, '.', ',');
            default:
                return '$' . number_format($amount, 2, '.', ',');
        }
    }
}
