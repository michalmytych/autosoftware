<?php

namespace App\Service\Interface;

use App\Sorter\Sorter;
use App\DTO\MessageDto;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface MessageServiceInterface
{
    public function getPaginatedList(Sorter $sorter, int $page = 1): PaginationInterface;

    public function find(string $uuid): ?MessageDto;

    public function save(MessageDto $dto): MessageDto;
}