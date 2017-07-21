<?php namespace MThaller\PhpCups\Commands;

use MThaller\PhpCups\Abstracts\Command;
use MThaller\PhpCups\Responses\PrinterList;

class ListPrinters extends Command {

    /**
     * @var string
     */
    protected $command = 'lpstat -p';

    /**
     * @var string
     */
    protected $okResponseClass = PrinterList::class;
}