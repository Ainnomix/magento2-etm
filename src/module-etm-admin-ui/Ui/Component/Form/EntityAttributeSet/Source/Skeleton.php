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

namespace Ainnomix\EtmAdminUi\Ui\Component\Form\EntityAttributeSet\Source;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Ainnomix\EtmCore\Api\AttributeSetRepositoryInterface;

class Skeleton implements OptionSourceInterface
{

    /**
     * @var AttributeSetRepositoryInterface
     */
    private $attributeSetRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * Skeleton constructor
     *
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param SearchCriteriaBuilder           $searchCriteriaBuilder
     * @param RequestInterface                $request
     */
    public function __construct(
        AttributeSetRepositoryInterface $attributeSetRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request
    ) {
        $this->attributeSetRepository = $attributeSetRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function toOptionArray()
    {
        $typeId = (int) $this->request->getParam('entity_type_id');

        $searchCriteria = $this->searchCriteriaBuilder->addFilter('entity_type_id', $typeId);
        $items = $this->attributeSetRepository->getList($searchCriteria->create());

        $options = [];
        foreach ($items->getItems() as $item) {
            $options[] = ['label' => $item->getAttributeSetName(), 'value' => $item->getAttributeSetId()];
        }

        return $options;
    }
}
