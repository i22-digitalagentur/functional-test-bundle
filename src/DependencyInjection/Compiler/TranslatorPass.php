<?php

namespace I22\FunctionalTestBundle\DependencyInjection\Compiler;

use I22\FunctionalTestBundle\Translation\FakeTranslator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Dennis Langen <dennis.langen@i22.de>
 */
class TranslatorPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $env = $container->getParameter("kernel.environment");
        if ('test' !== $env) {
            return;
        }

        $enable = $container->getParameter('i22_functional_test.use_fake_translator');

        if ($enable && $container->hasDefinition('translator.default')) {

            $definition = $container->getDefinition('translator.default');
            $definition = new Definition(FakeTranslator::class, $definition->getArguments());
            $container->removeDefinition('translator.default');
            $container->setDefinition('translator.default', $definition);
        }

    }
}
