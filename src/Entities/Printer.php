<?php namespace MThallerWeb\PhpCups\Entities;

use MThallerWeb\PhpCups\Abstracts\Entity;
use MThallerWeb\PhpCups\Exceptions\InvalidArgumentException;
use MThallerWeb\PhpCups\Exceptions\InvalidStatusException;

class Printer extends Entity {

    const STATUS_IDLE = 1;

    const STATUS_IN_PROGRESS = 2;

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
     * Printer constructor.
     *
     * @param string $name
     * @param int $status
     * @param \DateTime $enabledSince
     */
    public function __construct(string $name, int $status, \DateTime $enabledSince)
    {
        $this->name = $name;
        $this->validateStatus($status);
        $this->status = $status;
        $this->enabledSince = $enabledSince;
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
     * @param int $status
     *
     * @throws InvalidStatusException
     */
    private function validateStatus(int $status) {
        if($status !== Printer::STATUS_IDLE && $status !== Printer::STATUS_IN_PROGRESS) {
            throw new InvalidArgumentException('The given status is not valid for a printer');
        }
    }

    /**
     *
     */
    public function toArray():array {
        return [
            'name' => $this->getName(),
            'status' => ($this->getStatus() == Printer::STATUS_IDLE) ? 'idle' : 'progress',
            'enabled_since' => $this->getEnabledSince()->format('c')
        ];
    }
}