<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Neusta\Pimcore\AreabrickConfigBundle\Installer;
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
        return 'Adds simple bricks for creating dialog boxes to editor configuration of areabricks.';
    }

    public function getJsPaths()
    {
        return [
            '/bundles/presentation/js/pimcore/startup.js',
        ];
    }

    public function getInstaller()
    {
        return new Installer();
    }

    protected function getComposerPackageName(): string
    {
        return 'teamneusta/pimcore-editorconfig-bundle';
    }
}
