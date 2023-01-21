<?php declare(strict_types=1);

namespace Neusta\Pimcore\EditorConfigBundle;

use Pimcore\Extension\Bundle\Installer\AbstractInstaller;
use Pimcore\Model\Asset\Image\Thumbnail;
use Pimcore\Model\Document\DocType;

class Installer extends AbstractInstaller
{
    public function install(): void
    {
        $this->installDocumentTypes();
        $this->installThumbnailConfiguration();
    }

    public function isInstalled(): bool
    {
        return false;
    }

    public function canBeInstalled(): bool
    {
        return !$this->isInstalled();
    }

    public function needsReloadAfterInstall(): bool
    {
        return true;
    }

    private function installDocumentTypes(): void
    {
        $typeDefinitionsFile =
            __DIR__ . \DIRECTORY_SEPARATOR .
            'Resources' . \DIRECTORY_SEPARATOR .
            'config' . \DIRECTORY_SEPARATOR .
            'document-types.php';
        $typeDefinitions = include $typeDefinitionsFile;
        foreach ($typeDefinitions as $typeDefinition) {
            $this->installDocumentType($typeDefinition);
        }
    }

    private function installDocumentType(array $typeDefinition): void
    {
        $model = new DocType();
        $model->setId($typeDefinition['id']);
        $model->setName($typeDefinition['name']);
        $model->setGroup($typeDefinition['group']);
        $model->setController($typeDefinition['controller']);
        $model->setTemplate($typeDefinition['template']);
        $model->setType($typeDefinition['type']);
        $model->setPriority($typeDefinition['priority']);
        $model->setCreationDate($typeDefinition['creationDate']);
        $model->setModificationDate($typeDefinition['modificationDate']);
        $model->save();
    }

    private function installThumbnailConfiguration(): void
    {
        if (Thumbnail\Config::exists('pimcore-presentation-bundle-background-image')) {
            return;
        }

        $thumbnailConfig = new Thumbnail\Config();
        $thumbnailConfig->setName('pimcore-presentation-bundle-background-image');
        $thumbnailConfig->save();
    }
}
