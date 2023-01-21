<?php

namespace Neusta\Pimcore\EditorConfigBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;

class NeustaPimcoreEditorConfigBundle extends AbstractPimcoreBundle
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
        return 'neusta/pimcore-editorconfig-bundle';
    }
}
