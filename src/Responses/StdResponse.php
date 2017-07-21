<?php namespace MThaller\PhpCups\Responses;

use MThaller\PhpCups\Abstracts\CommandResponse;

class StdResponse extends CommandResponse
{
    /**
     *
     */
    protected function convertData()
    {
        $this->convertedData = explode(PHP_EOL, $this->data);
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