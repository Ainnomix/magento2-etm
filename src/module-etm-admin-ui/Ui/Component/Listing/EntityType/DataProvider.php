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

namespace Ainnomix\EtmAdminUi\Ui\Component\Listing\EntityType;

use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as ViewDataProvider;

/**
 * Entity type listing data provider
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminUi
 */
class DataProvider extends ViewDataProvider
{

    /**
     * Returns search criteria
     *
     * @return SearchCriteria
     */
    public function getSearchCriteria()
    {
        if (!$this->searchCriteria) {
//            $this->searchCriteriaBuilder->addFilter(
//                $this->filterBuilder
//                    ->setField('is_custom')
//                    ->setValue(1)
//                    ->setConditionType('eq')
//                    ->create()
//            );
            $this->searchCriteria = $this->searchCriteriaBuilder->create();
            $this->searchCriteria->setRequestName($this->name);
        }
        return $this->searchCriteria;
    }
}
