<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Plugin\Menu\Director;

use Closure;
use Magento\Backend\Model\Menu\Builder;
use Magento\Backend\Model\Menu\Director\Director;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Psr\Log\LoggerInterface;

class DirectorPlugin
{

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    public function __construct(EntityTypeRepositoryInterface $entityTypeRepository)
    {
        $this->entityTypeRepository = $entityTypeRepository;
    }

    public function aroundDirect(Director $subject, Closure $proceed, array $config, Builder $builder, LoggerInterface $logger)
    {
        $searchResult = $this->entityTypeRepository->getList();

        foreach ($searchResult->getItems() as $item) {
            $config = array_merge($config, $this->createEntry($item));
        }

        return $proceed($config, $builder, $logger);
    }

    private function createEntry(EntityTypeInterface $item): array
    {
        return [
            [
                'type'  => 'add',
                'id'    => sprintf('Ainnomix_EtmAdminUi::etm_%s', $item->getEntityTypeCode()),
                'title' => (string) __('%1 Management', $item->getEntityTypeName()),
                'module'   => 'Ainnomix_EtmAdminUi',
                'parent'   => 'Ainnomix_EtmAdminUi::etm',
                'resource' => sprintf('Ainnomix_EtmAdminUi::etm_%s', $item->getEntityTypeCode()),
                'sortOrder' => $item->getEntityTypeId() * 10,
            ],
            [
                'type'  => 'add',
                'id'    => sprintf('Ainnomix_EtmAdminUi::etm_entities_%s', $item->getEntityTypeCode()),
                'title' => (string) __('Manage Entities'),
                'module'   => 'Ainnomix_EtmAdminUi',
                'parent'   => sprintf('Ainnomix_EtmAdminUi::etm_%s', $item->getEntityTypeCode()),
                'resource' => sprintf('Ainnomix_EtmAdminUi::etm_entities_%s', $item->getEntityTypeCode()),
                'sortOrder' => 10,
            ],
            [
                'type'  => 'add',
                'id'    => sprintf('Ainnomix_EtmAdminUi::etm_attributes_%s', $item->getEntityTypeCode()),
                'title' => (string) __('Manage Attributes'),
                'module'   => 'Ainnomix_EtmAdminUi',
                'parent'   => sprintf('Ainnomix_EtmAdminUi::etm_%s', $item->getEntityTypeCode()),
                'resource' => sprintf('Ainnomix_EtmAdminUi::etm_attributes_%s', $item->getEntityTypeCode()),
                'sortOrder' => 20,
            ],
            [
                'type'  => 'add',
                'id'    => sprintf('Ainnomix_EtmAdminUi::etm_attribute_sets_%s', $item->getEntityTypeCode()),
                'title' => (string) __('Manage Attribute Sets'),
                'module'   => 'Ainnomix_EtmAdminUi',
                'parent'   => sprintf('Ainnomix_EtmAdminUi::etm_%s', $item->getEntityTypeCode()),
                'resource' => sprintf('Ainnomix_EtmAdminUi::etm_attribute_sets_%s', $item->getEntityTypeCode()),
                'sortOrder' => 30,
            ]
        ];
    }
}
