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

namespace Ainnomix\EtmAdminUi\Model\Entity\Attribute;

use Zend_Validate_Regex;

class CodeGenerator
{

    /**
     * @var \Magento\Catalog\Model\Product\Url
     */
    protected $url;

    public function __construct(\Magento\Catalog\Model\Product\Url $url)
    {
        $this->url = $url;
    }

    public function generate(string $value): string
    {
        $attributeCode = $this->url->formatUrlKey($value);
        $attributeCode = substr(
            preg_replace('/[^a-z_0-9]/', '_', $attributeCode),
            0,
            30
        );

        if (!$this->isCodeValid($attributeCode)) {
            $attributeCode = 'attr_' . ($attributeCode ?: substr(hash('sha1', time()), 0, 8));
        }

        return $attributeCode;
    }

    protected function isCodeValid(string $value): bool
    {
        $validatorAttrCode = new Zend_Validate_Regex(['pattern' => '/^[a-z][a-z_0-9]{0,29}[a-z0-9]$/']);

        return $validatorAttrCode->isValid($value);
    }
}
