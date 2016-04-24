<?php

namespace Yavin\Behat\Extension\ContextInjection;

use Behat\Testwork\Argument\ServiceContainer\ArgumentExtension;
use Behat\Testwork\Call\ServiceContainer\CallExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class ContextInjectionExtension implements Extension
{
    const CONTEXT_ARGUMENT_ORGANIZER = 'behat_context_injection_extension.argument_organizer';

    const CONTEXT_ARGUMENT_TRANSFORMER = 'behat_context_injection_extension.argument_transformer';

    const CONTEXT_ARGUMENT_RESOLVER = 'behat_context_injection_extension.argument_resolver';

    public function getConfigKey()
    {
        return 'app_extension';
    }

    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/config'));
        $loader->load('services.xml');

        $this->addArgumentOrganizer($container);
        $this->addArgumentTransformer($container);
    }

    public function process(ContainerBuilder $container)
    {
    }

    public function initialize(ExtensionManager $extensionManager)
    {
    }

    public function configure(ArrayNodeDefinition $builder)
    {
    }

    private function addArgumentOrganizer(ContainerBuilder $container)
    {
        $pregArgumentOrganizer = $container->getDefinition(ArgumentExtension::PREG_MATCH_ARGUMENT_ORGANISER_ID);

        //replace
        $container->getDefinition(self::CONTEXT_ARGUMENT_ORGANIZER)
            ->replaceArgument(0, $pregArgumentOrganizer->getArgument(0));

        $pregArgumentOrganizer->replaceArgument(0, new Reference(self::CONTEXT_ARGUMENT_ORGANIZER));
    }

    private function addArgumentTransformer(ContainerBuilder $container)
    {
        $argumentTransformerDefinition = $container
            ->getDefinition(CallExtension::CALL_FILTER_TAG . '.definition_argument_transformer');
        $calls = $argumentTransformerDefinition->getMethodCalls();
        array_unshift($calls, ['registerArgumentTransformer', [new Reference(self::CONTEXT_ARGUMENT_TRANSFORMER)]]);
        $argumentTransformerDefinition->setMethodCalls($calls);
    }
}
