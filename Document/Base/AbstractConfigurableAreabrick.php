<?php
declare(strict_types=1);

namespace Neusta\Pimcore\EditorConfigBundle\Document\Base;

use Neusta\Pimcore\EditorConfigBundle\Document\EditableDialogBox\DialogBoxBuilder;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxInterface;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;

/**
 * @internal
 */
abstract class AbstractConfigurableAreabrick implements EditableDialogBoxInterface
{
    /** @template-use HasDialogBox<DialogBoxBuilder> */
    use HasDialogBox;

    protected function createDialogBoxBuilder(Editable $area, ?Info $info): DialogBoxBuilder
    {
        return new DialogBoxBuilder();
    }
}
