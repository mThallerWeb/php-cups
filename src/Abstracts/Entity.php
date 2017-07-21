<?php namespace MThallerWeb\PhpCups\Abstracts;

use MThallerWeb\PhpCups\Exceptions\CommandNotDefinedException;
use MThallerWeb\PhpCups\Helpers\Traits\ExtendedTraits;
use MThallerWeb\PhpCups\Responses\Error;
use MThallerWeb\PhpCups\Responses\StdResponse;
use Symfony\Component\Process\Process;

abstract class Entity
{
    /**
     * @return array
     */
    abstract public function toArray(): array;
}