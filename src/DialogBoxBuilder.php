<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\CheckboxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\DateItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\InputItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\LinkItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\NumericItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\RelationItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\SelectItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\SelectItemOptions;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\PanelItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\TabPanelItem;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxConfiguration;
use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DialogBoxBuilder
{
    private EditableDialogBoxConfiguration $config;
    private TabPanelItem $tabs;
    private PanelItem $content;

    public function __construct()
    {
        $this->config = new EditableDialogBoxConfiguration();
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
    public function addContent(EditableItem ...$items): static
    {
        if (isset($this->tabs)) {
            throw new \LogicException('You cannot add content and tabs at the same time.');
        }

        $this->content ??= new PanelItem('', []);
        $this->content->addItem(...$items);

        return $this;
    }

    /**
     * @return $this
     */
    public function addTab(string $title, EditableItem ...$items): static
    {
        if (isset($this->content)) {
            throw new \LogicException('You cannot add tabs and content at the same time.');
        }

        $this->tabs ??= new TabPanelItem();
        $this->tabs->getOrCreateTab($title)->addItem(...$items);

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
     * @param non-empty-array<array-key, string|TranslatableInterface> $store
     */
    public function createSelect(string $name, array $store): SelectItem
    {
        return new SelectItem($name, $store);
    }

    public function createNumeric(string $name, int $min, int $max): NumericItem
    {
        return new NumericItem($name, $min, $max);
    }

    public function createDate(string $name): DateItem
    {
        return new DateItem($name);
    }

    public function createLink(string $name): LinkItem
    {
        return new LinkItem($name);
    }

    public function build(?TranslatorInterface $translator = null): EditableDialogBoxConfiguration
    {
        $items = $this->content ?? $this->tabs ?? null;

        if ($items && !$items->isEmpty()) {
            $this->config->setItems($items->toArray($translator));
        }

        return $this->config;
    }
}
