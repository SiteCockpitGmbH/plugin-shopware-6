<?php declare(strict_types=1);

namespace SiteCockpit\Core\Content\DomainSitekey;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\System\SalesChannel\Aggregate\SalesChannelDomain\SalesChannelDomainDefinition;

class DomainSitekeyDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'domain_sitekey';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new FkField('sales_channel_domain_id', 'domainID', SalesChannelDomainDefinition::class))->addFlags(new Required()),
            (new StringField('sitekey', 'sitekey'))->addFlags(new Required()),

            new OneToOneAssociationField('sales_channel_domain_id', 'sales_channel_domain_id', 'id', SalesChannelDomainDefinition::class, false)
        ]);
    }
}