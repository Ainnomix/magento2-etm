<?php
declare(strict_types=1);

/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_EtmAdminhtml
 * @package   Ainnomix\EtmAdminhtml
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2018 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Ainnomix\EtmAdminhtml\Ui\Component\Form\Entity\Type;

use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Ainnomix\EtmCore\Model\ResourceModel\Entity\Type\CollectionFactory;

/**
 * Entity type form data provider
 *
 * @category Ainnomix_EtmAdminhtml
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@ainnomix.com>
 */
class DataProvider extends AbstractDataProvider
{

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var array
     */
    private $loadedData;

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
        $this->request = $request;
    }

    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        foreach ($this->getCollection() as $item) {
            $this->loadedData[$item->getEntityTypeId()] = $item->toArray([]);
        }

        return $this->loadedData;
    }

    public function getMeta(): array
    {
        $meta = parent::getMeta();

        $id = (int) $this->request->getParam($this->getRequestFieldName());

        if (isset($this->getData()[$id])) {
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
}
