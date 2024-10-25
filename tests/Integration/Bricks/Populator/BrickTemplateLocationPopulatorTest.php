<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Integration\Bricks\Populator;

use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model\Brick;
use Neusta\Pimcore\AreabrickConfigBundle\Bricks\Populator\BrickTemplateLocationPopulator;
use Pimcore\Extension\Document\Areabrick\AreabrickManagerInterface;
use Pimcore\Test\KernelTestCase;

final class BrickTemplateLocationPopulatorTest extends KernelTestCase
{
    /**
     * @test
     */
    public function itPopulatesCustomTemplates(): void
    {
        $container = self::getContainer();
        $populator = $container->get(BrickTemplateLocationPopulator::class);
        $source = $container->get(AreabrickManagerInterface::class)->getBrick('custom-template');
        $target = new Brick();

        $populator->populate($target, $source);

        self::assertSame('custom-template-areabrick/index.html.twig', $target->template);
    }

    /**
     * @test
     */
    public function itPopulatesDefaultTemplateLocations(): void
    {
        $container = self::getContainer();
        $populator = $container->get(BrickTemplateLocationPopulator::class);
        $source = $container->get(AreabrickManagerInterface::class)->getBrick('global-template-location');
        $target = new Brick();

        $populator->populate($target, $source);

        self::assertSame('areas/global-template-location/view.html.twig', $target->template);
    }
}
