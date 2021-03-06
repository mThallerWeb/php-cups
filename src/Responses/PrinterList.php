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

        foreach ($printers as $line) {
            $line = trim($line);
            if ($line == '' || $line == 'Printing...') {
                continue;
            }

            $matches = [];
            if (preg_match('~printer ([A-Za-z0-9_-]*) (now printing ([A-Za-z0-9_-]*)|is idle)\.  (enabled|disabled) since (.*)~',
                $line, $matches)) {
                $printerName = $matches[1];
                $printerStatus = Printer::STATUS_UNDEFINED;
                if ($matches[2] == 'is idle') {
                    $printerStatus = Printer::STATUS_IDLE;
                } elseif (strpos($matches[2], 'now printing') !== false) {
                    $printerStatus = Printer::STATUS_PRINTING;
                }
                $printerEnabled = ($matches[4] == 'enabled');
                $printerEnabledSince = new \DateTime($matches[5]);
                $printer = new Printer($printerName, $printerStatus, $printerEnabledSince, $printerEnabled);
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
        foreach ($this->convertedData as $convertedPrinter) {
            $arrayData[] = $convertedPrinter->toArray();
        }

        return $arrayData;
    }
}