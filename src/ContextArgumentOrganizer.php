<?php

namespace Yavin\Behat\Extension\ContextInjection;

use Behat\Testwork\Argument\ArgumentOrganiser;
use ReflectionFunctionAbstract;

class ContextArgumentOrganizer implements ArgumentOrganiser
{
    /**
     * @var ArgumentOrganiser
     */
    private $baseArgumentOrganiser;

    public function __construct(ArgumentOrganiser $baseArgumentOrganiser)
    {
        $this->baseArgumentOrganiser = $baseArgumentOrganiser;
    }

    public function organiseArguments(ReflectionFunctionAbstract $function, array $arguments)
    {
        foreach ($function->getParameters() as $parameter) {
            $parameterClass = $parameter->getClass();
            if (is_null($parameterClass) || !$parameterClass->isSubclassOf('Behat\Behat\Context\Context')) {
                continue;
            }
            //it will be resolved by transformer
            $arguments[$parameter->getName()] = null;
        }

        return $this->baseArgumentOrganiser->organiseArguments($function, $arguments);
    }
}
