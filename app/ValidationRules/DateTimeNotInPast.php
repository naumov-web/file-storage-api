<?php

namespace App\ValidationRules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class DateTimeNotInPast
 * @package App\ValidationRules
 */
final class DateTimeNotInPast implements Rule
{

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        if (!$value) {
            return true;
        }

        $timestamp = strtotime($value);

        if ($timestamp === false) {
            return true;
        }

        $now = time();

        return $now < $timestamp;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return __('validation.datetime_cannot_be_past');
    }
}
