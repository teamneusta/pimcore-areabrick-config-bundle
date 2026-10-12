<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit;

use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxBuilder;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\PanelItem;
use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\LayoutItem\TabPanelItem;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;

class DialogBoxBuilderTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function addingContent(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);
        $dialogBuilder = new DialogBoxBuilder($translator->reveal());
        $editableItem1 = new EditableItem('type1', 'name1');
        $editableItem2 = new EditableItem('type2', 'name2');
        $editableItem3 = new EditableItem('type3', 'name3');

        $expected = new PanelItem('', [$editableItem1, $editableItem2, $editableItem3]);

        $dialogBox = $dialogBuilder
            ->addContent($editableItem1, $editableItem2)
            ->addContent($editableItem3)
            ->build();

        self::assertSame($expected->toArray(), $dialogBox->getItems());
    }

    /**
     * @test
     */
    public function addingTwoTabsWithSomeItems(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);
        $dialogBuilder = new DialogBoxBuilder($translator->reveal());
        $editableItem1 = new EditableItem('type1', 'name1');
        $editableItem2 = new EditableItem('type2', 'name2');
        $editableItem3 = new EditableItem('type3', 'name3');

        $expected = new TabPanelItem();
        $expected->addTab(new PanelItem('Settings', [$editableItem1, $editableItem2]));
        $expected->addTab(new PanelItem('Other', [$editableItem3]));

        $dialogBox = $dialogBuilder
            ->addNamedTab('settings', 'Settings', $editableItem1, $editableItem2)
            ->addNamedTab('other', 'Other', $editableItem3)
            ->build();

        self::assertSame($expected->toArray(), $dialogBox->getItems());
    }

    /**
     * @test
     */
    public function addingItemsToExistingTab(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);
        $dialogBuilder = new DialogBoxBuilder($translator->reveal());
        $editableItem1 = new EditableItem('type1', 'name1');
        $editableItem2 = new EditableItem('type2', 'name2');
        $editableItem3 = new EditableItem('type3', 'name3');

        $expected = new TabPanelItem();
        $expected->addTab(new PanelItem('Settings', [$editableItem1, $editableItem2, $editableItem3]));

        $dialogBox = $dialogBuilder
            ->addNamedTab('settings', 'Settings', $editableItem1, $editableItem2)
            ->addNamedTab('settings', 'Settings', $editableItem3)
            ->build();

        self::assertSame($expected->toArray(), $dialogBox->getItems());
    }

    /**
     * @test
     */
    public function translatableValuesAreTranslatedOnBuild(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);
        $translator->trans('my.label', [], null, null)->willReturn('Translated Label');

        $dialogBuilder = new DialogBoxBuilder($translator->reveal());
        $editableItem = (new EditableItem('type1', 'name1'))->setLabel(new TranslatableMessage('my.label'));

        $dialogBox = $dialogBuilder->addContent($editableItem)->build();

        self::assertSame('Translated Label', $dialogBox->getItems()['items'][0]['label']);
    }

    /**
     * @test
     */
    public function defaultTranslationDomainIsUsedWhenNoneIsSetExplicitly(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);
        $translator->trans('my.label', [], 'my_domain', null)->willReturn('Translated Label');

        $dialogBuilder = new DialogBoxBuilder($translator->reveal());
        $dialogBuilder->defaultTranslationDomain('my_domain');
        $editableItem = (new EditableItem('type1', 'name1'))->setLabel(new TranslatableMessage('my.label'));

        $dialogBox = $dialogBuilder->addContent($editableItem)->build();

        self::assertSame('Translated Label', $dialogBox->getItems()['items'][0]['label']);
    }

    /**
     * @test
     */
    public function addingContentAndThenTabs(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('You already have content and cannot have tabs at the same time.');

        (new DialogBoxBuilder($translator->reveal()))->addContent()->addNamedTab('test', 'Test');
    }

    /**
     * @test
     */
    public function addingTabsAndThenContent(): void
    {
        $translator = $this->prophesize(TranslatorInterface::class);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('You already have tabs and cannot have content at the same time.');

        (new DialogBoxBuilder($translator->reveal()))->addNamedTab('test', 'Test')->addContent();
    }
}
