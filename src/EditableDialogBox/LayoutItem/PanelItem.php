<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\DialogBoxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

/**
 * @extends LayoutItem<DialogBoxItem>
 */
class PanelItem extends LayoutItem
{
    public readonly string $title;

    /** @var array<string, EditableItem> */
    private array $editableItems;

    /**
     * @param list<DialogBoxItem> $items
     */
    public function __construct(string $title, array $items = [])
    {
        parent::__construct('panel', []);
        $this->title = $title;
        $this->addItem(...$items);
    }

    public function addItem(DialogBoxItem ...$items): static
    {
        foreach ($items as $item) {
            parent::addItem($item);

            if ($item instanceof EditableItem) {
                $this->editableItems[$item->name()] = $item;
            }
        }

        return $this;
    }

    public function getEditableItem(string $name): EditableItem
    {
        return $this->editableItems[$name]
            ?? throw new \InvalidArgumentException(\sprintf('Editable item with name "%s" not found.', $name));
    }

    public function removeEditableItem(string $name): static
    {
        if (!$item = $this->editableItems[$name] ?? null) {
            throw new \InvalidArgumentException(\sprintf('Editable item with name "%s" not found.', $name));
        }

        unset($this->editableItems[$name]);

        return $this->removeItem($item);
    }

    protected function getAttributes(): array
    {
        return ['title' => $this->title] + parent::getAttributes();
    }
}
