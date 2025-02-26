<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Translation;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @internal
 */
final class TranslatorWithDefaultDomain implements TranslatorInterface
{
    public function __construct(
        private readonly TranslatorInterface $inner,
        private readonly string $defaultDomain,
    ) {
    }

    public function withDefaultDomain(string $domain): self
    {
        return new self($this->inner, $domain);
    }

    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
    {
        return $this->inner->trans($id, $parameters, $domain ?? $this->defaultDomain, $locale);
    }

    public function getLocale(): string
    {
        return $this->inner->getLocale();
    }
}
