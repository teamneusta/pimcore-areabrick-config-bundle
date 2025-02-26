<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox;

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
    public function toArray(?TranslatorInterface $translator): array
    {
        return ['type' => $this->type] + $this->getAttributes($translator);
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function getAttributes(?TranslatorInterface $translator): array;
}
