<?php namespace MThaller\PhpCups\Entities;

use MThaller\PhpCups\Abstracts\Entity;
use MThaller\PhpCups\Exceptions\InvalidArgumentException;
use MThaller\PhpCups\Exceptions\InvalidStatusException;

class Printer extends Entity
{

    const STATUS_IDLE = 1;

    const STATUS_PRINTING = 2;

    const STATUS_UNDEFINED = 3;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var \DateTime
     */
    protected $enabledSince;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * Printer constructor.
     *
     * @param string $name
     * @param int $status
     * @param \DateTime $enabledSince
     * @param bool $enabled
     */
    public function __construct(string $name, int $status, \DateTime $enabledSince, bool $enabled)
    {
        $this->name = $name;
        $this->validateStatus($status);
        $this->status = $status;
        $this->enabledSince = $enabledSince;
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getEnabledSince(): \DateTime
    {
        return $this->enabledSince;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param int $status
     *
     * @throws InvalidStatusException
     */
    private function validateStatus(int $status)
    {
        if ($status !== Printer::STATUS_IDLE && $status !== Printer::STATUS_PRINTING && $status !== Printer::STATUS_UNDEFINED) {
            throw new InvalidArgumentException('The given status is not valid for a printer');
        }
    }

    /**
     *
     */
    public function toArray(): array
    {
        switch ($this->getStatus()) {
            case static::STATUS_IDLE:
                $status = 'idle';
                break;
            case static::STATUS_PRINTING:
                $status = 'printing';
                break;
            case static::STATUS_UNDEFINED:
            default:
                $status = 'undefined';
        }
        
        return [
            'name' => $this->getName(),
            'status' => $status,
            'enabled' => $this->isEnabled(),
            'enabled_since' => $this->getEnabledSince()->format('c')
        ];
    }
}