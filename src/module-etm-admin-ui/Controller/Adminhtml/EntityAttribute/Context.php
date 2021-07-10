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

namespace Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityAttribute;

use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context as BaseContext;
use Ainnomix\EtmAdminUi\Ui\Resolver\Attribute as AttributeResolver;
use Ainnomix\EtmCore\Api\AttributeRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeInterfaceFactory;
use Ainnomix\EtmAdminUi\Model\Acl\TypeResource\ProviderInterface;
use Ainnomix\EtmAdminUi\Model\Ui\EntityTypeProvider;

class Context extends BaseContext
{

    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * @var AttributeInterfaceFactory
     */
    protected $attributeFactory;

    /**
     * @var AttributeResolver
     */
    protected $attributeResolver;

    /**
     * Context constructor
     *
     * @param EntityTypeProvider           $entityTypeProvider
     * @param ProviderInterface            $aclIdProvider
     * @param AttributeRepositoryInterface $attributeRepository
     * @param AttributeInterfaceFactory    $attributeFactory
     * @param AttributeResolver            $attributeResolver
     */
    public function __construct(
        EntityTypeProvider $entityTypeProvider,
        ProviderInterface $aclIdProvider,
        AttributeRepositoryInterface $attributeRepository,
        AttributeInterfaceFactory $attributeFactory,
        AttributeResolver $attributeResolver
    ) {
        parent::__construct($entityTypeProvider, $aclIdProvider);

        $this->attributeRepository = $attributeRepository;
        $this->attributeFactory = $attributeFactory;
        $this->attributeResolver = $attributeResolver;
    }

    /**
     * @return AttributeRepositoryInterface
     */
    public function getAttributeRepository(): AttributeRepositoryInterface
    {
        return $this->attributeRepository;
    }

    /**
     * @return AttributeInterfaceFactory
     */
    public function getAttributeFactory(): AttributeInterfaceFactory
    {
        return $this->attributeFactory;
    }

    /**
     * @return AttributeResolver
     */
    public function getAttributeResolver(): AttributeResolver
    {
        return $this->attributeResolver;
    }
}
