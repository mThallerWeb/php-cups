<?php namespace MThallerWeb\PhpCups\Commands;

use MThallerWeb\PhpCups\Abstracts\Command;
use MThallerWeb\PhpCups\Commands\Traits\UsesPrinter;
use MThallerWeb\PhpCups\Exceptions\InvalidArgumentException;
use MThallerWeb\PhpCups\Responses\PrinterList;

class PrintDocument extends Command {

    use UsesPrinter;
    /**
     * @var string
     */
    protected $command = 'lpr -P {##printerName##} {##amount##} {##filePath##}';

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var int
     */
    protected $amount = 1;

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return array
     */
    public function getCommandDecorators(): array
    {
        $decorators = parent::getCommandDecorators();

        $decorators['filePath'] = $this->filePath;
        $decorators['amount'] = '';
        if($this->getAmount() > 1) {
            $decorators['amount'] = '-# ' . $this->getAmount();
        }

        return $decorators;
    }

    /**
     *
     */
    public function validateArguments()
    {
        parent::validateArguments();
        if(!file_exists($this->filePath)) {
            throw new InvalidArgumentException('The given file is not valid for printing');
        }
    }
}