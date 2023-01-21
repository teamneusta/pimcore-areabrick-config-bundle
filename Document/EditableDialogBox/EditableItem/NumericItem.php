<?php
declare(strict_types=1);

namespace Neusta\Pimcore\EditorConfigBundle\Document\EditableDialogBox\EditableItem;

use Neusta\Pimcore\EditorConfigBundle\Document\EditableDialogBox\EditableItem;

class NumericItem extends EditableItem
{
    private int $min;
    private int $max;

    public function __construct(string $name, int $min, int $max)
    {
        parent::__construct('numeric', $name);
        $this->setDefaultValue($this->min);
        $this->min = $min;
        $this->max = $max;
    }

    public function setDefaultValue(int $value): static
    {
        if ($value >= $this->min && $value <= $this->max) {
            return $this->addConfig('defaultValue', $value);
        }
        return $this;
    }

    /**
     * @param array<array-key, string> $data
     *
     * @return list<array{array-key, string}>
     */
    protected static function pack(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $result[] = [$key, $value];
        }

        return $result;
    }

    protected function getConfig(): array
    {
        return [
            'minValue' => $this->min,
            'maxValue' => $this->max,
        ];
    }
}
