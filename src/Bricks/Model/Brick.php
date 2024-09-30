<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model;

final class Brick
{
    public string $id;
    public string $name;
    public ?string $version;
    public ?string $description;
    public ?string $template;

    /** @var array<Page> */
    public array $pages;

    /** @var array<BrickProperty> */
    public array $additionalProperties;
}
