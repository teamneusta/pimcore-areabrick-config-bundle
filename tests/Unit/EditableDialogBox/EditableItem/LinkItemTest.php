<?php declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Tests\Unit\EditableDialogBox\EditableItem;

use Neusta\Pimcore\AreabrickConfigBundle\EditableDialogBox\EditableItem\LinkItem;
use PHPUnit\Framework\TestCase;

class LinkItemTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesLinkItemWithDefaultConfiguration(): void
    {
        $item = new LinkItem('test');

        self::assertEquals(
            [
                'type' => 'link',
                'name' => 'test',
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function itAllowsTypes(): void
    {
        $item = new LinkItem('test');

        $item->allowTypes('asset', 'document', 'object');

        self::assertEquals(
            [
                'type' => 'link',
                'name' => 'test',
                'config' => [
                    'allowedTypes' => ['asset', 'document', 'object'],
                ],
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function itAllowsAssetsOfSpecificTypes(): void
    {
        $item = new LinkItem('test');

        $item->allowAssetsOfType('image', 'video');

        self::assertEquals(
            [
                'type' => 'link',
                'name' => 'test',
                'config' => [
                    'allowedTypes' => ['asset'],
                    'allowedSubtypes' => [
                        'asset' => ['image', 'video'],
                    ],
                ],
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function itAllowsDocumentsOfSpecificTypes(): void
    {
        $item = new LinkItem('test');

        $item->allowDocumentsOfType('page', 'snippet');

        self::assertEquals(
            [
                'type' => 'link',
                'name' => 'test',
                'config' => [
                    'allowedTypes' => ['document'],
                    'allowedSubtypes' => [
                        'document' => ['page', 'snippet'],
                    ],
                ],
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function itAllowsObjectsOfSpecificClasses(): void
    {
        $item = new LinkItem('test');

        $item->allowObjectsOfClass('Product', 'Category');

        self::assertEquals(
            [
                'type' => 'link',
                'name' => 'test',
                'config' => [
                    'allowedTypes' => ['object'],
                    'allowedSubtypes' => [
                        'object' => ['object'],
                    ],
                    'allowedClasses' => ['Product', 'Category'],
                ],
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function itAllowsTargets(): void
    {
        $item = new LinkItem('test');

        $item->allowTargets('_blank', '_self');

        self::assertEquals(
            [
                'type' => 'link',
                'name' => 'test',
                'config' => [
                    'allowedTargets' => ['_blank', '_self'],
                ],
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function itDisallowsFields(): void
    {
        $item = new LinkItem('test');

        $item->disallowFields('text', 'target', 'parameters');

        self::assertEquals(
            [
                'type' => 'link',
                'name' => 'test',
                'config' => [
                    'disabledFields' => ['text', 'target', 'parameters'],
                ],
            ],
            $item->toArray(),
        );
    }

    /**
     * @test
     */
    public function itCombinesAllConfigurationOptions(): void
    {
        $item = new LinkItem('test');

        $item
            ->allowAssetsOfType('image')
            ->allowDocumentsOfType('page')
            ->allowObjectsOfClass('Product')
            ->allowTargets('_blank')
            ->disallowFields('anchor', 'title');

        self::assertEquals(
            [
                'type' => 'link',
                'name' => 'test',
                'config' => [
                    'allowedTypes' => ['asset', 'document', 'object'],
                    'allowedSubtypes' => [
                        'asset' => ['image'],
                        'document' => ['page'],
                        'object' => ['object'],
                    ],
                    'allowedClasses' => ['Product'],
                    'allowedTargets' => ['_blank'],
                    'disabledFields' => ['anchor', 'title'],
                ],
            ],
            $item->toArray(),
        );
    }
}
