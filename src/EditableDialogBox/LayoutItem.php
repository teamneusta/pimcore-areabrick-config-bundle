<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox;

use Symfony\Contracts\Translation\TranslatorInterface;

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
        return 0 === \count(array_filter($this->items, $this->isNotEmpty(...)));
    }

    /**
     * @return $this
     */
    protected function addItem(DialogBoxItem $item): static
    {
        $this->items[] = $item;

        return $this;
    }

    protected function getAttributes(TranslatorInterface $translator): array
    {
        return [
            'items' => array_map(
                static fn (DialogBoxItem $item): array => $item->toArray($translator),
                array_values(array_filter($this->items, $this->isNotEmpty(...))),
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
