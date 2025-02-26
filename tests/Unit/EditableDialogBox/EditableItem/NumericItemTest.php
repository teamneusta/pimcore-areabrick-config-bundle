<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\NumericItem;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

class NumericItemTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function defaultValueDefaultsToMinValue(): void
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
            $item->toArray($this->prophesize(TranslatorInterface::class)->reveal()),
        );
    }

    /**
     * @test
     */
    public function defaultValueCanBeSet(): void
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
            $item->toArray($this->prophesize(TranslatorInterface::class)->reveal()),
        );
    }

    /**
     * @test
     */
    public function defaultValueMustNotBeBelowMinValue(): void
    {
        $item = new NumericItem('test', 10, 20);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Default value "5" is out of bounds: [10,20]');

        $item->setDefaultValue(5);
    }

    /**
     * @test
     */
    public function defaultValueMustNotBeAboveMaxValue(): void
    {
        $item = new NumericItem('test', 10, 20);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Default value "30" is out of bounds: [10,20]');

        $item->setDefaultValue(30);
    }
}
