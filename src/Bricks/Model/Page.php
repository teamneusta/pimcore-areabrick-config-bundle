<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model;

class Page
{
    public string $name;
    public bool $published = false;
    public string $url;
    public string $editModeUrl;
}
