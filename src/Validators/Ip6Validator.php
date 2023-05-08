<?php

declare(strict_types=1);

namespace App\Validators;

class Ip6Validator extends BaseValidator
{
    protected const REGEX = '/^(?:[A-Fa-f0-9]{1,4}:){7}[A-Fa-f0-9]{1,4}$/';

    public function validate($value): bool
    {
        if (is_string($value) && preg_match(self::REGEX, $value)) {
            return true;
        }

        $this->addError("Value $value is not IPv6");
        return false;
    }
}
