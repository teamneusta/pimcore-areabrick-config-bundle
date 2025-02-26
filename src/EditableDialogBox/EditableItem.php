<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class EditableItem extends DialogBoxItem
{
    private string $name;
    private string|TranslatableInterface $label = '';
    /** @var array<string, bool|float|int|string|TranslatableInterface> */
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
    public function setLabel(string|TranslatableInterface $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return $this
     */
    public function addConfig(string $key, bool|float|int|string|TranslatableInterface $value): static
    {
        $this->config[$key] = $value;

        return $this;
    }

    final protected function getAttributes(?TranslatorInterface $translator): array
    {
        $label = $this->label;
        $config = array_merge($this->config, $this->getConfig());

        if ($translator) {
            if ($label instanceof TranslatableInterface) {
                $label = $label->trans($translator);
            }

            array_walk_recursive($config, function (&$value) use ($translator) {
                if ($value instanceof TranslatableInterface) {
                    $value = $value->trans($translator);
                }
            });
        }

        return array_filter([
            'name' => $this->name,
            'label' => $label,
            'config' => $config,
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
