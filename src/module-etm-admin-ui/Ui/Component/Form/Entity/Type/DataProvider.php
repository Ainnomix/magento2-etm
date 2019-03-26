<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_Etm
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Ui\Component\Form\Entity\Type;

/**
 * Entity type form data provider
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmAdminUi
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{

    public function getMeta(): array
    {
        $meta = parent::getMeta();

//        $id = (int) $this->request->getParam($this->getRequestFieldName());
//
//        if (isset($this->getData()[$id])) {
//            $metadata = [
//                'general' => [
//                    'children' => [
//                        'entity_type_code' => [
//                            'arguments' => [
//                                'data' => [
//                                    'config' => [
//                                        'disabled' => true
//                                    ]
//                                ]
//                            ]
//                        ]
//                    ]
//                ]
//            ];
//
//            $meta = array_merge_recursive($meta, $metadata);
//        }

        return $meta;
    }
}
