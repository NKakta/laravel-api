<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ApiResponse extends Response
{
    /**
     * @var ResponseContent
     */
    protected $responseContent;

    public function __construct(ResponseContent $content, array $headers = [])
    {
        parent::__construct($content, $content->getStatus(), $headers);
        $this->responseContent = $content;
    }

    /**
     * @return array|bool|string|null
     */
    public function getData()
    {
        return $this->responseContent->getData();
    }

    public function isSuccessful(): bool
    {
        return $this->responseContent->isSuccess();
    }

    public function getError(): ?ErrorData
    {
        return $this->responseContent->getError();
    }

    public function getResponseContent(): ResponseContent
    {
        return $this->responseContent;
    }
}
