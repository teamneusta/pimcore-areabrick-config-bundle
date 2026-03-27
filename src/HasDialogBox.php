<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Pimcore\Extension\Document\Areabrick\AbstractAreabrick;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxConfiguration;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;

/**
 * @template T of DialogBoxBuilder
 *
 * @mixin AbstractAreabrick
 *
 * @phpstan-ignore trait.unused
 */
trait HasDialogBox
{
    final public function getEditableDialogBoxConfiguration(Editable $area, ?Info $info): EditableDialogBoxConfiguration
    {
        $builder = $this->createDialogBoxBuilder($area, $info);

        $this->buildDialogBox($builder, $area, $info);

        if ($configuratorServiceName = $info?->getParam('dialogBoxConfigurator')) {
            if (!$this->container->has($configuratorServiceName)) {
                throw new \LogicException(\sprintf(
                    'The service "%s" referenced via "params.%s.dialogBoxConfigurator" does not exist.',
                    $configuratorServiceName,
                    $info->getId(),
                ));
            }

            $configurator = $this->container->get($configuratorServiceName);

            if (!$configurator instanceof DialogBoxConfigurator) {
                throw new \LogicException(\sprintf(
                    'The service "%s" referenced via "params.%s.dialogBoxConfigurator" must implement "%s", "%s" given.',
                    $configuratorServiceName,
                    $info->getId(),
                    DialogBoxConfigurator::class,
                    $configurator::class,
                ));
            }

            $configurator->configureDialogBox($builder, $area, $info);
        }

        return $builder->build();
    }

    /**
     * @return T
     */
    private function createDialogBoxBuilder(Editable $area, ?Info $info): DialogBoxBuilder
    {
        return new DialogBoxBuilder();
    }

    /**
     * @param T $dialogBox
     */
    abstract private function buildDialogBox(DialogBoxBuilder $dialogBox, Editable $area, ?Info $info): void;
}
