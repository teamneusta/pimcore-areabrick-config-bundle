<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Pimcore\Extension\Document\Areabrick\EditableDialogBoxConfiguration;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;

/**
 * @template T of DialogBoxBuilder
 */
trait HasDialogBox
{
    final public function getEditableDialogBoxConfiguration(Editable $area, ?Info $info): EditableDialogBoxConfiguration
    {
        $builder = $this->createDialogBoxBuilder($area, $info);

        $this->buildDialogBox($builder, $area, $info);

        return $builder->build();
    }

    /**
     * @return T
     */
    private function createDialogBoxBuilder(Editable $area, ?Info $info): DialogBoxBuilder
    {
        return new DialogBoxBuilder();
    }

    /**
     * @param T $dialogBox
     */
    abstract private function buildDialogBox(DialogBoxBuilder $dialogBox, Editable $area, ?Info $info): void;
}
