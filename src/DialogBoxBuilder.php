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
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\PanelItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\TabPanelItem;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxConfiguration;

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
        $this->getContent()->addEditable(...$items);

        return $this;
    }

    public function hasContent(): bool
    {
        return isset($this->content);
    }

    public function getContent(): PanelItem
    {
        if (isset($this->tabs)) {
            throw new \LogicException('You already have tabs and cannot have content at the same time.');
        }

        return $this->content ??= new PanelItem('');
    }

    /**
     * @deprecated since 3.1, use {@see self::addNamedTab()} instead.
     *             Without a stable name, tabs cannot be referenced reliably when the title is translated.
     *             Will become the default behavior (with a required name) in the next major version.
     *
     * @return $this
     */
    public function addTab(string $title, EditableItem ...$items): static
    {
        trigger_deprecation(
            'teamneusta/pimcore-areabrick-config-bundle',
            '3.1',
            'Method "%s()" without a stable name is deprecated, use "%s::addNamedTab()" instead.',
            __METHOD__,
            self::class,
        );

        return $this->addNamedTab($title, $title, ...$items);
    }

    /**
     * @return $this
     */
    public function addNamedTab(string $name, string $title, EditableItem ...$items): static
    {
        $tabs = $this->getTabs();

        if (!$tabs->hasTab($name)) {
            $tabs->addTab(new PanelItem($title, [], $name));
        }

        $tabs->getTab($name)->addEditable(...$items);

        return $this;
    }

    public function hasTab(string $name): bool
    {
        return $this->getTabs()->hasTab($name);
    }

    public function getTab(string $name): PanelItem
    {
        return $this->getTabs()->getTab($name);
    }

    public function getTabs(): TabPanelItem
    {
        if (isset($this->content)) {
            throw new \LogicException('You already have content and cannot have tabs at the same time.');
        }

        return $this->tabs ??= new TabPanelItem();
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

    public function createNumeric(string $name, int|float $min, int|float $max): NumericItem
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

    public function build(): EditableDialogBoxConfiguration
    {
        $items = $this->content ?? $this->tabs ?? null;

        if ($items && !$items->isEmpty()) {
            $this->config->setItems($items->toArray());
        }

        return $this->config;
    }
}
