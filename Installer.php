<?php declare(strict_types=1);

namespace Neusta\Pimcore\EditorConfigBundle;

use Pimcore\Extension\Bundle\Installer\AbstractInstaller;
use Pimcore\Model\Asset\Image\Thumbnail;
use Pimcore\Model\Document\DocType;

class Installer extends AbstractInstaller
{
    public function install(): void
    {
    }

    public function isInstalled(): bool
    {
        return true;
    }

    public function canBeInstalled(): bool
    {
        return !$this->isInstalled();
    }

    public function needsReloadAfterInstall(): bool
    {
        return true;
    }
}
