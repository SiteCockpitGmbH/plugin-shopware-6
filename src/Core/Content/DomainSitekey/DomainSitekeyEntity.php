<?php declare(strict_types=1);

namespace SiteCockpitEasyVisionShopware6\Core\Content\DomainSitekey;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class DomainSitekeyEntity extends Entity
{
    use EntityIdTrait;

    protected ?string $salesChannelDomainId;

    protected ?string $sitekey;

    public function getEntityClass(): string
    {
        return DomainSitekeyEntity::class;
    }

    public function getSalesChannelDomainId(): ?string // Changed return type
    {
        return $this->salesChannelDomainId;
    }

    public function setSalesChannelDomainId(string $salesChannelDomainId): void // Changed parameter type
    {
        $this->salesChannelDomainId = $salesChannelDomainId;
    }

    public function getSitekey(): ?string
    {
        return $this->sitekey;
    }

    public function setSitekey(string $sitekey): void
    {
        $this->sitekey = $sitekey;
    }
}
