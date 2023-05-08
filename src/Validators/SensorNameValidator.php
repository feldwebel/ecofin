<?php

declare(strict_types=1);

namespace App\Validators;

class SensorNameValidator extends BaseValidator
{
    private array $validators;

    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function validate($value): bool
    {
        foreach ($this->validators as $validator) {
            if ($validator->validate($value)) {
                return true;
            }
        }

        $this->addError("Value $value is not valid sensor name");
        return false;
    }
}
