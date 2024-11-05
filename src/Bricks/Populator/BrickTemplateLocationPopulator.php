<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Populator;

use Neusta\ConverterBundle\Converter\Context\GenericContext;
use Neusta\ConverterBundle\Populator;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Brick;
use Pimcore\Document\Editable\EditableHandler;
use Pimcore\Extension\Document\Areabrick\AbstractAreabrick;

/**
 * @implements Populator<AbstractAreabrick, Brick, GenericContext>
 */
final class BrickTemplateLocationPopulator implements Populator
{
    private readonly \Closure $resolveTemplate;

    public function __construct(EditableHandler $editableHandler)
    {
        $this->resolveTemplate = (new \ReflectionMethod($editableHandler, 'resolveBrickTemplate'))->getClosure($editableHandler);
    }

    public function populate(object $target, object $source, ?object $ctx = null): void
    {
        // Todo: remove the second parameter when Pimcore 10 support is dropped
        $target->template = ($this->resolveTemplate)($source, 'view');
    }
}
