<?php

namespace App\Sorter;

class Sorter
{
    public function __construct(
        public ?string $key = null,
        public ?string $order = null
    )
    {
    }
}