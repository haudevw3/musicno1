<?php

namespace Core\Validation\Rules;

use Core\Validation\TraitRule;
use Illuminate\Contracts\Validation\Rule;

class Except implements Rule
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
        $id = $this->request->input('id');
        $id = ! is_null($id) ? $id : $this->request->route('id');

        $result = $this->repository->findOne($id);

        if (($result->{$attribute} == $value) ||
            (is_null($this->repository->findOne([$attribute => $attribute !== 'name' ? $value : str_ucwords($value)])))) {
            return true;
        }

       return false;
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