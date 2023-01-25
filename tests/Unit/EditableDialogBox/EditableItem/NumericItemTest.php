<?php

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\DialogBoxItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\NumericItem;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class NumericItemTest extends TestCase
{
    const ITEM_TEST_LABEL = 'test';
    const MIN_VALUE = 12;
    const MAX_VALUE = 24;
    const REGULAR_DEFAULT_VALUE = 20;
    const OUTOFBOUNDS_DEFAULT_VALUE = 30;

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
                ]
            ],
            $item->toArray()
        );
    }

    /**
     * @test
     */
    public function setDefaultValue_regular_case(): void
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
                ]
            ],
            $item->toArray()
        );
    }

    /**
     * @test
     */
    public function setDefaultValue_outofbounds_case(): void
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
                ]
            ],
            $item->toArray()
        );
    }
}
