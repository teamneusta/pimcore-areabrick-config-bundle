<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Neusta\ConverterBundle\NeustaConverterBundle;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Pimcore\HttpKernel\Bundle\DependentBundleInterface;
use Pimcore\HttpKernel\BundleCollection\BundleCollection;

final class NeustaPimcoreAreabrickConfigBundle extends AbstractPimcoreBundle implements DependentBundleInterface
{
    use PackageVersionTrait;

    public function getPath(): string
    {
        return __DIR__;
    }

    public static function registerDependentBundles(BundleCollection $collection): void
    {
        $collection->addBundle(NeustaConverterBundle::class);
    }
}
