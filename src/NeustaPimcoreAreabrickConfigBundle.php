<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;

final class NeustaPimcoreAreabrickConfigBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    public function getNiceName(): string
    {
        return 'Areabrick Configuration Bundle';
    }

    public function getPath(): string
    {
        return __DIR__;
    }
}
