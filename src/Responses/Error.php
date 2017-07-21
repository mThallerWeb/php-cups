<?php namespace MThaller\PhpCups\Responses;

use MThaller\PhpCups\Abstracts\CommandResponse;

class Error extends StdResponse
{
    /**
     * @var int
     */
    protected $status = CommandResponse::STATUS_ERROR;
}