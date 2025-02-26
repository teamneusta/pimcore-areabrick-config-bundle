<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Symfony\Contracts\Translation\TranslatableInterface;

class InputItem extends EditableItem
{
    public function __construct(string $name)
    {
        parent::__construct('input', $name);
    }

    /**
     * @return $this
     */
    public function setDefaultValue(string|TranslatableInterface $value): static
    {
        return $this->addConfig('defaultValue', $value);
    }

    /**
     * @return $this
     */
    public function setPlaceholder(string|TranslatableInterface $value): static
    {
        return $this->addConfig('placeholder', $value);
    }
}
