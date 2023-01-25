<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\NumericItem;
use PHPUnit\Framework\TestCase;

class NumericItemTest extends TestCase
{
    /**
     * @test
     */
    public function default_value_defaults_to_min_value(): void
    {
        $item = new NumericItem('test', 1, 10);

        self::assertEquals(
            [
                'type' => 'numeric',
                'name' => 'test',
                'config' => [
                    'defaultValue' => 1,
                    'minValue' => 1,
                    'maxValue' => 10,
                ],
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function default_value_can_be_set(): void
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
    public function default_value_must_not_be_below_min_value(): void
    {
        $item = new NumericItem('test', 10, 20);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Default value "5" is out of bounds: [10,20]');

        $item->setDefaultValue(5);
    }

    /**
     * @test
     */
    public function default_value_must_not_be_above_max_value(): void
    {
        $item = new NumericItem('test', 10, 20);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Default value "30" is out of bounds: [10,20]');

        $item->setDefaultValue(30);
    }
}
