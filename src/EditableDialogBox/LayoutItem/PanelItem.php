<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\DialogBoxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;
use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @extends LayoutItem<DialogBoxItem>
 */
class PanelItem extends LayoutItem
{
    public readonly string|TranslatableInterface $title;

    /**
     * @param list<DialogBoxItem> $items
     */
    public function __construct(string|TranslatableInterface $title, array $items = [])
    {
        parent::__construct('panel', $items);
        $this->title = $title;
    }

    public function addItem(DialogBoxItem ...$items): static
    {
        foreach ($items as $item) {
            parent::addItem($item);
        }

        return $this;
    }

    protected function getAttributes(TranslatorInterface $translator): array
    {
        $title = $this->title instanceof TranslatableInterface
            ? $this->title->trans($translator)
            : $this->title;

        return ['title' => $title] + parent::getAttributes($translator);
    }
}
