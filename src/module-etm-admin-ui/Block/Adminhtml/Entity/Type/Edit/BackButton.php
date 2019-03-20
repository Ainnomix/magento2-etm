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

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Go back button config provider class
 *
 * @category Ainnomix_EtmAdminhtml
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@ainnomix.com>
 */
class BackButton implements ButtonProviderInterface
{

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    public function __construct(\Magento\Framework\UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Retrieve button configuration data
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Generate url to the base entity types page
     *
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->urlBuilder->getUrl('*/*/');
    }
}
