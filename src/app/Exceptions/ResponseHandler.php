<?php

namespace App\Exceptions;

use Error;
use Exception;
use GuzzleHttp\Psr7\Response;
use Throwable;

final class ResponseHandler
{
    /**
     * @param string|array|bool|null|Response|Exception $content
     * @param int|null $status
     * @param array $headers
     * @return ApiResponse
     */
    public static function response($content = null, int $status = null, array $headers = []): ApiResponse
    {
        if ($content instanceof Exception) {
            $responseContent = self::getContentFromException($content);
        } elseif ($content instanceof Error) {
            $responseContent = self::getContentFromError($content);
        } elseif ($content instanceof Response) {
            $responseContent = self::getContentFromResponse($content);
        } else {
            $responseContent = new ResponseContent($content, $status);
        }
        return new ApiResponse($responseContent, $headers);
    }

    private static function getContentFromException(Exception $exception): ResponseContent
    {
        return new ResponseContent(null, null, new ErrorData($exception));
    }

    private static function getContentFromError(Error $error): ResponseContent
    {
        return new ResponseContent(null, 500, $error);
    }

    private static function getContentFromResponse(Response $response): ResponseContent
    {
        $content = new ResponseContent();
        $content->setStatus($response->getStatusCode());

        $body = $response->getBody()->getContents();
        $data = self::isJson($body) ? json_decode($body, true) : $body;

        if (is_array($data)) {
            $content->setData(
                array_key_exists(ResponseContent::DATA_FIELD, $data) ?
                    $data[ResponseContent::DATA_FIELD] :
                    (array_key_exists('result', $data) ? $data['result'] : $data)
            );
            $content->setError($data[ResponseContent::ERROR_FIELD] ?? null);
            $content->setExecutionTime($data[ResponseContent::EXECUTION_TIME_FIELD] ?? null);
        } else {
            $content->setData($data);
        }

        return $content;
    }

    private static function isJson($string): bool
    {
        return is_string($string) &&
            is_array(json_decode($string, true)) &&
            (json_last_error() == JSON_ERROR_NONE);
    }
}
