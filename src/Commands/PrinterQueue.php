<?php namespace MThallerWeb\PhpCups\Commands;

use MThallerWeb\PhpCups\Abstracts\Command;
use MThallerWeb\PhpCups\Commands\Traits\UsesPrinter;
use MThallerWeb\PhpCups\Exceptions\InvalidArgumentException;
use MThallerWeb\PhpCups\Responses\PrinterList;

class PrinterQueue extends Command {
    use UsesPrinter;

    const JOB_STATUS_ALL = 1;

    const JOB_STATUS_COMPLETED = 2;

    const JOB_STATUS_NOT_COMPLETED = 3;

    /**
     * @var string
     */
    protected $command = 'lpstat {##jobStatus##} -o {##printerName##}';

    /**
     * @var string
     */
    protected $okResponseClass = \MThallerWeb\PhpCups\Responses\PrinterQueue::class;

    /**
     * @var int
     */
    protected $jobStatus = PrinterQueue::JOB_STATUS_ALL;

    /**
     * @return array
     */
    protected function getCommandDecorators(): array
    {
        $decorators = parent::getCommandDecorators();

        $decorators['jobStatus'] = '';
        if($this->jobStatus === PrinterQueue::JOB_STATUS_COMPLETED) {
            $decorators['jobStatus'] = '-W completed';
        } elseif($this->jobStatus === PrinterQueue::JOB_STATUS_NOT_COMPLETED) {
            $decorators['jobStatus'] = '-W not-completed';
        }

        return $decorators;
    }

    /**
     * @return int
     */
    public function getJobStatus(): int
    {
        return $this->jobStatus;
    }

    /**
     * @param int $jobStatus
     */
    public function setJobStatus(int $jobStatus)
    {
        $this->validateJobStatus($jobStatus);
        $this->jobStatus = $jobStatus;
    }

    /**
     * @param int $jobStatus
     */
    private function validateJobStatus(int $jobStatus) {
        if(array_search($jobStatus, [
            PrinterQueue::JOB_STATUS_ALL,
            PrinterQueue::JOB_STATUS_COMPLETED,
            PrinterQueue::JOB_STATUS_NOT_COMPLETED
        ]) === FALSE) {
            throw new InvalidArgumentException('The given job status is not valid');
        }
    }
}