<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Neusta\ConverterBundle\NeustaConverterBundle;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\PimcoreBundleAdminClassicInterface;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Pimcore\HttpKernel\Bundle\DependentBundleInterface;
use Pimcore\HttpKernel\BundleCollection\BundleCollection;

final class NeustaPimcoreAreabrickConfigBundle extends AbstractPimcoreBundle implements DependentBundleInterface, PimcoreBundleAdminClassicInterface
{
    use PackageVersionTrait;

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public static function registerDependentBundles(BundleCollection $collection): void
    {
        $collection->addBundle(NeustaConverterBundle::class);
    }

    public function getJsPaths(): array
    {
        return [
            '/bundles/pimcoreareabrickconfig/js/areabricksOverview.js',
        ];
    }

    public function getCssPaths(): array
    {
        return [];
    }

    public function getEditmodeJsPaths(): array
    {
        return [];
    }

    public function getEditmodeCssPaths(): array
    {
        return [];
    }
}
