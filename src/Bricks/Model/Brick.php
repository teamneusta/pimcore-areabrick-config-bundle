<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model;

class Brick
{
    public string $name;
    public string $id;
    public ?string $version;
    public ?string $description;
    public ?string $template;

    /** @var array<Page> */
    public array $pages;

    /** @var array<BrickProperty> */
    public array $additionalProperties;
}
