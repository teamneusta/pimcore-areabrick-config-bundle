<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\NumericItem;
use PHPUnit\Framework\TestCase;

class NumericItemTest extends TestCase
{
    /**
     * @test
     */
    public function createNewItem(): void
    {
        $item = new NumericItem('test', 12, 24);

        self::assertEquals(
            [
                'type' => 'numeric',
                'name' => 'test',
                'config' => [
                    'defaultValue' => 12,
                    'minValue' => 12,
                    'maxValue' => 24,
                ],
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function setDefaultValueRegularCase(): void
    {
        $item = new NumericItem('test', 12, 24);
        $item->setDefaultValue(20);

        self::assertEquals(
            [
                'type' => 'numeric',
                'name' => 'test',
                'config' => [
                    'defaultValue' => 20,
                    'minValue' => 12,
                    'maxValue' => 24,
                ],
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function setDefaultValueOutOfBoundsCase(): void
    {
        $item = new NumericItem('test', 12, 24);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Default value "30" is out of bounds: [12,24]');

        $item->setDefaultValue(30);
    }
}
