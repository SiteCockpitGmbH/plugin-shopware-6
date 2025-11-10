<?php declare(strict_types=1);

namespace SiteCockpitEasyVisionShopware6;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\DeactivateContext;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class SiteCockpitEasyVisionShopware6 extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        // Do stuff such as creating a new payment method
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);

        if ($uninstallContext->keepUserData()) {
            return;
        }

        $currentVersion = $uninstallContext->getCurrentPluginVersion();
        if(version_compare($currentVersion, '2.1.0', '<')) {
            $connection = $this->container->get(Connection::class);
            $connection?->executeStatement('DROP TABLE IF EXISTS `domain_sitekey`');
        }
    }

    public function activate(ActivateContext $activateContext): void
    {
        // Activate entities, such as a new payment method
        // Or create new entities here, because now your plugin is installed and active for sure
    }

    public function deactivate(DeactivateContext $deactivateContext): void
    {
        // Deactivate entities, such as a new payment method
        // Or remove previously created entities
    }

    public function update(UpdateContext $updateContext): void
    {
        $currentVersion = $updateContext->getCurrentPluginVersion();
        if(version_compare($currentVersion, '2.1.0', '<')) {
            /** @var SystemConfigService|null $systemConfigService */
            $systemConfigService = $this->container->get(SystemConfigService::class);
            /** @var Connection|null $connection */
            $connection = $this->container->get(Connection::class);
            if($systemConfigService === null || $connection === null) {
                return;
            }
            try {
                $result = $connection->executeQuery('SELECT * FROM `domain_sitekey`')->fetchAllAssociative();
                // Map configuration into system configuration, but set it just once for sales channel null
                if(!empty($result)) {
                    $domainKey = $result[0]['sitekey'] ?? null;
                    if(!empty($domainKey)) {
                        $systemConfigService->set('SiteCockpitEasyVisionShopware6.config.easyvisionIntegrationKey', $domainKey, null);
                    }
                }
                $connection->executeStatement('DROP TABLE IF EXISTS `domain_sitekey`');
            } catch (Exception|\Doctrine\DBAL\Exception $e) {
                // Not much to do here - we can ignore this.
            }
        }
    }

    public function postInstall(InstallContext $installContext): void
    {
    }

    public function postUpdate(UpdateContext $updateContext): void
    {
    }
}
