<?php

namespace App\Sorter;

use Symfony\Component\HttpFoundation\Request;

final class SorterFactory
{
    public const ALLOWED_SORTING_ORDERS = [
        'ASC', 'DESC'
    ];

    public function makeFromRequest(Request $request): Sorter
    {
        $key = $request->get('key');
        $order = strtoupper($request->get('order'));

        return new Sorter(
            key: $key,
            order: $order ? in_array($order, self::ALLOWED_SORTING_ORDERS) : null,
        );
    }
}