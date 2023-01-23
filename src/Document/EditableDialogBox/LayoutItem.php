<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Document\EditableDialogBox;

abstract class LayoutItem extends DialogBoxItem
{
    /**
     * @param list<DialogBoxItem> $items
     */
    public function __construct(
        string $type,
        private array $items,
    ) {
        parent::__construct($type);
    }

    public function isEmpty(): bool
    {
        return 0 === \count(array_filter($this->items, [$this, 'isNotEmpty']));
    }

    protected function addItem(DialogBoxItem $item): static
    {
        $this->items[] = $item;

        return $this;
    }

    protected function getAttributes(): array
    {
        return [
            'items' => array_map(
                static fn (DialogBoxItem $item): array => $item->toArray(),
                array_values(array_filter($this->items, [$this, 'isNotEmpty'])),
            ),
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
