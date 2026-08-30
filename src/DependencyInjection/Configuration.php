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
                    ->info('Translation domain used for translatable dialog box labels/values when none is set explicitly. Dialog boxes are rendered in the Pimcore backend, so this defaults to the "admin" domain, consistent with the rest of this bundle.')
                    ->defaultValue('admin')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
