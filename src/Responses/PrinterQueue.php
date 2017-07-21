<?php namespace MThaller\PhpCups\Responses;

use MThaller\PhpCups\Abstracts\CommandResponse;
use MThaller\PhpCups\Entities\QueueEntry;

class PrinterQueue extends CommandResponse
{
    /**
     *
     */
    protected function convertData()
    {
        $printers = explode(PHP_EOL, $this->data);
        $queuesOut = [];

        foreach($printers as $line) {
            $line = trim($line);
            if($line == '') {continue;}

            $matches = [];
            if(preg_match('~([A-Za-z0-9_-]*)[\s]*([A-Za-z0-9_-]*)[\s]*([A-Za-z0-9_-]*)[\s]*([A-Za-z0-9_:\-\s]*)~', $line, $matches)){
                $queueId = $matches[1];
                $queueUser = $matches[2];
                $queueStartedAt = new \DateTime($matches[4]);
                $queueEntry = new QueueEntry($queueId, $queueUser, $queueStartedAt);
                $queuesOut[] = $queueEntry;
            }
        }

        $this->convertedData = $queuesOut;
    }

    /**
     * @return array
     */
    public function prepareDataForArray(): array
    {
        return [
            'response' => $this->convertedData
        ];
    }
}