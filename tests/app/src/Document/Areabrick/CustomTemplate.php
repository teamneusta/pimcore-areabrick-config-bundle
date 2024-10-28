<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\app\src\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractAreabrick;

final class CustomTemplate extends AbstractAreabrick
{
    public function getTemplate(): ?string
    {
        return 'custom-template-areabrick/index.html.twig';
    }

    public function getTemplateLocation(): string
    {
        return '';
    }

    public function getTemplateSuffix(): string
    {
        return '';
    }
}
