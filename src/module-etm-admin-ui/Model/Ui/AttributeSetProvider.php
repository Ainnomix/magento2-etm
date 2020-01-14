<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Model\Ui;

use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetInterfaceFactory;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class AttributeSetProvider
{

    /**
     * @var AttributeSetRepositoryInterface
     */
    private $attributeSetRepository;
    /**
     * @var AttributeSetInterfaceFactory
     */
    private $attributeSetFactory;

    /**
     * @var AttributeSetInterface[]
     */
    private $attributeSetCache = [];

    public function __construct(
        AttributeSetRepositoryInterface $attributeSetRepository,
        AttributeSetInterfaceFactory $attributeSetFactory
    ) {
        $this->attributeSetRepository = $attributeSetRepository;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * Retrieve attribute set instance by ID and entity type
     *
     * @param EntityTypeInterface $entityType
     * @param int $attributeSetId
     *
     * @return AttributeSetInterface
     *
     * @throws NoSuchEntityException
     */
    public function get(EntityTypeInterface $entityType, int $attributeSetId): AttributeSetInterface
    {
        if (isset($this->attributeSetCache[$attributeSetId])) {
            return $this->attributeSetCache[$attributeSetId];
        }

        if (0 === $attributeSetId) {
            return $this->attributeSetCache[$attributeSetId] = $this->attributeSetFactory->create();
        }

        $attributeSet = $this->attributeSetRepository->get($attributeSetId);

        return $this->attributeSetCache[$attributeSetId] = $attributeSet;
    }
}
