<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;

class NeustaPimcoreAreabrickConfigBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    public function getNiceName()
    {
        return 'Neusta Editor Configuration Bundle';
    }

    public function getDescription()
    {
        return 'Object-oriented editable dialog box configuration building for areabricks';
    }

    public function getJsPaths()
    {
        return [
            '/bundles/presentation/js/pimcore/startup.js',
        ];
    }

    protected function getComposerPackageName(): string
    {
        return 'teamneusta/pimcore-areabrick-config-bundle';
    }
}
