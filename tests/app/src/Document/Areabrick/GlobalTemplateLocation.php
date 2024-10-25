<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\app\src\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractAreabrick;

final class GlobalTemplateLocation extends AbstractAreabrick
{
    public function getTemplate(): ?string
    {
        return null;
    }

    public function getTemplateLocation(): string
    {
        return self::TEMPLATE_LOCATION_GLOBAL;
    }

    public function getTemplateSuffix(): string
    {
        return self::TEMPLATE_SUFFIX_TWIG;
    }
}
