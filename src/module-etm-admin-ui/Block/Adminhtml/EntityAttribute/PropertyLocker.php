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

namespace Ainnomix\EtmAdminUi\Block\Adminhtml\EntityAttribute;

use Ainnomix\EtmAdminUi\Ui\Resolver\Attribute as AttributeResolver;
use Magento\Eav\Model\Entity\Attribute\Config;
use Magento\Framework\Data\Form;

class PropertyLocker
{

    /**
     * @var Config
     */
    protected $attributeConfig;

    /**
     * @var AttributeResolver
     */
    protected $attributeResolver;

    public function __construct(Config $attributeConfig, AttributeResolver $attributeResolver)
    {
        $this->attributeConfig = $attributeConfig;
        $this->attributeResolver = $attributeResolver;
    }

    public function lock(Form $form): void
    {
        $attributeObject = $this->attributeResolver->get();
        if ($attributeObject->getId()) {
            foreach ($this->attributeConfig->getLockedFields($attributeObject) as $field) {
                if ($element = $form->getElement($field)) {
                    $element->setDisabled(1);
                    $element->setReadonly(1);
                }
            }
        }
    }
}
