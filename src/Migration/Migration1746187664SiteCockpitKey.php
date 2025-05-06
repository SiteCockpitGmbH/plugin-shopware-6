<?php declare(strict_types=1);

namespace SiteCockpit\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
class Migration1746187664SiteCockpitKey extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1746187664;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
                    CREATE TABLE IF NOT EXISTS domain_sitekey (
                        id BINARY(16) NOT NULL,
                        sales_channel_domain_id BINARY(16) NOT NULL,
                        sitekey VARCHAR(255) NOT NULL,
                        created_at DATETIME(3) NOT NULL,
                        updated_at DATETIME(3) NULL,
                        PRIMARY KEY (id),
                        CONSTRAINT fk_s360_domain_sitekey_sales_channel_domain_id FOREIGN KEY (sales_channel_domain_id)
                            REFERENCES sales_channel_domain (id) ON DELETE CASCADE ON UPDATE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;
        $connection->executeStatement($sql);
    }

    public function updateDestructive(Connection $connection): void
    {

    }
}
