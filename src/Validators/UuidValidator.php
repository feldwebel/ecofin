<?php

declare(strict_types=1);

namespace App\Validators;

class UuidValidator extends BaseValidator
{
    protected const REGEX = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    public function validate($value): bool
    {
        if (is_string($value) && preg_match(self::REGEX, $value)) {
            return true;
        }

        $this->addError("Value $value is not uuid");
        return false;
    }
}
