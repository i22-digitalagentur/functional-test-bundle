<?php

namespace I22\FunctionalTestBundle;

use I22\FunctionalTestBundle\DependencyInjection\Compiler\FormTypeCsrfExtensionPass;
use I22\FunctionalTestBundle\DependencyInjection\Compiler\TranslatorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Dennis Langen <dennis.langen@i22.de>
 */
class I22FunctionalTestBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FormTypeCsrfExtensionPass());
        $container->addCompilerPass(new TranslatorPass());
    }
}