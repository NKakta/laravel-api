<?php


namespace App\Exceptions;


use Illuminate\Contracts\Support\Arrayable;

class ResponseContent implements Arrayable
{
    public const STATUS_FIELD               = 'status';
    public const SUCCESS_FIELD              = 'success';
    public const DATA_FIELD                 = 'data';
    public const ERROR_FIELD                = 'error';
    public const EXECUTION_TIME_FIELD       = 'execution_time';
    public const EXECUTION_TIME_TOTAL_FIELD = 'execution_time_total';

    /**
     * @var array
     */
    protected $content = [];

    public function __construct($data = null, int $status = null, $error = null)
    {
        $this->setStatus($status);
        $this->setData($data);
        $this->setError($error);
        $this->setExecutionTime(null);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        if ($this->content[self::STATUS_FIELD] === 500) {
            return $this->content[self::STATUS_FIELD];
        }

        if ($this->getError()) {
            if ($this->getError()->getCode() < 100 || $this->getError()->getCode() >= 600) {
                return 400;
            }
            return $this->getError()->getCode();
        } elseif (!$this->content[self::STATUS_FIELD]) {
            return 200;
        }

        return $this->content[self::STATUS_FIELD];
    }

    public function setStatus(?int $status): void
    {
        $this->content[self::STATUS_FIELD] = $status;
    }

    public function isSuccess(): bool
    {
        return !$this->getError();
    }

    /**
     * @return array|bool|string|null
     */
    public function getData()
    {
        return $this->content[self::DATA_FIELD];
    }

    /**
     * @param array|bool|string|null $data
     */
    public function setData($data): void
    {
        $this->content[self::DATA_FIELD] = $data;
    }

    public function getError(): ?ErrorData
    {
        if (!$this->content[self::ERROR_FIELD] instanceof ErrorData &&
            $this->content[self::ERROR_FIELD] !== null) {
            $this->setError($this->content[self::ERROR_FIELD]);
        }

        return $this->content[self::ERROR_FIELD];
    }

    /**
     * @param ErrorData|array|string|null $error
     */
    public function setError($error): void
    {
//        if ($this->content[self::STATUS_FIELD] === 500)
//        {
//            $this->content[self::ERROR_FIELD] = [
//                'code' => $this->content[self::STATUS_FIELD],
//                'm' => $this->content[self::STATUS_FIELD]
//            ];
//        }

        if (!$error instanceof ErrorData && $error !== null) {
            $error = new ErrorData($error);
        }

        $this->content[self::ERROR_FIELD] = $error;
    }

    public function getExecutionTime(): ?float
    {
        return $this->content[self::EXECUTION_TIME_FIELD];
    }

    public function setExecutionTime(?float $executionTime): void
    {
        $this->content[self::EXECUTION_TIME_FIELD] = $executionTime;
    }

    public function getExecutionTimeTotal(): ?float
    {
        if(defined('LARAVEL_START')) {
            return number_format(microtime(true) - LARAVEL_START, 3);
        }
        return null;
    }

    public function toArray(): array
    {
        return [
            self::STATUS_FIELD               => $this->getStatus(),
            self::SUCCESS_FIELD              => $this->isSuccess(),
            self::DATA_FIELD                 => $this->getData(),
            self::ERROR_FIELD                => $this->getError() ?
                $this->getError()->toArray() : $this->getError(),
            self::EXECUTION_TIME_FIELD       => $this->getExecutionTime(),
            self::EXECUTION_TIME_TOTAL_FIELD => $this->getExecutionTimeTotal(),
        ];
    }
}
