<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit;

use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxBuilder;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\PanelItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\TabPanelItem;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DialogBoxBuilderTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function addingContent(): void
    {
        $dialogBuilder = new DialogBoxBuilder();
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
        $dialogBuilder = new DialogBoxBuilder();
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
        $dialogBuilder = new DialogBoxBuilder();
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
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('You cannot add tabs and content at the same time.');

        (new DialogBoxBuilder())->addContent()->addTab('Test');
    }

    /**
     * @test
     */
    public function addingTabsAndThenContent(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('You cannot add content and tabs at the same time.');

        (new DialogBoxBuilder())->addTab('Test')->addContent();
    }
}
