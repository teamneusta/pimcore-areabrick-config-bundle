<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model;

final class Page
{
    public int $id;
    public string $type;
    public string $url;
    public bool $published = false;
}
