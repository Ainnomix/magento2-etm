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

namespace Ainnomix\EtmAdminUi\Plugin\Acl\AclResource\Config\Reader;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Api\EntityTypeRepositoryInterface;
use Ainnomix\EtmAdminUi\Model\Acl\TypeResource\Context;
use Magento\Framework\Acl\AclResource\Config\Reader\Filesystem;

class FilesystemPlugin
{

    /**
     * @var Context
     */
    private $context;

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    /**
     * FilesystemPlugin constructor
     *
     * @param Context                       $context
     * @param EntityTypeRepositoryInterface $entityTypeRepository
     */
    public function __construct(
        Context $context,
        EntityTypeRepositoryInterface $entityTypeRepository
    ) {
        $this->context = $context;
        $this->entityTypeRepository = $entityTypeRepository;
    }

    /**
     * Call plugin
     *
     * @param Filesystem  $subject
     * @param array       $output
     * @param string|null $scope
     *
     * @return array
     */
    public function afterRead(Filesystem $subject, array $output, string $scope = null)
    {
        foreach ($output['config']['acl']['resources'] as &$resource) {
            if ('Magento_Backend::admin' === $resource['id']) {
                foreach ($resource['children'] as &$child) {
                    if ('Ainnomix_EtmAdminUi::etm' === $child['id']) {
                        $this->generateAclConfig($child);
                        break;
                    }
                }
                break;
            }
        }

        return $output;
    }

    /**
     * Generate acl config
     *
     * @param array $parent
     */
    private function generateAclConfig(array &$parent): void
    {
        $searchResult = $this->entityTypeRepository->getList();
        foreach ($searchResult->getItems() as $entityType) {
            $parent['children'][] = $this->generateEntry($entityType);
        }
    }

    /**
     * Generate acl entry
     *
     * @param EntityTypeInterface $entityType
     *
     * @return array
     */
    private function generateEntry(EntityTypeInterface $entityType): array
    {
        return [
            'id'        => $this->context->getMainIdProvider()->get($entityType),
            'title'     => (string) __('%1 Management', $entityType->getEntityTypeName()),
            'disabled'  => false,
            'sortOrder' => $entityType->getEntityTypeId() * 10,
            'children'  => [
                [
                    'id'        => $this->context->getEntityIdProvider()->get($entityType),
                    'title'     => (string) __('Manage Entities'),
                    'disabled'  => false,
                    'sortOrder' => 10,
                    'children'  => [],
                ],
                [
                    'id'        => $this->context->getAttributeIdProvider()->get($entityType),
                    'title'     => (string) __('Manage Attributes'),
                    'disabled'  => false,
                    'sortOrder' => 20,
                    'children'  => [],
                ],
                [
                    'id'        => $this->context->getAttributeSetIdProvider()->get($entityType),
                    'title'     => (string) __('Manage Attribute Sets'),
                    'disabled'  => false,
                    'sortOrder' => 30,
                    'children'  => [],
                ]
            ],
        ];
    }
}
