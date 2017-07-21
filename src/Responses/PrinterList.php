<?php namespace MThaller\PhpCups\Responses;

use MThaller\PhpCups\Abstracts\CommandResponse;
use MThaller\PhpCups\Entities\Printer;

class PrinterList extends CommandResponse
{
    /**
     *
     */
    protected function convertData()
    {
        $printers = explode(PHP_EOL, $this->data);
        $printersOut = [];

        foreach($printers as $line) {
            $line = trim($line);
            if($line == '' || $line == 'Printing...') {continue;}

            $matches = [];
            if(preg_match('~printer ([A-Za-z0-9_-]*) (now printing ([[0-9]*])|is idle).  enabled since (.*)~', $line, $matches)){
                $printerName = $matches[1];
                $printerStatus = ($matches[2] == 'is idle') ? Printer::STATUS_IDLE : Printer::STATUS_IN_PROGRESS;
                $printerEnabledSince = new \DateTime($matches[4]);
                $printer = new Printer($printerName, $printerStatus, $printerEnabledSince);
                $printersOut[] = $printer;
            }

        }

        $this->convertedData = $printersOut;
    }

    /**
     * @return array
     */
    public function prepareDataForArray(): array
    {
        $arrayData = [];

        /** @var Printer $convertedPrinter */
        foreach($this->convertedData as $convertedPrinter) {
            $arrayData[] = $convertedPrinter->toArray();
        }

        return $arrayData;
    }
}