<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttribute;

use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Edit extends AbstractAction implements HttpGetActionInterface
{

    /**
     * Execute controller action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $resultPage;
    }
}
