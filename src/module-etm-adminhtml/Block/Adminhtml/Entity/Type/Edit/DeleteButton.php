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

namespace Ainnomix\EtmAdminhtml\Block\Adminhtml\Entity\Type\Edit;

use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Ainnomix\EtmAdminhtml\Model\Entity\Type\TypeManagement;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * {{DESCRIPTION}}
 *
 * @category Ainnomix_EtmAdminhtml
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@ainnomix.com>
 */
class DeleteButton implements ButtonProviderInterface
{

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var TypeManagement
     */
    private $typeManagement;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        UrlInterface $urlBuilder,
        TypeManagement $typeManagement,
        RequestInterface $request
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->typeManagement = $typeManagement;
        $this->request = $request;
    }

    public function getButtonData(): array
    {
        $id = (int) $this->request->getParam('id');
        $entity = $this->typeManagement->getById($id);

        if ($entity->getEntityTypeId()) {
            return [
                'label' => __('Delete Entity Type'),
                'class' => 'delete',
                'id' => 'entity-type-edit-delete-button',
                'data_attribute' => [
                    'url' => $this->getDeleteUrl($id)
                ],
                'on_click' => '',
                'sort_order' => 20,
            ];
        }

        return [];
    }

    public function getDeleteUrl($entityId): string
    {
        return $this->urlBuilder->getUrl('*/*/delete', ['id' => $entityId]);
    }
}
