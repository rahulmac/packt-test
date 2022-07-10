<?php

namespace App\Http\Validators;

use Stringy\Stringy;

class ProductValidator extends ValidationBase
{
    private $page;
    private  $limit;
    private ?string $token;
    private ?string $endpoint;

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     * @return ProductValidator
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     * @return ProductValidator
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return ProductValidator
     */
    public function setToken(?string $token): ProductValidator
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEndpoint(): ?string
    {
        return $this->endpoint;
    }

    /**
     * @param string|null $endpoint
     * @return ProductValidator
     */
    public function setEndpoint(?string $endpoint): ProductValidator
    {
        $this->endpoint = $endpoint;
        return $this;
    }



    /**
     * Set the props from request
     */
    public function setFromRequest(): ProductValidator
    {
        $this->setPage($this->request->post('page') ?? 1);
        $this->setLimit($this->request->post('limit') ?? 100);
        return $this;
    }

    /**
     * @return array
     */
    public function getRules(): array
    {

        $rules = [
            'page' => 'numeric',
            'limit' => 'numeric',
        ];

        return $rules;
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        $messages = [];
        return $messages;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $setKeys = [
            'page',
            'limit'
        ];

        $data = [];
        foreach ($setKeys as $eachKey) {
            $getterMethod = 'get' . Stringy::create($eachKey)->toTitleCase()->replace('_', '')->replace('-', '');
            $data[$eachKey] = $this->$getterMethod();
        }

        return $data;

    }
}
