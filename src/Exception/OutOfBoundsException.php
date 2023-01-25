<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Exception;

class OutOfBoundsException extends \Exception
{
    public function __construct(int $defaultValue, int $min, int $max)
    {
        $message = sprintf('Default value %d is out of bounds (%d;%d)', $defaultValue, $min, $max);
        parent::__construct($message);
    }
}
