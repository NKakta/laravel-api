<?php

namespace App\Exceptions;

use Error;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Validation\ValidationException;
use Throwable;

class ErrorData implements Arrayable
{
    public const CODE_FIELD    = 'code';
    public const MESSAGE_FIELD = 'message';
    public const INPUTS_FIELD  = 'inputs';
    public const DEBUG_FIELD   = 'debug';
    public const BAG_FIELD     = 'bag';

    private const DISPLAYED_EXCEPTIONS = [
        ValidationException::class,
        AuthenticationException::class,
    ];

    /**
     * @var array
     */
    protected $data;

    /**
     * ErrorData constructor.
     * @param Exception|array|string|null $error
     */
    public function __construct($error = null)
    {
        $this->data = $this->getDefaultData();
        if ($error instanceof Exception && $this->isDisplayed($error)) {
            $this->parseFromException($error);
        } elseif ($error instanceof Error && env('APP_DEBUG', false)) {
            $this->parseFromError($error);
        } elseif (is_array($error)) {
            $this->parseFromArray($error);
        } elseif (is_string($error)) {
            $this->setMessage($error);
        }
    }

    public function getCode(): int
    {
        return $this->data[self::CODE_FIELD];
    }

    public function setCode(int $code): void
    {
        $this->data[self::CODE_FIELD] = $code;
    }

    public function getMessage(): string
    {
        return $this->data[self::MESSAGE_FIELD];
    }

    public function setMessage(string $message): void
    {
        $this->data[self::MESSAGE_FIELD] = $message;
    }

    public function setInputs(array $inputs): void
    {
        $this->data[self::INPUTS_FIELD] = $inputs;
    }

    public function getInputs(): ?array
    {
        if (array_key_exists(self::INPUTS_FIELD, $this->data)) {
            return $this->data[self::INPUTS_FIELD];
        }
        return null;
    }

    public function setBag(array $errors): void
    {
        $this->data[self::BAG_FIELD] = $errors;
    }

    public function getBag(): ?array
    {
        return $this->data[self::BAG_FIELD] ?? null;
    }

    private function setDebug(Throwable $exception): void
    {
        $this->data[self::DEBUG_FIELD] = [
            'code'    => $exception->getCode(),
            'line'    => $exception->getLine(),
            'file'    => $exception->getFile(),
            'message' => $exception->getMessage(),
            'trace'   => $exception->getTrace(),
        ];
    }

    public function toArray(): array
    {
        return $this->data;
    }

    protected function parseFromException(Exception $exception): void
    {
        $code = is_int($exception->getCode()) ?? 500;

        $this->setCode($code);
        $this->setMessage($exception->getMessage());

        if (env('APP_DEBUG', false)) {
            $this->setDebug($exception);
        }

        if ($exception instanceof ValidationException) {
            $this->setCode($exception->status);
            $this->setInputs($exception->errors());
        }
    }

    protected function parseFromError(Error $error): void
    {
        $this->setCode(500);
        $this->setMessage($error->getMessage());

        if (env('APP_DEBUG', false)) {
            $this->setDebug($error);
        }
    }

    protected function parseFromArray(array $error): void
    {
        if (array_key_exists(self::CODE_FIELD, $error)) {
            $this->setCode($error[self::CODE_FIELD]);
        }

        if (array_key_exists(self::MESSAGE_FIELD, $error)) {
            $this->setMessage($error[self::MESSAGE_FIELD]);
        }

        if (array_key_exists(0, $error) && is_string($error[0])) {
            $this->setMessage($error[0]);
        }

        if (array_key_exists(self::INPUTS_FIELD, $error) && is_array($error[self::INPUTS_FIELD])) {
            $this->setInputs($error[self::INPUTS_FIELD]);
        }
    }

    protected function isDisplayed(Exception $exception): bool
    {
        return in_array(get_class($exception), self::DISPLAYED_EXCEPTIONS) ||
            env('APP_DEBUG', false);
    }

    protected function getDefaultData(): array
    {
        return [
            self::CODE_FIELD    => 400,
            self::MESSAGE_FIELD => null,
        ];
    }
}
