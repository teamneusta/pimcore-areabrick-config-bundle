<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Bricks\Model;

final class Brick
{
    public string $id;
    public string $name;
    public ?string $version;
    public ?string $description;
    public ?string $template;

    /** @var list<Page> */
    public array $pages;

    /** @var list<BrickProperty> */
    public array $additionalProperties = [];
}
