<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\DialogBoxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

/**
 * @extends LayoutItem<DialogBoxItem>
 *
 * @implements \IteratorAggregate<int, EditableItem>
 */
class PanelItem extends LayoutItem implements \IteratorAggregate
{
    public readonly string $title;

    /** @var array<string, EditableItem> */
    private array $items;

    /**
     * @param list<EditableItem> $items
     */
    public function __construct(string $title, array $items = [])
    {
        parent::__construct('panel', $items);
        $this->title = $title;

        foreach ($items as $item) {
            $this->items[$item->name()] = $item;
        }
    }

    /**
     * @return $this
     */
    public function addEditable(EditableItem ...$items): static
    {
        foreach ($items as $item) {
            if (isset($this->items[$item->name()])) {
                throw new \InvalidArgumentException(\sprintf('Editable item with name "%s" already exists.', $item->name()));
            }

            $this->items[$item->name()] = $item;
            parent::addItem($item);
        }

        return $this;
    }

    public function hasEditable(string $name): bool
    {
        return isset($this->items[$name]);
    }

    public function getEditable(string $name): EditableItem
    {
        return $this->items[$name]
            ?? throw new \InvalidArgumentException(\sprintf('Editable item with name "%s" not found.', $name));
    }

    /**
     * @return $this
     */
    public function removeEditable(string $name): static
    {
        if (!$item = $this->items[$name] ?? null) {
            throw new \InvalidArgumentException(\sprintf('Editable item with name "%s" not found.', $name));
        }

        unset($this->items[$name]);

        return $this->removeItem($item);
    }

    /**
     * @return \ArrayIterator<int, EditableItem>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator(array_values($this->items));
    }

    protected function getAttributes(): array
    {
        return ['title' => $this->title] + parent::getAttributes();
    }
}
