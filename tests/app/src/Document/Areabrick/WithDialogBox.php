<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\app\src\Document\Areabrick;

use Neusta\Pimcore\AreabrickConfigBundle\DialogBoxBuilder;
use Neusta\Pimcore\AreabrickConfigBundle\HasDialogBox;
use Pimcore\Extension\Document\Areabrick\AbstractAreabrick;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxInterface;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;
use Symfony\Component\Translation\TranslatableMessage;

final class WithDialogBox extends AbstractAreabrick implements EditableDialogBoxInterface
{
    /** @use HasDialogBox<DialogBoxBuilder> */
    use HasDialogBox;

    public function __construct(private readonly bool $translated = false)
    {
    }

    public function getTemplate(): ?string
    {
        return null;
    }

    public function getTemplateLocation(): string
    {
        return '';
    }

    public function getTemplateSuffix(): string
    {
        return '';
    }

    private function buildDialogBox(DialogBoxBuilder $dialogBox, Editable $area, ?Info $info): void
    {
        $dialogBox->addContent(
            $dialogBox->createInput('title')->setLabel($this->translated ? new TranslatableMessage('title') : 'Title'),
        );
    }
}
