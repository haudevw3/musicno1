<?php

namespace Modules\User\Rules;

use Illuminate\Contracts\Validation\Rule as RuleContract;
use Modules\User\Request\FormUpdateUser;

class EmailExcept implements RuleContract
{
    /**
     * The current form request instance.
     *
     * @var \Modules\User\Request\FormUpdateUser
     */
    protected $request;

    public function __construct(FormUpdateUser $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $userRepo = app(\Modules\User\Repository\UserRepository::class);

        $user = $userRepo->findOne(['_id' => $this->request->input('id')]);

        if (($user->email == $value) ||
            (is_null($userRepo->findOne(['email' => $value])))) {
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
        return 'Tên email đã tồn tại. Vui lòng chọn email khác.';
    }
}