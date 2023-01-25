<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\NumericItem;
use Neusta\Pimcore\AreabrickConfigBundle\Exception\OutOfBoundsException;

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
                'type' => 'numeric',
                'name' => self::ITEM_TEST_LABEL,
                'config' => [
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
    public function setDefaultValueOutOfBoundsCase(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Default value 30 is out of bounds (12;24)');
        $item = new NumericItem(self::ITEM_TEST_LABEL, self::MIN_VALUE, self::MAX_VALUE);
        $item->setDefaultValue(self::OUTOFBOUNDS_DEFAULT_VALUE);
    }
}
