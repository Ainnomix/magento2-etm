<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2020 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttributeSet;

use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context as BaseContext;
use Ainnomix\EtmAdminUi\Model\Acl\TypeResource\ProviderInterface;
use Ainnomix\EtmAdminUi\Model\Ui\EntityTypeProvider;

class Context extends BaseContext
{

    public function __construct(
        EntityTypeProvider $entityTypeProvider,
        ProviderInterface $aclIdProvider
    ) {
        parent::__construct($entityTypeProvider, $aclIdProvider);
    }
}
