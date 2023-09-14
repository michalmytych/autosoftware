<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class MessageCreateRequest extends BaseValidatedRequest
{
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Json]
    public mixed $content;
}