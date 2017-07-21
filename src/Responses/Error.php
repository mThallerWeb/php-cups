<?php namespace MThallerWeb\PhpCups\Responses;

use MThallerWeb\PhpCups\Abstracts\CommandResponse;

class Error extends StdResponse
{
    /**
     * @var int
     */
    protected $status = CommandResponse::STATUS_ERROR;
}