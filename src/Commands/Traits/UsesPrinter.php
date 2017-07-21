<?php namespace MThaller\PhpCups\Commands\Traits;

use MThaller\PhpCups\Exceptions\PrinterNotDefinedException;

trait UsesPrinter
{

    /**
     * @var string
     */
    protected $printer = '';

    /**
     * @return string
     */
    public function getPrinter(): string
    {
        return $this->printer;
    }

    /**
     * @param string $printer
     */
    public function setPrinter(string $printer)
    {
        $this->printer = $printer;
    }

    /**
     *
     */
    public function usesPrinterValidateArguments()
    {
        if (!$this->printer) {
            throw new PrinterNotDefinedException();
        }
    }

    /**
     * @param array $decorators
     *
     * @return array
     */
    public function usesPrinterGetCommandDecorators(array $decorators): array
    {
        $decorators['printerName'] = $this->getPrinter();

        return $decorators;
    }
}