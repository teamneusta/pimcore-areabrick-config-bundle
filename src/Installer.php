<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\src;

use Pimcore\Extension\Bundle\Installer\AbstractInstaller;

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
