<?php
declare(strict_types=1);

namespace Neusta\Pimcore\EditorConfigBundle\Document\EditableDialogBox;

/**
 * @internal
 */
final class BundleDialogBoxBuilder extends DialogBoxBuilder
{
    public function addDefaultExtrasTab(EditableItem ...$items): self
    {
        return $this->addExtrasTab(
            $this->createInput('modifier')->setLabel('Klasse (global)'),
            ...$items,
        );
    }
}
