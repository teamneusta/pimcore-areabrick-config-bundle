<?php
declare(strict_types=1);

namespace Neusta\Pimcore\AreabrickConfigBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Pimcore\Migrations\BundleAwareMigration;

final class Version20241001090000 extends BundleAwareMigration
{
    private const PERMISSION_KEY_AREABRICKS = 'neusta_areabrick_config.areabrick_overview';

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT IGNORE INTO users_permission_definitions (`key`, `category`) VALUES('" . self::PERMISSION_KEY_AREABRICKS . "', 'Neusta Areabrick Config Bundle');");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM users_permission_definitions WHERE `key` = '" . self::PERMISSION_KEY_AREABRICKS . "';");
    }

    protected function getBundleName(): string
    {
        return 'NeustaPimcoreAreabrickConfigBundle';
    }
}
