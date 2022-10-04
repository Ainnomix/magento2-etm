<?php
/**
 * This file is part of the Ainnomix Entity Type Manager package.
 *
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <roman@ainnomix.com>
 * @copyright 2022 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Setup\EntityTypeSetup;

use Ainnomix\EtmCore\Api\Data\EntityTypeInterface;
use Ainnomix\EtmCore\Setup\EntityTypeSetupInterface;
use Ainnomix\EtmCore\Setup\EtmSetup;

class AttributeSetGroupSetup implements EntityTypeSetupInterface
{

    /**
     * @var string
     */
    protected $defaultAttributeSetName = 'Default';

    /**
     * Class dependencies configuration
     *
     * @param EtmSetup $setup
     */
    public function __construct(
        protected EtmSetup $setup
    ) {
    }

    /**
     * @inheritDoc
     */
    public function install(EntityTypeInterface $entity): void
    {
        $this->setup->addAttributeSet($entity->getEntityTypeId(), $this->defaultAttributeSetName);
        $this->setup->setDefaultSetToEntityType($entity->getEntityTypeId(), $this->defaultAttributeSetName);
    }

    /**
     * @inheritDoc
     */
    public function uninstall(EntityTypeInterface $entity): void
    {
    }
}
