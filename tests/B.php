<?php

namespace Yavin\Test\Behat\Extension\ContextInjection;

use Behat\Behat\Context\Context;

class B implements Context
{
    public function requiredMethod()
    {
        return 'some result';
    }
}
