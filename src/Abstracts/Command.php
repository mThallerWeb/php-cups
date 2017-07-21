<?php namespace MThallerWeb\PhpCups\Abstracts;

use MThallerWeb\PhpCups\Exceptions\CommandNotDefinedException;
use MThallerWeb\PhpCups\Helpers\Traits\ExtendedTraits;
use MThallerWeb\PhpCups\Responses\Error;
use MThallerWeb\PhpCups\Responses\StdResponse;
use Symfony\Component\Process\Process;

abstract class Command
{
    use ExtendedTraits;

    /**
     * @var null
     */
    protected $command = '';

    /**
     * @var string
     */
    protected $okResponseClass = StdResponse::class;

    /**
     * @var string
     */
    protected $errorResponseClass = Error::class;

    /**
     * CommandAbstract constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return Process
     *
     * @throws CommandNotDefinedException
     */
    protected function createProcess(): Process
    {
        $command = $this->getCommand();
        if ($command === '' || !$command) {
            throw new CommandNotDefinedException();
        }

        return new Process($this->getDecoratedCommand());
    }

    protected function validateArguments()
    {
        $this->executeMethodOnTraits('validateArguments');
    }

    /**
     * @return CommandResponse
     */
    public function fire(): CommandResponse
    {
        $this->validateArguments();
        $process = $this->createProcess();
        $process->run();

        if ($process->isSuccessful()) {
            return (new $this->okResponseClass($process->getOutput()));
        } else {
            return (new $this->errorResponseClass($process->getErrorOutput()));
        }
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return string
     */
    protected function getDecoratedCommand(): string
    {
        $command = $this->getCommand();
        $commandDecorators = $this->getCommandDecorators();
        foreach ($commandDecorators as $decoratorName => $decoratorValue) {
            $command = str_replace('{##' . $decoratorName . '##}', $decoratorValue, $command);
        }

        return $command;
    }

    /**
     * @return array
     */
    protected function getCommandDecorators(): array
    {
        $decorators = $this->executeMethodOnTraits('getCommandDecorators', [[]], true);

        return $decorators;
    }
}