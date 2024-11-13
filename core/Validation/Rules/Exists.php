<?php

namespace Core\Validation\Rules;

use Core\Validation\TraitRule;
use Illuminate\Contracts\Validation\Rule;

class Exists implements Rule
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
        $result = $this->repository->findOne([$attribute => $value]);

        return is_null($result) ? true : false;
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