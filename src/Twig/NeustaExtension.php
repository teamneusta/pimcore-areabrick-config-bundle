<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class NeustaExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('any', self::any(...)),
        ];
    }

    /**
     * @param iterable<mixed> $array
     */
    private static function any(iterable $array, callable $arrow): bool
    {
        foreach ($array as $k => $v) {
            if ($arrow($v, $k)) {
                return true;
            }
        }

        return false;
    }
}
