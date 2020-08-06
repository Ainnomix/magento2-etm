<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity;

use Ainnomix\EtmCore\Api\AttributeRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSearchResultInterface;
use Ainnomix\EtmCore\Model\Entity\Attribute\Command;
use Magento\Framework\Api\SearchCriteriaInterface;

class AttributeRepository implements AttributeRepositoryInterface
{

    /**
     * @var Command\SaveInterface
     */
    protected $commandSave;

    /**
     * @var Command\GetInterface
     */
    protected $commandGet;

    /**
     * @var Command\GetByIdInterface
     */
    protected $commandGetById;

    /**
     * @var Command\DeleteByIdInterface
     */
    protected $commandDeleteById;

    /**
     * @var Command\GetListInterface
     */
    protected $commandGetList;

    public function __construct(
        Command\SaveInterface $commandSave,
        Command\GetInterface $commandGet,
        Command\GetByIdInterface $commandGetById,
        Command\DeleteByIdInterface $commandDeleteById,
        Command\GetListInterface $commandGetList
    ) {
        $this->commandSave = $commandSave;
        $this->commandGet = $commandGet;
        $this->commandGetById = $commandGetById;
        $this->commandDeleteById = $commandDeleteById;
        $this->commandGetList = $commandGetList;
    }

    /**
     * {@inheritDoc}
     */
    public function save(AttributeInterface $attribute): int
    {
        return $this->commandSave->execute($attribute);
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $entityTypeCode, string $attributeCode): AttributeInterface
    {
        return $this->commandGet->execute($entityTypeCode, $attributeCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $attributeId): AttributeInterface
    {
        return $this->commandGetById->execute($attributeId);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $attributeId): void
    {
        $this->commandDeleteById->execute($attributeId);
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $criteria = null): AttributeSearchResultInterface
    {
        return $this->commandGetList->execute($criteria);
    }
}
