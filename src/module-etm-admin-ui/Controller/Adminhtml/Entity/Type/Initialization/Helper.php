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

namespace Ainnomix\EtmAdminhtml\Controller\Adminhtml\Entity\Type\Initialization;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Magento\Framework\App\RequestInterface;


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
     * @var RequestInterface
     */
    private $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function initialize(EntityTypeInterface $entityType) : EntityTypeInterface
    {
        $entityData = (array) $this->request->getPost() ?? [];
        return $this->initializeFromData($entityType, $entityData);
    }

    public function initializeFromData(EntityTypeInterface $entityType, array $entityData)
    {
        $entityType->addData($entityData);

        return $entityType;
    }
}
