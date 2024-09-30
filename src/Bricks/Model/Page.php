<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model;

final class Page
{
    public string $name;
    public string $url;
    public string $editModeUrl;
    public bool $published = false;
}
