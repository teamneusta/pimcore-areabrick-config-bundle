<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem;
use Pimcore\Version;

class DateItem extends EditableItem
{
    public function __construct(string $name)
    {
        parent::__construct('date', $name);
    }

    /**
     * @return $this
     */
    public function setDefaultValue(string $value): static
    {
        return $this->addConfig('defaultValue', $value);
    }

    /**
     * @return $this
     */
    public function setFormat(string $value): static
    {
        return $this->addConfig('format', $value);
    }

    /**
     * @deprecated since version 2.2.4, use setOutputIsoFormat instead.
     *
     * @return $this
     */
    public function setOutputFormat(string $value): static
    {
        static $pimcoreVersion;
        $pimcoreVersion ??= ltrim(Version::getVersion(), 'v');

        if (version_compare($pimcoreVersion, '11.2', '>=')) {
            trigger_deprecation(
                'pimcore/pimcore',
                '2.2.4',
                'Using "%s::setOutputFormat()" for date editable is deprecated, use "setOutputIsoFormat()" instead.',
                static::class
            );
        }

        return $this->addConfig('outputFormat', $value);
    }

    /**
     * @return $this
     */
    public function setOutputIsoFormat(string $value): static
    {
        return $this->addConfig('outputIsoFormat', $value);
    }

    /**
     * @return $this
     */
    public function setWidth(int $width): static
    {
        return $this->addConfig('width', $width);
    }
}
