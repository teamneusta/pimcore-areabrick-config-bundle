<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class DialogBoxItem
{
    public function __construct(
        private readonly string $type,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    final public function toArray(TranslatorInterface $translator): array
    {
        $config = ['type' => $this->type] + $this->getAttributes($translator);

        array_walk_recursive($config, function (&$value) use ($translator) {
            if ($value instanceof TranslatableInterface) {
                $value = $value->trans($translator);
            }
        });

        return $config;
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function getAttributes(TranslatorInterface $translator): array;
}
