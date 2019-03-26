<?php
declare(strict_types=1);

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

namespace Ainnomix\EtmAdminhtml\Controller\Adminhtml\Entity\Type;

use Magento\Backend\App\Action;
use Ainnomix\EtmAdminhtml\Model\Entity\Type\TypeManagement;
use Ainnomix\EtmAdminhtml\Controller\Adminhtml\Entity\Type\Initialization\Helper as InitializationHelper;
use Ainnomix\EtmAdminhtml\Controller\Adminhtml\Entity\Type\Validation\Helper as ValidationHelper;

/**
 * {{DESCRIPTION}}
 *
 * @category Ainnomix_EtmAdminhtml
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Validate extends \Magento\Backend\App\Action
{

    /**
     * @var TypeManagement
     */
    private $typeManagement;

    /**
     * @var InitializationHelper
     */
    private $initializationHelper;

    /**
     * @var ValidationHelper
     */
    private $validationHelper;

    public function __construct(
        Action\Context $context,
        TypeManagement $typeManagement,
        InitializationHelper $initializationHelper,
        ValidationHelper $validationHelper
    ) {
        parent::__construct($context);

        $this->initializationHelper = $initializationHelper;
        $this->typeManagement = $typeManagement;
        $this->validationHelper = $validationHelper;
    }

    public function execute()
    {
        $entityTypeId = $this->getRequest()->getParam('entity_type_id');

        $entityType = $this->typeManagement->getById((int) $entityTypeId);
        $this->initializationHelper->initialize($entityType);

        $validationResult = $this->validationHelper->validate($entityType, $this->getRequest());

        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $result->setData($validationResult);

        return $result;
    }
}
