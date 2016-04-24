# Behat context injection extension

[![Build Status](https://travis-ci.org/Yavin/behat-context-injection-extension.svg?branch=master)](https://travis-ci.org/Yavin/behat-context-injection-extension)

With this extension you can inject contexts into methods. It should work with Behat 3.1+

```php
class MyContext implements Context
{
    /**
     * @Then I can inject context as argument
     */
    public function iCanInjectContextAsArgument(MyOtherContextClass $myOtherContext)
    {
        $myOtherContext->someMethod();
    }

    //...
}
```

## Instalation
1. With composer.json
   ```
   composer require yavin/behat-context-injection-extension:~1.0
   ```

2. Add extension to `behat.yml`
   ```yaml
   default:
       suites:
           example:
               paths: [ %paths.base%/my/features/path ]
               contexts:
                   - My\Context\Namespace\MyContext
                   - My\Context\Namespace\MyOtherContextClass
       extensions:
           Yavin\Behat\Extension\ContextInjection\ContextInjectionExtension: ~
   ```

example implementation in `/tests` directory
