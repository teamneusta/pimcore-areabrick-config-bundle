<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit\Bricks\Populator;

use Neusta\ConverterBundle\Populator;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Page;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Populator\BrickPageEditModeUrlPopulator;
use PHPUnit\Framework\TestCase;
use Pimcore\Model\Document\Page as PimcorePage;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class BrickPageEditModeUrlPopulatorTest extends TestCase
{
    use ProphecyTrait;

    private Populator $populator;

    /** @var ObjectProphecy<PimcorePage> */
    private $source;

    private Page $target;

    protected function setUp(): void
    {
        $this->source = $this->prophesize(PimcorePage::class);
        $this->source->getId()->willReturn(123);

        $this->populator = new BrickPageEditModeUrlPopulator();
    }

    /**
     * @test
     */
    public function populate_regular_case(): void
    {
        $this->target = new Page();

        $this->populator->populate($this->target, $this->source->reveal());

        self::assertEquals('/admin/login/deeplink?document_123_page', $this->target->editModeUrl);
    }
}
