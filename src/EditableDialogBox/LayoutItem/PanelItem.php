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
     * @param list<DialogBoxItem> $items
     */
    public function __construct(string $title, array $items = [])
    {
        parent::__construct('panel', $items);
        $this->title = $title;

        $deprecationTriggered = false;
        foreach ($items as $item) {
            if ($item instanceof EditableItem) {
                $this->items[$item->name()] = $item;
            } elseif (!$deprecationTriggered) {
                trigger_deprecation('teamneusta/pimcore-areabrick-config-bundle', '2.2.0', 'Not passing only "%s" to %s() is deprecated.', EditableItem::class, __METHOD__);
                $deprecationTriggered = true;
            }
        }
    }

    /**
     * @deprecated since version 2.2.0, use `addEditable()` instead.
     */
    public function addItem(DialogBoxItem ...$items): static
    {
        trigger_deprecation('teamneusta/pimcore-areabrick-config-bundle', '2.2.0', 'The method "%s()" is deprecated, use "%s::addEditable()" instead.', __METHOD__, static::class);

        foreach ($items as $item) {
            parent::addItem($item);

            if ($item instanceof EditableItem) {
                $this->items[$item->name()] = $item;
            }
        }

        return $this;
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
