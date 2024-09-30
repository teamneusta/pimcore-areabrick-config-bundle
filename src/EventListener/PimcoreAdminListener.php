<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EventListener;

use Pimcore\Event\BundleManager\PathsEvent;

class PimcoreAdminListener
{
    public function addCSSFiles(PathsEvent $event): void
    {
        $event->addPaths([
            '/bundles/neustapimcoreareabrickconfig/css/admin-gui-style.css',
        ]);
    }

    public function addJSFiles(PathsEvent $event): void
    {
        $event->addPaths([
            '/bundles/neustapimcoreareabrickconfig/js/areabricksOverviewMenuItem.js',
            '/bundles/neustapimcoreareabrickconfig/js/areabricksOverviewTabPanel.js',
        ]);
    }
}
