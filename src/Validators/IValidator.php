<?php

declare(strict_types=1);

namespace App\Validators;

interface IValidator
{
    public function validate($value): bool;

    public function getError(): ?string;
}
