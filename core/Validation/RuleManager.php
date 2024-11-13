<?php

namespace Core\Validation;

use Core\Validation\Contracts\Factory;
use Illuminate\Foundation\Http\FormRequest;
use InvalidArgumentException;

class RuleManager implements Factory
{
    /**
     * An array contains mapping the rule with its' class name.
     *
     * @var array
     */
    protected $rules = [
        'exists' => \Core\Validation\Rules\Exists::class,
        'except' => \Core\Validation\Rules\Except::class,
        'not_exists' => \Core\Validation\Rules\NotExists::class,
    ];

    /**
     * Create a new rule instance with the given arguments.
     *
     * @param  string                                   $repositoryName
     * @param  string                                   $rule
     * @param  string                                   $message
     * @param  \Illuminate\Foundation\Http\FormRequest  $request
     * @return \Illuminate\Contracts\Validation\Rule
     */
    public function make($repositoryName, $rule, $message, FormRequest $request = null)
    {
        if (! isset($this->rules[$rule])) {
            throw new InvalidArgumentException("The rule name [$rule] is invalid.");
        }

        $className = $this->rules[$rule];

        return new $className($message, app($repositoryName), $request);
    }
}