<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit;

use Neusta\Pimcore\AreabrickConfigBundle\Tests\app\src\Document\Areabrick\WithDialogBox;
use Neusta\Pimcore\AreabrickConfigBundle\Translation\TranslatorWithDefaultDomain;
use PHPUnit\Framework\TestCase;
use Pimcore\Model\Document\Editable;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Contracts\Translation\TranslatorInterface;

class HasDialogBoxTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function dialogBoxCanBeBuiltWithoutContainer(): void
    {
        $brick = new WithDialogBox();

        $config = $brick->getEditableDialogBoxConfiguration($this->area(), null);

        self::assertSame('Title', $config->getItems()['items'][0]['label']);
    }

    /**
     * @test
     */
    public function translatableValuesWithoutContainerThrow(): void
    {
        $brick = new WithDialogBox(translated: true);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Translatable labels/values require a translator.');

        $brick->getEditableDialogBoxConfiguration($this->area(), null);
    }

    /**
     * @test
     */
    public function translatorIsTakenFromContainer(): void
    {
        $inner = $this->prophesize(TranslatorInterface::class);
        $inner->trans('title', [], 'my_domain', null)->willReturn('Titel');

        $container = new Container();
        $container->set(TranslatorWithDefaultDomain::class, new TranslatorWithDefaultDomain($inner->reveal(), 'my_domain'));

        $brick = new WithDialogBox(translated: true);
        $brick->setContainer($container);

        $config = $brick->getEditableDialogBoxConfiguration($this->area(), null);

        self::assertSame('Titel', $config->getItems()['items'][0]['label']);
    }

    /**
     * @test
     */
    public function containerWithoutTranslatorServiceIsTolerated(): void
    {
        $brick = new WithDialogBox();
        $brick->setContainer(new Container());

        $config = $brick->getEditableDialogBoxConfiguration($this->area(), null);

        self::assertSame('Title', $config->getItems()['items'][0]['label']);
    }

    /**
     * @test
     */
    public function translatableValuesWithoutTranslatorServiceThrow(): void
    {
        $brick = new WithDialogBox(translated: true);
        $brick->setContainer(new Container());

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Translatable labels/values require a translator.');

        $brick->getEditableDialogBoxConfiguration($this->area(), null);
    }

    private function area(): Editable
    {
        return $this->prophesize(Editable::class)->reveal();
    }
}
