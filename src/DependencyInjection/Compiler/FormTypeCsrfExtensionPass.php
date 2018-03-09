<?php

namespace I22\FunctionalTestBundle\DependencyInjection\Compiler;

use I22\FunctionalTestBundle\Form\Extension\FormTypeCsrfExtension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;


/**
 * @author Dennis Langen <dennis.langen@i22.de>
 */
class FormTypeCsrfExtensionPass implements CompilerPassInterface
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

        $disable = $container->getParameter('i22_functional_test.disable_csrf_form_protection');

        if ($disable && $container->hasDefinition('form.type_extension.csrf')) {

            $container->removeDefinition('form.type_extension.csrf');

            $definition = new Definition(FormTypeCsrfExtension::class);
            $container->setDefinition('form.type_extension.csrf', $definition);
        }

    }
}
