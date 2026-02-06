<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

class RelationItem extends EditableItem
{
    /** @var array{asset?: list<string>, document?: list<string>, object?: list<string>} */
    private array $types = [];
    /** @var list<string> */
    private array $classes = [];

    public function __construct(string $name)
    {
        parent::__construct('relation', $name);
    }

    /**
     * @return $this
     */
    public function allowAssetsOfType(string ...$types): static
    {
        return $this->addType('asset', array_values($types));
    }

    /**
     * @return $this
     */
    public function allowDocumentsOfType(string ...$types): static
    {
        return $this->addType('document', array_values($types));
    }

    /**
     * @return $this
     */
    public function allowObjectsOfClass(string ...$classes): static
    {
        $this->addType('object', ['object']);
        $this->classes = array_values($classes);

        return $this;
    }

    /**
     * @return $this
     */
    public function setWidth(int $width): static
    {
        return $this->addConfig('width', $width);
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
     *
     * @return $this
     */
    private function addType(string $type, array $subTypes): static
    {
        $this->types[$type] = $subTypes;

        return $this;
    }
}
