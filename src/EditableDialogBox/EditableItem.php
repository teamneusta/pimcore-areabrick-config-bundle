<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox;

class EditableItem extends DialogBoxItem
{
    private string $name;
    private string $label = '';
    /** @var array<string, bool|float|int|string> */
    private array $config = [];

    public function __construct(string $type, string $name)
    {
        parent::__construct($type);
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function addConfig(string $key, bool|float|int|string $value): static
    {
        $this->config[$key] = $value;

        return $this;
    }

    protected function getAttributes(): array
    {
        return array_filter([
            static::ITEM_NAME => $this->name,
            static::ITEM_LABEL => $this->label,
            static::ITEM_CONFIG => array_merge($this->config, $this->getConfig()),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function getConfig(): array
    {
        return [];
    }
}
