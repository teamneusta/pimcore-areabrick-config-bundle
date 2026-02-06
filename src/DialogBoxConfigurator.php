<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle;

use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;

/**
 * Allows configuring a {@see DialogBoxBuilder} instance.
 *
 * This is useful if you want to customize the default configuration,
 * for example, if the areabrick is used within the area of another areabrick.
 * In this case, you may, for example, want to change the default values of an item
 * or the possible values of a select item.
 *
 * ```
 * namespace App\Areabrick;
 *
 * use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxBuilder;
 * use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxConfigurator;
 * use Pimcore\Model\Document\Editable;
 * use Pimcore\Model\Document\Editable\Area\Info;
 *
 * final class MyAreabrickDialogBoxConfigurator implements DialogBoxConfigurator
 * {
 *     public function configureDialogBox(DialogBoxBuilder $dialogBox, Editable $area, ?Info $info): void
 *     {
 *         $dialogBox->height(500);
 *
 *         $dialogBox->getTab('General')
 *             ->getEditableItem('my-select')
 *                 ->setStore([
 *                     'option1' => 'Option 1',
 *                     'option2' => 'Option 2',
 *                 ])
 *                 ->setDefaultValue('option2');
 *
 *          $dialogBox->reloadOnClose(false);
 *     }
 * }
 * ```
 *
 * After registering the configurator with its FQCN in the container,
 * the configurator can be used like this:
 *
 * ```
 * {{ pimcore_area('myfield', {
 *     type: 'my-areabrick',
 *     params: {
 *         'my-areabrick': {
 *             dialogBoxConfigurator: 'App\Areabrick\MyAreabrickDialogBoxConfigurator',
 *         }
 *     },
 * }) }}
 * ```
 */
interface DialogBoxConfigurator
{
    public function configureDialogBox(DialogBoxBuilder $dialogBox, Editable $area, ?Info $info): void;
}
