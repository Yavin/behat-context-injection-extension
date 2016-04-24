<?php

namespace Yavin\Behat\Extension\ContextInjection;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Definition\Call\DefinitionCall;
use Behat\Behat\Transformation\Transformer\ArgumentTransformer as BehatArgumentTransformer;

class ContextArgumentTransformer implements BehatArgumentTransformer
{
    public function supportsDefinitionAndArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue)
    {
        if (!$definitionCall->getEnvironment() instanceof InitializedContextEnvironment) {
            return false;
        }

        $parameter = $this->getParameter($definitionCall->getCallee()->getReflection(), $argumentIndex);
        if (is_null($parameter)) {
            return false;
        }

        $class = $parameter->getClass();
        if (is_null($class) || !$class->isSubclassOf('Behat\Behat\Context\Context')) {
            return false;
        }

        return true;
    }

    public function transformArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue)
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $definitionCall->getEnvironment();

        $class = $this->getParameter($definitionCall->getCallee()->getReflection(), $argumentIndex)->getClass();
        foreach ($environment->getContexts() as $context) {
            if ($class->isInstance($context)) {
                return $context;
            }
        }

        return $argumentValue;
    }

    private function getParameter(\ReflectionFunctionAbstract $reflectionFunction, $name)
    {
        foreach ($reflectionFunction->getParameters() as $parameter) {
            if ($parameter->getName() === $name) {
                return $parameter;
            }
        }
    }
}
