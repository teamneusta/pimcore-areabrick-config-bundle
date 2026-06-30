<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

/**
 * @phpstan-type Types = 'asset'|'document'|'object'
 * @phpstan-type Targets = ''|'_blank'|'_self'|'_top'|'_parent'
 * @phpstan-type Fields = 'text'|'target'|'parameters'|'anchor'|'title'|'accesskey'|'rel'|'tabindex'|'class'|'attributes'
 */
class LinkItem extends EditableItem
{
    /** @var array{asset?: list<string>, document?: list<string>, object?: list<string>} */
    private array $allowedTypes = [];
    /** @var list<string> */
    private array $allowedClasses = [];
    /** @var list<Targets> */
    private array $allowedTargets = [];
    /** @var list<Fields> */
    private array $disabledFields = [];

    public function __construct(string $name)
    {
        parent::__construct('link', $name);
    }

    /**
     * @param Types ...$types
     *
     * @return $this
     */
    public function allowTypes(string ...$types): self
    {
        foreach ($types as $type) {
            $this->addType($type, []);
        }

        return $this;
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
        $this->allowedClasses = array_values($classes);

        return $this;
    }

    /**
     * @no-named-arguments
     *
     * @param Targets ...$targets
     *
     * @return $this
     */
    public function allowTargets(string ...$targets): self
    {
        $this->allowedTargets = $targets;

        return $this;
    }

    /**
     * @no-named-arguments
     *
     * @param Fields ...$fields
     *
     * @return $this
     */
    public function disallowFields(string ...$fields): self
    {
        $this->disabledFields = $fields;

        return $this;
    }

    protected function defaultConfig(): array
    {
        return array_filter([
            'allowedTypes' => array_keys($this->allowedTypes),
            'allowedSubtypes' => array_filter($this->allowedTypes),
            'allowedClasses' => $this->allowedClasses,
            'allowedTargets' => $this->allowedTargets,
            'disabledFields' => $this->disabledFields,
        ], static fn (array $item) => [] !== $item);
    }

    /**
     * @param list<string> $subTypes
     *
     * @return $this
     */
    private function addType(string $type, array $subTypes): static
    {
        $this->allowedTypes[$type] = $subTypes;

        return $this;
    }
}
