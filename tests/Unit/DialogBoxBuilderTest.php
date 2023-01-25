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
    public function adding_two_tabs_with_some_items(): void
    {
        $dialogBuilder = new DialogBoxBuilder();
        $editableItem1 = new EditableItem('type1', 'name1');
        $editableItem2 = new EditableItem('type2', 'name2');
        $editableItem3 = new EditableItem('type3', 'name3');

        $expected = new TabPanelItem();
        $expected->addTab(new PanelItem('Settings', [$editableItem1, $editableItem2]));
        $expected->addTab(new PanelItem('Other', [$editableItem3]));

        $dialogBox = $dialogBuilder
            ->addTab('Settings', $editableItem1, $editableItem2)
            ->addTab('Other', $editableItem3)
            ->build();

        self::assertSame($expected->toArray(), $dialogBox->getItems());
    }
}
