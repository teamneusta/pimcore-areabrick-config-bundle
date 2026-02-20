<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox;

class EditableItem extends DialogBoxItem
{
    private string $name;
    private string $label = '';
    private string $description = '';
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

    /**
     * @return $this
     */
    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return $this
     */
    public function addConfig(string $key, bool|float|int|string $value): static
    {
        $this->config[$key] = $value;

        return $this;
    }

    protected function getAttributes(): array
    {
        if ([] !== $deprecatedGetConfig = $this->getConfig()) {
            trigger_deprecation('teamneusta/pimcore-areabrick-config-bundle', '2.2.0', 'Overriding the method "%1$s::getConfig()" is deprecated, override "%1$s::defaultConfig()" instead.', self::class);
        }

        return array_filter([
            'name' => $this->name,
            'label' => $this->label,
            'description' => $this->description,
            'config' => array_merge($this->defaultConfig(), $this->config, $deprecatedGetConfig),
        ]);
    }

    /**
     * @deprecated since version 2.2.0, override "defaultConfig()" instead.
     *
     * @return array<string, mixed>
     */
    protected function getConfig(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
