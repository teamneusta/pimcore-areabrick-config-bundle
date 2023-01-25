<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\DialogBoxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\NumericItem;

use function PHPUnit\Framework\assertEquals;

use PHPUnit\Framework\TestCase;

class NumericItemTest extends TestCase
{
    public const ITEM_TEST_LABEL = 'test';
    public const MIN_VALUE = 12;
    public const MAX_VALUE = 24;
    public const REGULAR_DEFAULT_VALUE = 20;
    public const OUTOFBOUNDS_DEFAULT_VALUE = 30;

    /**
     * @test
     */
    public function createNewItem(): void
    {
        $item = new NumericItem(self::ITEM_TEST_LABEL, self::MIN_VALUE, self::MAX_VALUE);

        assertEquals(
            [
                'type' => 'numeric',
                'name' => self::ITEM_TEST_LABEL,
                'config' => [
                    'defaultValue' => self::MIN_VALUE,
                    'minValue' => self::MIN_VALUE,
                    'maxValue' => self::MAX_VALUE,
                ],
            ],
            $item->toArray()
        );
    }

    /**
     * @test
     */
    public function setDefaultValueRegularCase(): void
    {
        $item = new NumericItem(self::ITEM_TEST_LABEL, self::MIN_VALUE, self::MAX_VALUE);
        $item->setDefaultValue(self::REGULAR_DEFAULT_VALUE);
        assertEquals(
            [
                DialogBoxItem::ITEM_TYPE => 'numeric',
                DialogBoxItem::ITEM_NAME => self::ITEM_TEST_LABEL,
                DialogBoxItem::ITEM_CONFIG => [
                    'defaultValue' => self::REGULAR_DEFAULT_VALUE,
                    'minValue' => self::MIN_VALUE,
                    'maxValue' => self::MAX_VALUE,
                ],
            ],
            $item->toArray()
        );
    }

    /**
     * @test
     */
    public function setDefaultValueOutofboundsCase(): void
    {
        $item = new NumericItem(self::ITEM_TEST_LABEL, self::MIN_VALUE, self::MAX_VALUE);
        $item->setDefaultValue(self::OUTOFBOUNDS_DEFAULT_VALUE);
        assertEquals(
            [
                'type' => 'numeric',
                'name' => self::ITEM_TEST_LABEL,
                'config' => [
                    'defaultValue' => self::MIN_VALUE,
                    'minValue' => self::MIN_VALUE,
                    'maxValue' => self::MAX_VALUE,
                ],
            ],
            $item->toArray()
        );
    }
}
