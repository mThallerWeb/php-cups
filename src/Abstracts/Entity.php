<?php namespace MThaller\PhpCups\Abstracts;

use MThaller\PhpCups\Exceptions\CommandNotDefinedException;
use MThaller\PhpCups\Helpers\Traits\ExtendedTraits;
use MThaller\PhpCups\Responses\Error;
use MThaller\PhpCups\Responses\StdResponse;
use Symfony\Component\Process\Process;

abstract class Entity
{
    /**
     * @return array
     */
    abstract public function toArray(): array;
}