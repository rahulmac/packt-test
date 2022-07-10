<?php

namespace App\Http\Validators;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

/**
 * Class Validation
 *
 * @package App\Http\Validation
 */
abstract class ValidationBase
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request): ValidationBase
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @throws BindingResolutionException
     */
    public function validate()
    {
        $validatorFactory = app('Illuminate\Validation\Factory');
        $validator = $validatorFactory->make($this->getData(), $this->getRules(), $this->getMessages());

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

    /**
     * Get validation rules for the current request.
     *
     * @return array
     */

    public function getRules(): array
    {
        return [];
    }

    /**
     * Get messages if rules not met.
     *
     * @return array
     */
    public function getMessages(): array
    {
        return [];
    }

    /**
     * Get Data to validate in request
     * @return array
     */
    public function getData(): array
    {
        return [];
    }

    /**
     * validateRequest
     *
     * @return array|bool
     * @throws BindingResolutionException
     */
    public function validateRequest()
    {
        $data = $this->validate();
        $errorMsg = [];

        if (!is_a($data, MessageBag::class)) {
            return true;
        }

        $errors = $data->getMessages();

        foreach ($errors as $field=>$error) {
            foreach ($error as $msg) {
                $errorMsg[$field] = $msg;
            }
        }

        return $errorMsg;
    }
}
