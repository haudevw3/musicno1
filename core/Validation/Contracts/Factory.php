<?php

namespace Core\Validation\Contracts;

use Illuminate\Foundation\Http\FormRequest;

interface Factory
{
    /**
     * Create a new rule instance with the given arguments.
     *
     * @param  string                                   $repositoryName
     * @param  string                                   $rule
     * @param  string                                   $message
     * @param  \Illuminate\Foundation\Http\FormRequest  $request
     * @return \Illuminate\Contracts\Validation\Rule
     */
    public function make($repositoryName, $rule, $message, FormRequest $request = null);
}