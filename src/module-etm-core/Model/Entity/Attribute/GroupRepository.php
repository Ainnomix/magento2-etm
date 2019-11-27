<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\Entity\Attribute;

use Ainnomix\EtmCore\Api\AttributeGroupRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupInterface;
use Ainnomix\EtmCore\Api\Data\AttributeGroupSearchResultsInterface;
use Ainnomix\EtmCore\Model\Entity\Attribute\Group\Command;
use Magento\Framework\Api\SearchCriteriaInterface;

class GroupRepository implements AttributeGroupRepositoryInterface
{

    /**
     * @var Command\GetInterface
     */
    private $commandGet;

    /**
     * @var Command\SaveInterface
     */
    private $commandSave;

    /**
     * @var Command\DeleteByIdInterface
     */
    private $commandDeleteById;

    /**
     * @var Command\GetListInterface
     */
    private $commandGetList;

    public function __construct(
        Command\GetInterface $commandGet,
        Command\SaveInterface $commandSave,
        Command\DeleteByIdInterface $commandDeleteById,
        Command\GetListInterface $commandGetList
    ) {
        $this->commandGet = $commandGet;
        $this->commandSave = $commandSave;
        $this->commandDeleteById = $commandDeleteById;
        $this->commandGetList = $commandGetList;
    }

    /**
     * {@inheritDoc}
     */
    public function get(int $groupId): AttributeGroupInterface
    {
        return $this->commandGet->execute($groupId);
    }

    /**
     * {@inheritDoc}
     */
    public function save(AttributeGroupInterface $attributeGroup): int
    {
        return $this->commandSave->execute($attributeGroup);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $groupId): void
    {
        $this->commandDeleteById->execute($groupId);
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $criteria = null): AttributeGroupSearchResultsInterface
    {
        return $this->commandGetList->execute($criteria);
    }
}
