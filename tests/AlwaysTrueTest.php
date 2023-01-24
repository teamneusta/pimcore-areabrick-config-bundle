<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests;

use PHPUnit\Framework\TestCase;

class AlwaysTrueTest extends TestCase
{
    /** @test */
    public function assertAlwaysTrue(): void
    {
        self::assertTrue(true);
    }
}
