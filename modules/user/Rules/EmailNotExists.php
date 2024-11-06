<?php

namespace Modules\User\Rules;

use Illuminate\Contracts\Validation\Rule as RuleContract;

class EmailNotExists implements RuleContract
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = app(\Modules\User\Repository\UserRepository::class)
                ->findOne(['email' => str_filter($value)]);

        return ! is_null($user) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'Tên email không tồn tại. Vui lòng kiểm tra lại thông tin.';
    }
}