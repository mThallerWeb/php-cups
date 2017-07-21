<?php namespace MThaller\PhpCups\Helpers\Traits;

trait ExtendedTraits
{

    /**
     * @param string $method
     * @param array $arguments
     * @param bool $reUseReturnAsFirstArgument
     *
     * @return mixed
     */
    protected function executeMethodOnTraits(string $method, array $arguments = [], $reUseReturnAsFirstArgument = false)
    {
        $traits = class_uses_recursive(static::class);

        if ($reUseReturnAsFirstArgument && count($arguments) == 0) {
            throw new \InvalidArgumentException('Can not reUseReturnAsFirstArgument option when no arguments given on startup');
        }

        $lastReturn = $reUseReturnAsFirstArgument ? array_first($arguments) : null;
        foreach ($traits as $trait) {
            $methodName = lcfirst(array_last(explode('\\', $trait))) . ucfirst($method);
            if (method_exists($this, $methodName)) {
                $lastReturn = call_user_func_array([$this, $methodName], $arguments);
                if ($reUseReturnAsFirstArgument) {
                    $arguments[array_first(array_keys($arguments))] = $lastReturn;
                }
            }
        }

        return $lastReturn;
    }
}