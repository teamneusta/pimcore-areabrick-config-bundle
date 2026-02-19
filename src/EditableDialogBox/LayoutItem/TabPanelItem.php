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
        $this->items = array_column($items, null, 'title');
    }

    /**
     * @deprecated since version 2.2.0, use `hasTab()` and `addTab()` instead.
     */
    public function getOrCreateTab(string $title): PanelItem
    {
        trigger_deprecation('teamneusta/pimcore-areabrick-config-bundle', '2.2.0', 'The method "%s()" is deprecated, use "%2$s::hasTab()" and "%2$s::addTab()" instead.', __METHOD__, static::class);

        if (!isset($this->items[$title])) {
            $this->addItem($this->items[$title] = new PanelItem($title));
        }

        return $this->items[$title];
    }

    /**
     * @return $this
     */
    public function addTab(PanelItem $item): static
    {
        if ($this->hasTab($item->title)) {
            throw new \InvalidArgumentException(\sprintf('Tab with title "%s" already exists.', $item->title));
        }

        $this->items[$item->title] = $item;

        return $this->addItem($item);
    }

    public function hasTab(string $title): bool
    {
        return isset($this->items[$title]);
    }

    public function getTab(string $title): PanelItem
    {
        return $this->items[$title]
            ?? throw new \InvalidArgumentException(\sprintf('Tab with title "%s" not found.', $title));
    }

    /**
     * @return $this
     */
    public function removeTab(string $title): static
    {
        if (!$item = $this->items[$title] ?? null) {
            throw new \InvalidArgumentException(\sprintf('Tab with title "%s" not found.', $title));
        }

        unset($this->items[$title]);

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
