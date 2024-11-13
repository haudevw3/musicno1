<?php

namespace Core\Validation;

use Core\Repository\Contracts\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;

trait TraitRule
{
    /**
     * The base repository instance.
     *
     * @var \Core\Repository\Contracts\BaseRepository
     */
    protected $repository;

    /**
     * The validation error message.
     *
     * @var string
     */
    protected $message;

    /**
     * The form request instance.
     *
     * @var \Illuminate\Foundation\Http\FormRequest
     */
    protected $request;

    /**
     * Create a new rule instance.
     *
     * @param  string                                     $message
     * @param  \Core\Repository\Contracts\BaseRepository  $repository
     * @param  \Illuminate\Foundation\Http\FormRequest    $request
     * @return void
     */
    public function __construct(string $message, BaseRepository $repository, FormRequest $request = null)
    {
        $this->message = $message;
        $this->request = $request;
        $this->repository = $repository;
    }
}