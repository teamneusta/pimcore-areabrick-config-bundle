<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class RelationItem extends EditableItem
{
    public const TYPE = 'relation';

    /** @var array{asset?: list<string>, document?: list<string>, object?: list<string>} */
    private array $types = [];
    /** @var list<string> */
    private array $classes = [];

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function allowAssetsOfType(string ...$types): static
    {
        return $this->addType('asset', array_values($types));
    }

    public function allowDocumentsOfType(string ...$types): static
    {
        return $this->addType('document', array_values($types));
    }

    public function allowObjectsOfClass(string ...$classes): static
    {
        $this->addType('object', ['object']);
        $this->classes = array_values($classes);

        return $this;
    }

    protected function getConfig(): array
    {
        return array_filter([
            'types' => array_keys($this->types),
            'subtypes' => array_filter($this->types),
            'classes' => $this->classes,
        ]);
    }

    /**
     * @param list<string> $subTypes
     */
    private function addType(string $type, array $subTypes): static
    {
        $this->types[$type] = $subTypes;

        return $this;
    }
}
