<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EventListener;

use Pimcore\Event\BundleManager\PathsEvent;

class PimcoreAdminListener
{
    public function addCSSFiles(PathsEvent $event): void
    {
        $event->addPaths([
            '/public/css/admin-gui-style.css',
        ]);
    }

    public function addJSFiles(PathsEvent $event): void
    {
        $event->addPaths([
            '/public/js/startup.js',
        ]);
    }
}
