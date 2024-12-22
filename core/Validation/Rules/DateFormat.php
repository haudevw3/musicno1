<?php

namespace Core\Validation\Rules;

use Core\Validation\TraitRule;
use Illuminate\Contracts\Validation\Rule;

class DateFormat implements Rule
{
    use TraitRule;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
    //     $segments = explode('-', $value);

    //    return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return $this->message;
    }
}