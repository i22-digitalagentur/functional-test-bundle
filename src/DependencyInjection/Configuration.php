<?php

namespace I22\FunctionalTestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Dennis Langen <dennis.langen@i22.de>
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('i22_functional_test');

        $rootNode
            ->children()
                ->booleanNode('disable_csrf_form_protection')
                    ->defaultTrue()
                    ->info('Disabling the auto configuration of forms with csrf protection.')
                ->end()
                ->booleanNode('use_fake_translator')
                    ->defaultTrue()
                    ->info('Replacing translator.default with a fake translator that outputs the translation key instead of translation message')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}