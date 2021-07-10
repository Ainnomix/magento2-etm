<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Ui\Component\Form\EntityAttribute;

use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory;
use Ainnomix\EtmCore\Api\AttributeRepositoryInterface;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        AttributeRepositoryInterface $attributeRepository,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );

        $this->collection = $collectionFactory->create();
        $this->attributeRepository = $attributeRepository;
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        $attributeId = (int) $this->request->getParam($this->getRequestFieldName());
        $attribute = $this->attributeRepository->getById($attributeId);
        $this->prepareFrontendLabels($attribute);

        return [
            $attributeId => ['attribute' => $attribute->getData()]
        ];
    }

    protected function prepareFrontendLabels(AttributeInterface $attribute)
    {
        $values = (array) $attribute->getFrontend()->getLabel();

        foreach ($attribute->getFrontendLabels() as $frontendLabel) {
            $values[$frontendLabel->getStoreId()] = $frontendLabel->getLabel();
        }

        $attribute->setFrontendLabel($values);
    }
}
