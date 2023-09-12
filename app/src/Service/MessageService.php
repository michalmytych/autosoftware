<?php

namespace App\Service;

use App\DTO\MessageDto;
use App\Service\Interface\MessageServiceInterface;
use App\Sorter\Sorter;

class MessageService implements MessageServiceInterface
{
    public function findAll(Sorter $sorter): array
    {
        // TODO: Implement findAll() method.
    }

    public function find(string $uuid): ?MessageDto
    {
        // TODO: Implement find() method.
    }

    public function save(MessageDto $dto): MessageDto
    {
        // TODO: Implement save() method.
    }
}