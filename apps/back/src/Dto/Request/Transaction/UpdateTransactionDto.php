<?php

declare(strict_types=1);

namespace App\Dto\Request\Transaction;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateTransactionDto
{
    #[Assert\NotBlank]
    #[Assert\Length(min:3, max: 200)]
    public string $localization;

    public function getLocalization(): string
    {
        return $this->localization;
    }
}
