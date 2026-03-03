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
    /** @var list<Types> */
    private array $allowedTypes = [];
    /** @var list<Targets> */
    private array $allowedTargets = [];
    /** @var list<Fields> */
    private array $disabledFields = [];

    public function __construct(string $name)
    {
        parent::__construct('link', $name);
    }

    /**
     * @no-named-arguments
     *
     * @param Types ...$types
     *
     * @return $this
     */
    public function allowTypes(string ...$types): self
    {
        $this->allowedTypes = $types;

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

    protected function getConfig(): array
    {
        return array_filter([
            'allowedTypes' => $this->allowedTypes,
            'allowedTargets' => $this->allowedTargets,
            'disabledFields' => $this->disabledFields,
        ], static fn (array $item) => [] !== $item);
    }
}
