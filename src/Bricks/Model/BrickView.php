<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model;

class BrickView
{
    public string $name;
    public string $id;

    /** @var array<string> */
    public array $tags;

    /** @var array<mixed> */
    public array $pageFullPaths;
}
