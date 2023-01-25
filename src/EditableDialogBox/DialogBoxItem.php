<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox;

abstract class DialogBoxItem
{
    public const ITEM_CONFIG = 'config';
    public const ITEM_LABEL = 'label';
    public const ITEM_NAME = 'name';
    public const ITEM_TYPE = 'type';
    public const ITEM_DEFAULT_VALUE = 'defaultValue';

    public function __construct(
        private string $type,
    ) {
    }

    /**
     * @return array<int|string, mixed>
     */
    public function toArray(): array
    {
        return [static::ITEM_TYPE => $this->type] + $this->getAttributes();
    }

    /**
     * @return array<int|string, mixed>
     */
    abstract protected function getAttributes(): array;
}
