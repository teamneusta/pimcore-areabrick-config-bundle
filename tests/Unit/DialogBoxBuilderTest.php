<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit;

use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxBuilder;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\PanelItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\TabPanelItem;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

class DialogBoxBuilderTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function addingContent(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);
        $dialogBuilder = new DialogBoxBuilder($translator->reveal());
        $editableItem1 = new EditableItem('type1', 'name1');
        $editableItem2 = new EditableItem('type2', 'name2');
        $editableItem3 = new EditableItem('type3', 'name3');

        $expected = new PanelItem('', [$editableItem1, $editableItem2, $editableItem3]);

        $dialogBox = $dialogBuilder
            ->addContent($editableItem1, $editableItem2)
            ->addContent($editableItem3)
            ->build();

        self::assertSame($expected->toArray(), $dialogBox->getItems());
    }

    /**
     * @test
     */
    public function addingTwoTabsWithSomeItems(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);
        $dialogBuilder = new DialogBoxBuilder($translator->reveal());
        $editableItem1 = new EditableItem('type1', 'name1');
        $editableItem2 = new EditableItem('type2', 'name2');
        $editableItem3 = new EditableItem('type3', 'name3');

        $expected = new TabPanelItem();
        $expected->getOrCreateTab('Settings')->addItem($editableItem1, $editableItem2);
        $expected->getOrCreateTab('Other')->addItem($editableItem3);

        $dialogBox = $dialogBuilder
            ->addTab('Settings', $editableItem1, $editableItem2)
            ->addTab('Other', $editableItem3)
            ->build();

        self::assertSame($expected->toArray(), $dialogBox->getItems());
    }

    /**
     * @test
     */
    public function addingItemsToExistingTab(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);
        $dialogBuilder = new DialogBoxBuilder($translator->reveal());
        $editableItem1 = new EditableItem('type1', 'name1');
        $editableItem2 = new EditableItem('type2', 'name2');
        $editableItem3 = new EditableItem('type3', 'name3');

        $expected = new TabPanelItem();
        $expected->getOrCreateTab('Settings')->addItem($editableItem1, $editableItem2, $editableItem3);

        $dialogBox = $dialogBuilder
            ->addTab('Settings', $editableItem1, $editableItem2)
            ->addTab('Settings', $editableItem3)
            ->build();

        self::assertSame($expected->toArray(), $dialogBox->getItems());
    }

    /**
     * @test
     */
    public function addingContentAndThenTabs(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('You cannot add tabs and content at the same time.');

        (new DialogBoxBuilder($translator->reveal()))->addContent()->addTab('Test');
    }

    /**
     * @test
     */
    public function addingTabsAndThenContent(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('You cannot add content and tabs at the same time.');

        (new DialogBoxBuilder($translator->reveal()))->addTab('Test')->addContent();
    }
}
