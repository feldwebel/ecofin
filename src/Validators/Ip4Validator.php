<?php

declare(strict_types=1);

namespace App\Validators;

class Ip4Validator extends BaseValidator
{
    protected const REGEX = '/^((25[0-5]|(2[0-4]|1\d|[1-9]|)\d)\.?\b){4}$/';

    public function validate($value): bool
    {
        if (is_string($value) && preg_match(self::REGEX, $value)) {
            return true;
        }

        $this->addError("Value $value is not IPv4");
        return false;
    }
}
