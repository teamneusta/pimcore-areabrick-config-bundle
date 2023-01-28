<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class CheckboxItem extends EditableItem
{
    public function __construct(string $name)
    {
        parent::__construct('checkbox', $name);
    }

    /**
     * @return $this
     */
    public function setDefaultChecked(): static
    {
        return $this->addConfig('defaultValue', true);
    }

    /**
     * @return $this
     */
    public function setDefaultUnchecked(): static
    {
        return $this->addConfig('defaultValue', false);
    }
}
