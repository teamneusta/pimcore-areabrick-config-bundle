<?php

namespace Neusta\Pimcore\AreabrickConfigBundle\src\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('neusta_pimcore_areabrick_config');

        $treeBuilder->getRootNode()
            ->children()
                ->booleanNode('bricks')
                    ->defaultTrue()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
