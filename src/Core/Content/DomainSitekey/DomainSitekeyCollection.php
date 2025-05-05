<?php declare(strict_types=1);

namespace SiteCockpit\Core\Content\DomainSitekey;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void               add(DomainSitekeyEntity $entity)
 * @method void               set(string $key, DomainSitekeyEntity $entity)
 * @method DomainSitekeyEntity[]    getIterator()
 * @method DomainSitekeyEntity[]    getElements()
 * @method DomainSitekeyEntity|null get(string $key)
 * @method DomainSitekeyEntity|null first()
 * @method DomainSitekeyEntity|null last()
 */
class DomainSitekeyCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return DomainSitekeyEntity::class;
    }
}