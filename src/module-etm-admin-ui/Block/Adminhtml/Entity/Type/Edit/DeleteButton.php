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
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Delete entity type button config provider class
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
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        UrlInterface $urlBuilder,
        RequestInterface $request
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
    }

    /**
     * Retrieve button configuration data
     *
     * @return array
     */
    public function getButtonData(): array
    {
        $entityTypeId = (int) $this->request->getParam('id');

        if ($entityTypeId) {
            return [
                'label' => __('Delete Entity Type'),
                'class' => 'delete',
                'id' => 'entity-type-edit-delete-button',
                'data_attribute' => [
                    'url' => $this->getDeleteUrl($entityTypeId)
                ],
                'on_click' => '',
                'sort_order' => 20,
            ];
        }

        return [];
    }

    /**
     * Generate delete url for current entity type model
     *
     * @param int $entityTypeId Entity type ID
     *
     * @return string
     */
    public function getDeleteUrl(int $entityTypeId): string
    {
        return $this->urlBuilder->getUrl('*/*/delete', ['id' => $entityTypeId]);
    }
}
