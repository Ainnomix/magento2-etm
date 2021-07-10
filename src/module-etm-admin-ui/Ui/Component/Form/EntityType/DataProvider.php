<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_Etm
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Ui\Component\Form\EntityType;

use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as UiDataProvider;

/**
 * Entity type form data provider
 *
 * @author Roman Tomchak <romantomchak@gmail.com>
 */
class DataProvider extends UiDataProvider
{

    /**
     * Generate entity type form metadata
     *
     * @return array
     */
    public function getMeta(): array
    {
        $meta = parent::getMeta();

        $id = (int) $this->request->getParam($this->getRequestFieldName());

        if (0 !== $id) {
            $metadata = [
                'general' => [
                    'children' => [
                        'entity_type_code' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'disabled' => true
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $meta = array_merge_recursive($meta, $metadata);
        }

        return $meta;
    }

    /**
     * Returns search criteria
     *
     * @return SearchCriteria
     */
    public function getSearchCriteria()
    {
        if (!$this->searchCriteria) {
            $this->searchCriteriaBuilder->addFilter(
                $this->filterBuilder
                    ->setField('is_custom')
                    ->setValue(1)
                    ->setConditionType('eq')
                    ->create()
            );
            $this->searchCriteria = $this->searchCriteriaBuilder->create();
            $this->searchCriteria->setRequestName($this->name);
        }
        return $this->searchCriteria;
    }
}
