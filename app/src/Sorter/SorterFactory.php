<?php

namespace App\Sorter;

use Symfony\Component\HttpFoundation\Request;

final class SorterFactory
{
    public const ALLOWED_SORTING_ORDERS = [
        'asc', 'desc'
    ];

    public function makeFromRequest(Request $request): Sorter
    {
        $key = $request->get('key');
        $order = strtolower($request->get('order'));

        return new Sorter(
            key: $key,
            order: $order ? in_array($order, self::ALLOWED_SORTING_ORDERS) : null,
        );
    }
}