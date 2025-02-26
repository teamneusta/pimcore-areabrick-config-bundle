<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\DependencyInjection;

use Neusta\Pimcore\AreabrickConfigBundle\Translation\TranslatorWithDefaultDomain;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class NeustaPimcoreAreabrickConfigExtension extends ConfigurableExtension
{
    public function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(\dirname(__DIR__, 2) . '/config'));
        $loader->load('services.yaml');

        $container->getDefinition(TranslatorWithDefaultDomain::class)
            ->replaceArgument('$defaultDomain', $mergedConfig['default_translation_domain']);
    }
}
