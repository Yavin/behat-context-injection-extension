<?php

namespace Yavin\Test\Behat\Extension\ContextInjection;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;

class A implements SnippetAcceptingContext
{
    /**
     * @Then I can inject context as standalone argument
     */
    public function iCanInjectContextAsStandaloneArgument(B $contextB)
    {
        $contextB->requiredMethod();
    }

    /**
     * @Then I can inject context as first argument beside :model
     */
    public function iCanInjectContextAsFirstArgument(B $contextB, \stdClass $model)
    {
        $contextB->requiredMethod();
    }

    /**
     * @Then I can inject context as last argument beside :model
     */
    public function iCanInjectContextAsLastArgument(\stdClass $model, B $contextB)
    {
        $contextB->requiredMethod();
    }

    /**
     * @Then I can inject context as middle argument beside :model1 and :model2
     */
    public function iCanInjectContextAsMiddleArgument(\stdClass $model1, B $contextB, \stdClass $model2)
    {
        $contextB->requiredMethod();
    }

    /**
     * @Given I can inject context in table method as first argument:
     */
    public function iCanInjectContextInTableMethodAsFirstArgument(B $contextB, TableNode $table)
    {
        $contextB->requiredMethod();
    }

    /**
     * @Given I can inject context in table method as last argument:
     */
    public function iCanInjectContextInTableMethodAsLastArgument(TableNode $table, B $contextB)
    {
        $contextB->requiredMethod();
    }

    /**
     * @Transform :model
     * @Transform :model1
     * @Transform :model2
     */
    public function exampleTransformer()
    {
        return new \stdClass();
    }
}
