<?php

namespace Core\Facades;

use Core\Validation\Contracts\Factory;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Contracts\Validation\Rule make(string $repositoryName, string $rule, string $message, FormRequest $request = null)
 *
 * @see \Core\Validation\RuleManager
 */
class Rule extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}