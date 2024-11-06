<?php

namespace Modules\User\Rules;

use Illuminate\Contracts\Validation\Rule as RuleContract;

class UserExisted implements RuleContract
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
                ->findOne(['username' => str_filter($value)]);

        return is_null($user) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.';
    }
}