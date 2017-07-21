<?php namespace MThaller\PhpCups\Abstracts;

use MThaller\PhpCups\Exceptions\InvalidStatusException;

abstract class CommandResponse
{

    const STATUS_ERROR = 0;
    const STATUS_OK = 1;

    /**
     * @var int
     */
    protected $status = CommandResponse::STATUS_OK;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var array
     */
    protected $convertedData = [];

    /**
     * CommandAbstract constructor.
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->data = $data;
        $this->convertData();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'status' => $this->getStatusAsString(),
            'data' => $this->prepareDataForArray()
        ];
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @throws InvalidStatusException
     */
    public function setStatus(int $status)
    {
        if ($status !== CommandResponse::STATUS_OK && $status !== CommandResponse::STATUS_ERROR) {
            throw new InvalidStatusException();
        }
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatusAsString(): string
    {
        switch ($this->status) {
            case static::STATUS_ERROR:
                return 'error';
            case static::STATUS_OK:
                return 'ok';
        }
    }

    /**
     * @return array
     */
    abstract public function prepareDataForArray(): array;

    /**
     * @return mixed
     */
    abstract protected function convertData();

    /**
     * @return array
     */
    public function getConvertedData(): array
    {
        return $this->convertedData;
    }
}