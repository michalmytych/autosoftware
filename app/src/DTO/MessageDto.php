<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class MessageDto
{
    #[Assert\Uuid]
    public ?string $uuid;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Json]
    public mixed $content;

    #[Assert\DateTime]
    public ?\DateTimeImmutable $createdAt;

    public function __construct($uuid, $content, $createdAt)
    {
        $this->uuid = $uuid;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }
}