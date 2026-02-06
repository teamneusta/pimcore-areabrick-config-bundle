<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

/**
 * @extends LayoutItem<PanelItem>
 */
class TabPanelItem extends LayoutItem
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

    public function getOrCreateTab(string $title): PanelItem
    {
        if (!isset($this->items[$title])) {
            $this->addItem($this->items[$title] = new PanelItem($title));
        }

        return $this->items[$title];
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

    public function removeTab(string $title): static
    {
        if (!$item = $this->items[$title] ?? null) {
            throw new \InvalidArgumentException(\sprintf('Tab with title "%s" not found.', $title));
        }

        unset($this->items[$title]);

        return $this->removeItem($item);
    }
}
