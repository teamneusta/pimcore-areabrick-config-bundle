<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox;

/**
 * @template TItem of DialogBoxItem
 */
abstract class LayoutItem extends DialogBoxItem
{
    /** @var array<int, TItem> */
    private array $items = [];

    /**
     * @param list<TItem> $items
     */
    public function __construct(string $type, array $items)
    {
        parent::__construct($type);

        foreach ($items as $item) {
            $this->items[spl_object_id($item)] = $item;
        }
    }

    public function isEmpty(): bool
    {
        foreach ($this->items as $item) {
            if ($this->isNotEmpty($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param TItem $item
     *
     * @return $this
     */
    protected function addItem(DialogBoxItem $item): static
    {
        $this->items[spl_object_id($item)] = $item;

        return $this;
    }

    protected function getAttributes(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            if ($this->isNotEmpty($item)) {
                $items[] = $item->toArray();
            }
        }

        return [
            'items' => $items,
        ];
    }

    private function isNotEmpty(DialogBoxItem $item): bool
    {
        if ($item instanceof self) {
            return !$item->isEmpty();
        }

        return true;
    }
}
