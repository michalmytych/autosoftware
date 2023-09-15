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
        $key = $request->get('sorterKey');
        $order = strtoupper($request->get('sorterOrder'));

        return new Sorter(
            key: $key,
            order: in_array($order, self::ALLOWED_SORTING_ORDERS) ? $order : null,
        );
    }
}