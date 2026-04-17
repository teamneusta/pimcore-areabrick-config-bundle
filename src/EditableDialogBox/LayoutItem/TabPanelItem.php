<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

/**
 * @extends LayoutItem<PanelItem>
 *
 * @implements \IteratorAggregate<int, PanelItem>
 */
class TabPanelItem extends LayoutItem implements \IteratorAggregate
{
    /** @var array<string, PanelItem> */
    private array $items;

    /**
     * @param list<PanelItem> $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct('tabpanel', $items);
        $this->items = array_column($items, null, 'name');
    }

    /**
     * @return $this
     */
    public function addTab(PanelItem $item): static
    {
        if ($this->hasTab($item->name)) {
            throw new \InvalidArgumentException(\sprintf('A tab named "%s" already exists.', $item->name));
        }

        $this->items[$item->name] = $item;

        return $this->addItem($item);
    }

    public function hasTab(string $name): bool
    {
        return isset($this->items[$name]);
    }

    public function getTab(string $name): PanelItem
    {
        return $this->items[$name]
            ?? throw new \InvalidArgumentException(\sprintf('A tab named "%s" was not found.', $name));
    }

    /**
     * @return $this
     */
    public function removeTab(string $name): static
    {
        if (!$item = $this->items[$name] ?? null) {
            throw new \InvalidArgumentException(\sprintf('A tab named "%s" was not found.', $name));
        }

        unset($this->items[$name]);

        return $this->removeItem($item);
    }

    /**
     * @return \ArrayIterator<int, PanelItem>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator(array_values($this->items));
    }
}
