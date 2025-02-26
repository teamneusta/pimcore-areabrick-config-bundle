<?php

namespace Neusta\Pimcore\AreabrickConfigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('neusta_pimcore_areabrick_config');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('default_translation_domain')
                    ->defaultValue('messages')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
