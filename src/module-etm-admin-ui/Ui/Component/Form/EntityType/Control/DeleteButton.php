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

namespace Ainnomix\EtmAdminUi\Ui\Component\Form\EntityType\Control;

use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

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
                'label' => __('Delete'),
                'class' => 'delete',
                'id' => 'entity-type-edit-delete-button',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->getDeleteUrl($entityTypeId) . '\', {"data": {}})',
                'sort_order' => 35,
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
