<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix_EtmAdminhtml
 * @package   Ainnomix\EtmAdminhtml
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\Entity\Type;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Json;

/**
 * Entity type validation action class
 *
 * @category Ainnomix
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Validate extends \Magento\Backend\App\Action implements HttpPostActionInterface
{

    /**
     * Execute controller action
     *
     * @return Json
     */
    public function execute(): Json
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $result->setData(['data' => ['error' => false, 'messages' => []]]);

        return $result;
    }
}
