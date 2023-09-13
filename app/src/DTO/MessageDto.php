<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class MessageDto
{
    public function __construct(
        #[Assert\Uuid]
        public ?string $uuid,
        #[Assert\Length(min: 3, max: 2056)]
        public string $content,
        #[Assert\DateTime]
        public ?\DateTimeImmutable $createdAt
    )
    {
    }
}