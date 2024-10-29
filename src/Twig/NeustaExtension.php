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
            // Todo: remove in favor of the `any`-test once [#4422](https://github.com/twigphp/Twig/pull/4422) got released
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
