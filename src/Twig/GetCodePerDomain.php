<?php declare(strict_types=1);

namespace SiteCockpit\Twig;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GetCodePerDomain extends AbstractExtension
{
    private EntityRepositoryInterface $domainSiteKeyRepository;

    public function __construct(EntityRepositoryInterface $domainSiteKeyRepository)
    {
        $this->domainSiteKeyRepository = $domainSiteKeyRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getCodePerDomain', [$this, 'getCodeByDomain']),
        ];
    }

    public function getCodeByDomain(string $domainId, SalesChannelContext $context)
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('domainID', $domainId));

        $result = $this->domainSiteKeyRepository->search($criteria, $context->getContext())->getEntities()->first();

        if ($result === null) {
            return '';
        }

        return $result->get('sitekey') ?? '';
    }
}
