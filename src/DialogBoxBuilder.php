<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\CheckboxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\InputItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\NumericItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\RelationItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\SelectItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\PanelItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\TabPanelItem;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxConfiguration;

class DialogBoxBuilder
{
    private EditableDialogBoxConfiguration $config;
    private TabPanelItem $tabs;

    public function __construct()
    {
        $this->config = new EditableDialogBoxConfiguration();
        $this->tabs = new TabPanelItem();
    }

    /**
     * @return $this
     */
    public function reloadOnClose(bool $reload = true): static
    {
        $this->config->setReloadOnClose($reload);

        return $this;
    }

    /**
     * @return $this
     */
    public function width(int $width): static
    {
        $this->config->setWidth($width);

        return $this;
    }

    /**
     * @return $this
     */
    public function height(int $height): static
    {
        $this->config->setHeight($height);

        return $this;
    }

    /**
     * @return $this
     */
    public function addTab(string $title, EditableItem ...$items): static
    {
        $this->tabs->addTab(new PanelItem($title, array_values($items)));

        return $this;
    }

    public function createCheckbox(string $name): CheckboxItem
    {
        return new CheckboxItem($name);
    }

    public function createInput(string $name): InputItem
    {
        return new InputItem($name);
    }

    public function createRelation(string $name): RelationItem
    {
        return new RelationItem($name);
    }

    /**
     * @param non-empty-array<array-key, string> $store
     */
    public function createSelect(string $name, array $store): SelectItem
    {
        return new SelectItem($name, $store);
    }

    public function createNumeric(string $name, int $min, int $max): NumericItem
    {
        return new NumericItem($name, $min, $max);
    }

    public function build(): EditableDialogBoxConfiguration
    {
        if (!$this->tabs->isEmpty()) {
            $this->config->setItems($this->tabs->toArray());
        }

        return $this->config;
    }
}
