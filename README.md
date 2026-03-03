# Areabrick Config Bundle

Object-oriented editable dialog box configuration building for Areabricks.

## Installation

1. **Require the bundle**

   ```shell
   composer require teamneusta/pimcore-areabrick-config-bundle
   ```

2. **Enable the bundle**

   Add the Bundle to your `config/bundles.php`:

   ```php
   Neusta\Pimcore\AreabrickConfigBundle\NeustaPimcoreAreabrickConfigBundle::class => ['all' => true],
   ```

## Usage

This bundle allows you to create Areabrick configuration dialogs in an object-oriented way.

### 1. Prepare Areabrick Class

Your Areabrick class must implement the `Pimcore\Extension\Document\Areabrick\EditableDialogBoxInterface` interface 
and use the `Neusta\Pimcore\AreabrickConfigBundle\HasDialogBox` trait.

Then, implement the `buildDialogBox()` method to define the dialog.

```php
<?php

namespace App\Document\Areabrick;

use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxBuilder;
use Neusta\Pimcore\AreabrickConfigBundle\HasDialogBox;
use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxInterface;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;

class MyAreabrick extends AbstractTemplateAreabrick implements EditableDialogBoxInterface
{   
    /** @template-use HasDialogBox<DialogBoxBuilder> */
    use HasDialogBox;

    private function buildDialogBox(DialogBoxBuilder $dialogBox, Editable $area, ?Info $info): void
    {
        $dialogBox
            ->addTab('Settings',
                $dialogBox->createInput('my-input')
                    ->setLabel('Text Input')
                    ->setPlaceholder('Please enter text...')
            )
            ->addTab('Options',
                $dialogBox->createCheckbox('my-checkbox')
                    ->setLabel('Activate')
                    ->setDefaultChecked()
            );
    }
}
```

### 2. Access in Twig Template

The configured values can be retrieved via the Pimcore editables in the template as usual:

```twig
<p>Input: {{ pimcore_input('my-input').getData() }}</p>

{% if pimcore_checkbox('my-checkbox').isChecked() %}
    <p>Checkbox is activated!</p>
{% endif %}
```

## Features

### Dialog Configuration

You can customize the size of the dialog and specify whether the page should be reloaded after closing.

```php
$dialogBox
    ->width(800)
    ->height(600)
    ->reloadOnClose(true);
```

### Layout Options

#### Simple Content

For simple dialogs you can use `addContent`:

```php
$dialogBox->addContent(
    $dialogBox->createInput('field-1'),
    $dialogBox->createInput('field-2')
);
```

#### Tabs

If you want to organize your fields into multiple tabs, use `addTab`:

```php
$dialogBox->addTab('Tab Title', 
    $dialogBox->createInput('field-1'),
    $dialogBox->createInput('field-2')
);
```

> [!IMPORTANT]
> You cannot mix `addTab` and `addContent` in the same dialog.

### Available Editables

The `DialogBoxBuilder` provides various methods for creating editables:

#### Input

A simple text input field.

```php
$dialogBox->createInput('name')
    ->setLabel('Label')
    ->setPlaceholder('Placeholder')
    ->setDefaultValue('Default value')
    ->setWidth(300);
```

#### Checkbox

A simple checkbox to toggle a boolean value.

```php
$dialogBox->createCheckbox('name')
    ->setLabel('Label')
    ->setDefaultChecked(); // or setDefaultUnchecked()
```

#### Select

A dropdown selection field.

```php
$dialogBox->createSelect('name', [
    'value1' => 'Label 1',
    'value2' => 'Label 2',
])
    ->setLabel('Selection')
    ->setDefaultValue('value2');
```

#### Relation

Allows the selection of objects, assets, or documents.

```php
$dialogBox->createRelation('my-relation')
    ->setLabel('Relation')
    ->allowObjectsOfClass('MyPimcoreClass')
    ->allowAssetsOfType('image')
    ->allowDocumentsOfType('page');
```

#### Link

A field for selecting internal or external links.

```php
$dialogBox->createLink('my-link')
    ->setLabel('Link')
    ->allowTypes('document', 'asset', 'object')
    ->disallowFields('anchor', 'rel');
```

#### Numeric

An input field for numbers with min/max validation.

```php
$dialogBox->createNumeric('count', 1, 10)
    ->setLabel('Count')
    ->setDefaultValue(5);
```

#### Date

A date picker.

```php
$dialogBox->createDate('date')
    ->setLabel('Date')
    ->setFormat('d.m.Y');
```

#### Custom Configuration

All editables allow setting arbitrary configuration values via the `addConfig` method. 
This is useful for passing additional parameters that are not covered by the dedicated methods:

```php
$dialogBox->createInput('name')
    ->addConfig('any-editable-config-key', 'value');
```

## DialogBoxConfigurator

The `DialogBoxConfigurator` allows you to customize the dialog box configuration dynamically.
This is particularly useful if an Areabrick is used within another Areabrick
and you want to adjust settings like default values or select options based on the context.

### 1. Create a Configurator Class

Implement the `Neusta\Pimcore\AreabrickConfigBundle\DialogBoxConfigurator` interface:

```php
<?php

namespace App\Areabrick;

use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxBuilder;
use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxConfigurator;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;

final class MyAreabrickDialogBoxConfigurator implements DialogBoxConfigurator
{
    public function configureDialogBox(DialogBoxBuilder $dialogBox, Editable $area, ?Info $info): void
    {
        $dialogBox->height(500);

        $dialogBox->getTab('Settings')
            ->getEditable('my-input')
                ->setDefaultValue('Custom Context Value');

        $dialogBox->reloadOnClose(false);
    }
}
```

> [!IMPORTANT]
> The configurator class must be registered as a `public` service in your container.

### 2. Usage in Twig

You can pass the service ID of your configurator via the `dialogBoxConfigurator` parameter
in the `pimcore_area` or `pimcore_areablock` helpers.

> [!TIP]
> If the service ID matches the FQCN, you can simply use the FQCN.

```twig
{{ pimcore_area('myfield', {
    type: 'my-areabrick',
    params: {
        'my-areabrick': {
            dialogBoxConfigurator: 'App\Areabrick\MyAreabrickDialogBoxConfigurator',
        }
    },
}) }}
```

## Configuration

Currently, there is no configuration available.

## Contribution

Feel free to open issues for any bug, feature request, or other ideas.

Please remember to create an issue before creating large pull requests.

### Local Development

To develop on your local machine, the vendor dependencies are required.

```shell
bin/composer install
```

We use composer scripts for our main quality tools. They can be executed via the `bin/composer` file as well.

```shell
bin/composer cs:fix
bin/composer phpstan
bin/composer tests
```
