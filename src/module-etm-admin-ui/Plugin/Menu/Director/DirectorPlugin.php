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
use Ainnomix\EtmAdminUi\Model\Acl\Resource\NameProvider;
use Psr\Log\LoggerInterface;

class DirectorPlugin
{

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    /**
     * @var NameProvider
     */
    protected $nameProvider;

    public function __construct(EntityTypeRepositoryInterface $entityTypeRepository, NameProvider $nameProvider)
    {
        $this->entityTypeRepository = $entityTypeRepository;
        $this->nameProvider = $nameProvider;
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
        $mainNodeId = $this->nameProvider->getMainNodeId($item);
        $entitiesNodeId = $this->nameProvider->getEntitiesNodeId($item);
        $attributesNodeId = $this->nameProvider->getAttributesNodeId($item);
        $attributeSetsNodeId = $this->nameProvider->getAttributeSetsNodeId($item);

        return [
            [
                'type'  => 'add',
                'id'    => $mainNodeId,
                'title' => (string) __('%1 Management', $item->getEntityTypeName()),
                'module'   => 'Ainnomix_EtmAdminUi',
                'parent'   => 'Ainnomix_EtmAdminUi::etm',
                'resource' => $mainNodeId,
                'sortOrder' => $item->getEntityTypeId() * 10,
            ],
            [
                'type'  => 'add',
                'id'    => $entitiesNodeId,
                'title' => (string) __('Manage Entities'),
                'module'   => 'Ainnomix_EtmAdminUi',
                'parent'   => $mainNodeId,
                'resource' => $entitiesNodeId,
                'action'   => $this->generateMenuAction($item, 'entity'),
                'sortOrder' => 10,
            ],
            [
                'type'  => 'add',
                'id'    => $attributesNodeId,
                'title' => (string) __('Manage Attributes'),
                'module'   => 'Ainnomix_EtmAdminUi',
                'parent'   => $mainNodeId,
                'resource' => $attributesNodeId,
                'action'   => $this->generateMenuAction($item, 'entityAttribute'),
                'sortOrder' => 20,
            ],
            [
                'type'  => 'add',
                'id'    => $attributeSetsNodeId,
                'title' => (string) __('Manage Attribute Sets'),
                'module'   => 'Ainnomix_EtmAdminUi',
                'parent'   => $mainNodeId,
                'resource' => $attributeSetsNodeId,
                'action'   => $this->generateMenuAction($item, 'entityAttributeSet'),
                'sortOrder' => 30,
            ]
        ];
    }

    private function generateMenuAction(EntityTypeInterface $entityType, string $action): string
    {
        return sprintf('etm/%s/index/entity_type_id/%s', $action, $entityType->getEntityTypeId());
    }
}
