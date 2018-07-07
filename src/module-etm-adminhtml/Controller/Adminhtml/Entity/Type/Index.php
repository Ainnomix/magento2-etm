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

namespace Ainnomix\EtmAdminhtml\Controller\Adminhtml\Entity\Type;

use Magento\Framework\Controller\ResultFactory;

/**
 * Entity type list action class
 *
 * @category Ainnomix_EtmAdminhtml
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@ainnomix.com>
 */
class Index extends \Magento\Backend\App\Action
{

    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Ainnomix_EtmAdminhtml::management_index');

        $resultPage->getConfig()->getTitle()->prepend(__('Entity Type Manager'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Entity Types'));

        return $resultPage;
    }
}
