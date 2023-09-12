<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class MessageDto
{
    public function __construct(
        #[Assert\Uuid]
        public string $uuid,
        #[Assert\Email]
        public string $email,
        #[Assert\Length(min: 3, max: 255)]
        public string $content,
        #[Assert\DateTime]
        public string $createdAt
    )
    {
    }
}