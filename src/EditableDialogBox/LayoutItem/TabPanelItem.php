<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Contracts\Translation\TranslatableInterface;

/**
 * @extends LayoutItem<PanelItem>
 */
class TabPanelItem extends LayoutItem
{
    private readonly IdentityTranslator $translator;

    /** @var array<string, PanelItem> */
    private array $items;

    /**
     * @param list<PanelItem> $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct('tabpanel', $items);

        $this->translator = new IdentityTranslator();

        foreach ($items as $item) {
            $this->items[$this->toString($item->title)] = $item;
        }
    }

    public function getOrCreateTab(string|TranslatableInterface $title): PanelItem
    {
        $key = $this->toString($title);

        if (!isset($this->items[$key])) {
            $this->addItem($this->items[$key] = new PanelItem($title));
        }

        return $this->items[$key];
    }

    private function toString(string|TranslatableInterface $text): string
    {
        if ($text instanceof TranslatableInterface) {
            return $text->trans($this->translator);
        }

        return $text;
    }
}
