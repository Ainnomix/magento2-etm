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

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml;

use Ainnomix\EtmAdminUi\Model\Acl\TypeResource\ProviderInterface;
use Ainnomix\EtmAdminUi\Model\Ui\EntityTypeProvider;

class Context
{

    /**
     * @var EntityTypeProvider
     */
    protected $entityTypeProvider;

    /**
     * @var ProviderInterface
     */
    protected $aclIdProvider;

    /**
     * Context constructor
     *
     * @param EntityTypeProvider $entityTypeProvider
     * @param ProviderInterface  $aclIdProvider
     */
    public function __construct(
        EntityTypeProvider $entityTypeProvider,
        ProviderInterface $aclIdProvider
    ) {
        $this->entityTypeProvider = $entityTypeProvider;
        $this->aclIdProvider = $aclIdProvider;
    }

    /**
     * Get entity type provider service
     *
     * @return EntityTypeProvider
     */
    public function getEntityTypeProvider(): EntityTypeProvider
    {
        return $this->entityTypeProvider;
    }

    /**
     * Get acl id provider service
     *
     * @return ProviderInterface
     */
    public function getAclIdProvider(): ProviderInterface
    {
        return $this->aclIdProvider;
    }
}
