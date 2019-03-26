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

namespace Ainnomix\EtmAdminhtml\Controller\Adminhtml\Entity\Type\Validation;

use Magento\Framework\App\RequestInterface;
use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;

/**
 * {{DESCRIPTION}}
 *
 * @category Ainnomix_EtmAdminhtml
 * @package  Ainnomix\EtmAdminhtml
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
class Helper
{

    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    private $dataObjectFactory;

    public function __construct(\Magento\Framework\DataObjectFactory $dataObjectFactory)
    {
        $this->dataObjectFactory = $dataObjectFactory;
    }

    public function validate(EntityTypeInterface $entityType, RequestInterface $request)
    {
        $result = $this->dataObjectFactory->create(['data' => ['error' => false, 'messages' => []]]);

        return $result;
    }
}
