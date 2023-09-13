<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class MessageDto
{
    public function __construct(
        #[Assert\Uuid]
        public ?string $uuid,
        #[Assert\NotNull]
        public array $content,
        #[Assert\DateTime]
        public ?\DateTimeImmutable $createdAt
    )
    {
    }
}