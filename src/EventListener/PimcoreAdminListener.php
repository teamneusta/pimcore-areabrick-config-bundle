<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EventListener;

use Pimcore\Event\BundleManager\PathsEvent;

final class PimcoreAdminListener
{
    public function addCSSFiles(PathsEvent $event): void
    {
        $event->addPaths([
            '/bundles/neustapimcoreareabrickconfig/css/admin-style.css',
        ]);
    }

    public function addJSFiles(PathsEvent $event): void
    {
        $event->addPaths([
            '/bundles/neustapimcoreareabrickconfig/js/startup.js',
            '/bundles/neustapimcoreareabrickconfig/js/areabrick-overview.js',
            '/bundles/neustapimcoreareabrickconfig/js/areabrick-overview-unpublished-toggle.js',
        ]);
    }
}
