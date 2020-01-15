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

namespace Ainnomix\EtmAdminUi\Model\Acl\TypeResource;

class Context
{

    /**
     * @var MainIdProvider
     */
    private $mainIdProvider;

    /**
     * @var EntityIdProvider
     */
    private $entityIdProvider;

    /**
     * @var AttributeIdProvider
     */
    private $attributeIdProvider;

    /**
     * @var AttributeSetIdProvider
     */
    private $attributeSetIdProvider;

    /**
     * Context constructor
     *
     * @param MainIdProvider         $mainIdProvider
     * @param EntityIdProvider       $entityIdProvider
     * @param AttributeIdProvider    $attributeIdProvider
     * @param AttributeSetIdProvider $attributeSetIdProvider
     */
    public function __construct(
        MainIdProvider $mainIdProvider,
        EntityIdProvider $entityIdProvider,
        AttributeIdProvider $attributeIdProvider,
        AttributeSetIdProvider $attributeSetIdProvider
    ) {
        $this->mainIdProvider = $mainIdProvider;
        $this->entityIdProvider = $entityIdProvider;
        $this->attributeIdProvider = $attributeIdProvider;
        $this->attributeSetIdProvider = $attributeSetIdProvider;
    }

    /**
     * @return MainIdProvider
     */
    public function getMainIdProvider(): MainIdProvider
    {
        return $this->mainIdProvider;
    }

    /**
     * @return EntityIdProvider
     */
    public function getEntityIdProvider(): EntityIdProvider
    {
        return $this->entityIdProvider;
    }

    /**
     * @return AttributeIdProvider
     */
    public function getAttributeIdProvider(): AttributeIdProvider
    {
        return $this->attributeIdProvider;
    }

    /**
     * @return AttributeSetIdProvider
     */
    public function getAttributeSetIdProvider(): AttributeSetIdProvider
    {
        return $this->attributeSetIdProvider;
    }
}
