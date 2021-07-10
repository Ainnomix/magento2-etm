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

namespace Ainnomix\EtmAdminUi\Ui\Component\Listing\EntityAttribute\Control;

use Magento\Framework\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class NewButton implements ButtonProviderInterface
{

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * NewButton constructor
     *
     * @param UrlInterface     $urlBuilder
     * @param RequestInterface $request
     */
    public function __construct(UrlInterface $urlBuilder, RequestInterface $request)
    {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function getButtonData(): array
    {
        $typeId = (int) $this->request->getParam('entity_type_id');

        return [
            'label' => __('Add New Attribute'),
            'class' => 'primary',
            'url' => $this->urlBuilder->getUrl('*/*/new', ['entity_type_id' => $typeId]),
            'sort_order' => 35,
        ];
    }
}
