<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class SelectItem extends EditableItem
{
    /** @var list<array{array-key, string}> */
    private array $store;

    /**
     * @param non-empty-array<array-key, string> $store
     */
    public function __construct(string $name, array $store)
    {
        parent::__construct('select', $name);
        $this->store = self::pack($store);
        $this->setDefaultValue(array_key_first($store));
    }

    /**
     * @return $this
     */
    public function setDefaultValue(int|string $value): static
    {
        return $this->addConfig('defaultValue', $value);
    }

    /**
     * @return $this
     */
    public function setWidth(int $width): static
    {
        return $this->addConfig('width', $width);
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
            'store' => $this->store,
        ];
    }
}
