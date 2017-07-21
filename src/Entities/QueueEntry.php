<?php namespace MThallerWeb\PhpCups\Entities;

use MThallerWeb\PhpCups\Abstracts\Entity;
use MThallerWeb\PhpCups\Exceptions\InvalidArgumentException;
use MThallerWeb\PhpCups\Exceptions\InvalidStatusException;

class QueueEntry extends Entity
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var \DateTime
     */
    protected $startedAt;

    /**
     * Printer constructor.
     *
     * @param string $id
     * @param string $user
     * @param \DateTime $startedAt
     */
    public function __construct(string $id, string $user, \DateTime $startedAt)
    {
        $this->id = $id;
        $this->user = $user;
        $this->startedAt = $startedAt;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getStartedAt(): \DateTime
    {
        return $this->startedAt;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'user' => $this->getUser(),
            'started_at' => $this->getStartedAt()->format('c')
        ];
    }
}