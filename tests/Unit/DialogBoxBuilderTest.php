<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit;

use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxBuilder;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DialogBoxBuilderTest extends TestCase
{
    use ProphecyTrait;

    public const TEST_TYPE = 'my-type';
    public const TEST_NAME = 'my-name';
    public const TEST_TAB_NAME = 'Settings';

    /**
     * @test
     */
    public function buildDialogBoxDefaultCase(): void
    {
        $actualBox = (new DialogBoxBuilder())->build();

        self::assertSame(600, $actualBox->getWidth());
        self::assertTrue($actualBox->getReloadOnClose());
    }

    /**
     * @test
     */
    public function buildDialogBoxAddSettingsCase(): void
    {
        $dialogBuilder = new DialogBoxBuilder();
        $editableItem1 = new EditableItem(self::TEST_TYPE, self::TEST_NAME . '-1');
        $editableItem2 = new EditableItem(self::TEST_TYPE, self::TEST_NAME . '-2');
        $editableItem3 = new EditableItem(self::TEST_TYPE, self::TEST_NAME . '-3');

        $dialogBox = $dialogBuilder
            ->addTab(
                self::TEST_TAB_NAME,
                $editableItem1,
                $editableItem2,
                $editableItem3,
            )
            ->build();

        $dialogBoxItems = $dialogBox->getItems();
        self::assertSame('tabpanel', $dialogBoxItems['type']);
        $firstTabPanel = $dialogBoxItems['items'][0];
        self::assertSame('panel', $firstTabPanel['type']);
        self::assertSame(self::TEST_TAB_NAME, $firstTabPanel['title']);
        self::assertCount(3, $firstTabPanel['items']);
        self::assertSame($editableItem1->toArray(), $firstTabPanel['items'][0]);
        self::assertSame($editableItem2->toArray(), $firstTabPanel['items'][1]);
        self::assertSame($editableItem3->toArray(), $firstTabPanel['items'][2]);
    }
}
