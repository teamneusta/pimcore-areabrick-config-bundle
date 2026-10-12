<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit;

use Neusta\Pimcore\AreabrickConfigBundle\Tests\app\src\Document\Areabrick\WithDialogBox;
use PHPUnit\Framework\TestCase;
use Pimcore\Model\Document\Editable;
use Prophecy\PhpUnit\ProphecyTrait;

class HasDialogBoxTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function dialogBoxCanBeBuiltWithoutContainer(): void
    {
        $brick = new WithDialogBox();
        $area = $this->prophesize(Editable::class)->reveal();

        $config = $brick->getEditableDialogBoxConfiguration($area, null);

        self::assertSame('Title', $config->getItems()['items'][0]['label']);
    }

    /**
     * @test
     */
    public function translatableValuesWithoutTranslatorServiceThrow(): void
    {
        $brick = new WithDialogBox();
        $brick->translated = true;
        $area = $this->prophesize(Editable::class)->reveal();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Translatable labels/values require a translator.');

        $brick->getEditableDialogBoxConfiguration($area, null);
    }
}
