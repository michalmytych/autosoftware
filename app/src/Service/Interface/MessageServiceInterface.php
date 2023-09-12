<?php

namespace App\Service\Interface;

use App\DTO\MessageDto;
use App\Sorter\Sorter;

interface MessageServiceInterface
{
    public function findAll(Sorter $sorter): array;

    public function find(string $uuid): ?MessageDto;

    public function save(MessageDto $dto): MessageDto;
}