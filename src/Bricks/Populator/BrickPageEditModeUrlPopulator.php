<?php

declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Populator;

use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\ConverterBundle\Populator;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Page;
use Pimcore\Model\Document\Page as PimcorePage;

/**
 * @implements Populator<PimcorePage, Page, GenericContext|null>
 */
final class BrickPageEditModeUrlPopulator implements Populator
{
    public function populate(object $target, object $source, ?object $ctx = null): void
    {
        $target->editModeUrl = \sprintf('/admin/login/deeplink?document_%s_page', $source->getId());
    }
}
