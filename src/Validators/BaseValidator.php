<?php

declare(strict_types=1);

namespace App\Validators;

abstract class BaseValidator implements IValidator
{
    private string $error;

    abstract public function validate($value): bool;

    public function getError(): ?string
    {
        return $this->error;
    }

    protected function addError(string $error): static
    {
        $this->error = $error;
        return $this;
    }
}
