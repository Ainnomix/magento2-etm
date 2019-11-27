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
use Magento\Framework\Acl\AclResource\Config\Reader\Filesystem;

class FilesystemPlugin
{

    /**
     * @var EntityTypeRepositoryInterface
     */
    protected $entityTypeRepository;

    public function __construct(EntityTypeRepositoryInterface $entityTypeRepository)
    {
        $this->entityTypeRepository = $entityTypeRepository;
    }

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

    private function generateAclConfig(array &$parent): void
    {
        $searchResult = $this->entityTypeRepository->getList();
        foreach ($searchResult->getItems() as $entityType) {
            $parent['children'][] = $this->generateEntry($entityType);
        }
    }

    private function generateEntry(EntityTypeInterface $entityType): array
    {
        return [
            'id'        => sprintf('Ainnomix_EtmAdminUi::etm_%s', $entityType->getEntityTypeCode()),
            'title'     => (string) __('%1 Management', $entityType->getEntityTypeName()),
            'disabled'  => false,
            'sortOrder' => $entityType->getEntityTypeId() * 10,
            'children'  => [
                [
                    'id'        => sprintf('Ainnomix_EtmAdminUi::etm_entities_%s', $entityType->getEntityTypeCode()),
                    'title'     => (string) __('Manage Entities'),
                    'disabled'  => false,
                    'sortOrder' => 10,
                    'children'  => [],
                ],
                [
                    'id'        => sprintf('Ainnomix_EtmAdminUi::etm_attributes_%s', $entityType->getEntityTypeCode()),
                    'title'     => (string) __('Manage Attributes'),
                    'disabled'  => false,
                    'sortOrder' => 20,
                    'children'  => [],
                ],
                [
                    'id'        => sprintf('Ainnomix_EtmAdminUi::etm_attribute_sets_%s', $entityType->getEntityTypeCode()),
                    'title'     => (string) __('Manage Attribute Sets'),
                    'disabled'  => false,
                    'sortOrder' => 30,
                    'children'  => [],
                ]
            ],
        ];
    }
}
