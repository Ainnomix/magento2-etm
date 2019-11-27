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

use Ainnomix\EtmCore\Api\Data\AttributeSetInterface;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeSetSearchResultsInterface;
use Ainnomix\EtmCore\Model\Entity\Attribute\Set\Command;
use Magento\Framework\Api\SearchCriteriaInterface;

class SetRepository implements AttributeSetRepositoryInterface
{

    /**
     * @var Command\GetInterface
     */
    private $commandGet;

    /**
     * @var Command\DeleteByIdInterface
     */
    private $commandDeleteById;

    /**
     * @var Command\SaveInterface
     */
    private $commandSave;

    /**
     * @var Command\GetListInterface
     */
    private $commandGetList;

    public function __construct(
        Command\GetInterface $commandGet,
        Command\DeleteByIdInterface $commandDeleteById,
        Command\SaveInterface $commandSave,
        Command\GetListInterface $commandGetList
    ) {
        $this->commandGet = $commandGet;
        $this->commandDeleteById = $commandDeleteById;
        $this->commandSave = $commandSave;
        $this->commandGetList = $commandGetList;
    }

    /**
     * {@inheritDoc}
     */
    public function get(int $setId): AttributeSetInterface
    {
        return $this->commandGet->execute($setId);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $setId): void
    {
        $this->commandDeleteById->execute($setId);
    }

    /**
     * {@inheritDoc}
     */
    public function save(AttributeSetInterface $attributeSet): int
    {
        return $this->commandSave->execute($attributeSet);
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $criteria = null): AttributeSetSearchResultsInterface
    {
        return $this->commandGetList->execute($criteria);
    }
}
