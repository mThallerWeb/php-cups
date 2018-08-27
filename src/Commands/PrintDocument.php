<?php namespace MThaller\PhpCups\Commands;

use MThaller\PhpCups\Abstracts\Command;
use MThaller\PhpCups\Commands\Traits\UsesPrinter;
use MThaller\PhpCups\Exceptions\InvalidArgumentException;
use MThaller\PhpCups\Responses\PrinterList;

class PrintDocument extends Command {

    use UsesPrinter;
    /**
     * @var string
     */
    protected $command = 'lpr -P {##printerName##} {##options##} {##amount##} {##filePath##}';

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var int
     */
    protected $amount = 1;

    /**
     * @var array
     */
    protected $options = [];

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
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
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

        if (!empty($this->getOptions())) {
            $options = [];

            foreach ($this->getOptions() as $option) {
                $options[] = "-o {$option}";
            }

            $decorators['options'] = implode(' ', $options);
        } else {
            $decorators['options'] = '';
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