# Editor Config Bundle

Adds common techniques to add editor config to areabricks

## Installation

1. Make sure you can install _neusta Pimcore Bundles_. Read this to learn how
   to [Require Neusta Pimcore Bundle](https://portal.neusta.de/confluence/display/NSDPIMCORE/Require+Neusta+Pimcore+Bundle).
2. Run `composer require teamneusta/pimcore-editorconfig-bundle` to install the bundle
3. Enable and _install_ the pimcore bundle to get certain brick functionality \
   `bin/console pimcore:bundle:enable NeustaPimcoreAreabrickConfigBundle` \
   `bin/console pimcore:bundle:install NeustaPimcoreAreabrickConfigBundle`

## Usage

You need this bundle if you want to staff your areabricks easily with an editor config dialog.

A simple example should show how to do it.

### Areabrick Class

Your areabrick class should implement `Pimcore\Extension\Document\Areabrick\EditableDialogBoxInterface` and additionally
the following:

```php
<?php

use Neusta\Pimcore\AreabrickConfigBundle\src\Document\Base\HasDialogBox;
use Neusta\Pimcore\AreabrickConfigBundle\src\Document\EditableDialogBox\DialogBoxBuilder;
use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxInterface;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;

class Test extends AbstractTemplateAreabrick implements EditableDialogBoxInterface
{   
    /******************************************************************
     * These is the code you have to implement
     *****************************************************************/
     
    /** @template-use HasDialogBox<DialogBoxBuilder> */
    use HasDialogBox;

    protected function createDialogBoxBuilder(Editable $area, ?Info $info): DialogBoxBuilder
    {
        return new DialogBoxBuilder();
    }

    protected function buildDialogBox(DialogBoxBuilder $dialogBox, Editable $area, ?Info $info): void
    {
        $dialogBox
            ->addTab('Einstellungen meines Bricks',
                $dialogBox->createInput('input-label')
                    ->setPlaceholder('Hier bitte was eintragen...')
                    ->setLabel('Texteingabefeld')
            )
            ->addTab('Weitere Einstellungen',
                $dialogBox->createCheckbox('checkbox-label-1')
                    ->setLabel('Feld zum Abhaken')
                    ->setDefaultUnchecked(),
                $dialogBox->createCheckbox('checkbox-label-2')
                    ->setLabel('Weiteres Feld zum Abhaken (bereits abgehakt)')
                    ->setDefaultChecked()
            )
            ->addTab('Und noch mehr',
                $dialogBox->createSelect(
                    'select-label',
                    [
                        'value 1' => 'label 1',
                        'value 2' => 'label 2',
                        'value 3' => 'label 3',
                    ]
                )
                    ->setLabel('Auswahlfeld (Standard: value 2)')
                    ->setDefaultValue('label 2')
            );
    }
    
    // other things may follow
}
```

As you can (nearly) see we add a 3-tabbed-config dialog to our brick which can be opened by clicking on the pencil of
your areabrick:

![pencil_config_dialog.png](docs%2Fimages%2Fpencil_config_dialog.png)

The config dialog will be opened:
![config_dialog.png](docs%2Fimages%2Fconfig_dialog.png)

![config_dialog_tab_2.png](docs%2Fimages%2Fconfig_dialog_tab_2.png)

![config_dialog_tab_3.png](docs%2Fimages%2Fconfig_dialog_tab_3.png)

And after editing the values they are readable and evaluatable in the TWIG template:
```html
  <p>
      Im Feld 'Texteingabefeld' wurde der Wert
      {{ pimcore_input('input-label').getData() }}
      gewählt.
  </p>
  <p>
      Die Checkbox 'Feld zum Abhaken' ist
      
          {% if pimcore_checkbox('checkbox-label-1').isChecked() %}
              abgehakt.
          {% else %}
              NICHT abgehakt.
          {% endif %}
      .
  </p>
  <p>
      Die Checkbox 'Weiteres Feld zum Abhaken (bereits abgehakt)' ist
      
          {% if pimcore_checkbox('checkbox-label-2').isChecked() %}
              abgehakt.
          {% else %}
              NICHT abgehakt.
          {% endif %}
  </p>
  <p>
      Im Auswahlfeld (Standard: wert 2) wurde der Wert
      {{ pimcore_select('select-label') }}
      gewählt.
  </p>
```
## Contribution

Feel free to open issues for any bug, feature request, or other ideas.

Please remember to create an issue before creating large pull requests.

### Running tests for development

```shell
docker run -it --rm -v $(pwd):/app -w /app pimcore/pimcore:PHP8.1-cli composer install --ignore-platform-reqs
docker run -it --rm -v $(pwd):/app -w /app pimcore/pimcore:PHP8.1-cli composer test
```

### Further development

Pipelines will tell you, when code does not meet our standards. To use the same tools in local development, take the Docker command from above with other scripts from the `composer.json`. For example:

* cs:check
* phpstan

```shell
docker run -it --rm -v $(pwd):/app -w /app pimcore/pimcore:PHP8.1-cli composer <composer-script>
```
