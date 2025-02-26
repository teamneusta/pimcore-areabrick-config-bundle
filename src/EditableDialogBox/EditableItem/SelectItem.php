<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Symfony\Contracts\Translation\TranslatableInterface;

class SelectItem extends EditableItem
{
    /** @var list<array{array-key, string|TranslatableInterface}> */
    private array $store;

    /**
     * @param non-empty-array<array-key, string|TranslatableInterface> $store
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
     * @param array<array-key, string|TranslatableInterface> $data
     *
     * @return list<array{array-key, string|TranslatableInterface}>
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
