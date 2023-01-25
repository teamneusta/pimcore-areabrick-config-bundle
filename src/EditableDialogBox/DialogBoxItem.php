<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox;

abstract class DialogBoxItem
{
    public function __construct(
        private string $type,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return ['type' => $this->type] + $this->getAttributes();
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function getAttributes(): array;
}
