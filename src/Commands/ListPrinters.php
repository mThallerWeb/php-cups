<?php namespace MThallerWeb\PhpCups\Commands;

use MThallerWeb\PhpCups\Abstracts\Command;
use MThallerWeb\PhpCups\Responses\PrinterList;

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