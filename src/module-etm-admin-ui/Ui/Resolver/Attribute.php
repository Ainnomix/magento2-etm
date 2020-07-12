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

namespace Ainnomix\EtmAdminUi\Ui\Resolver;

use Ainnomix\EtmCore\Api\AttributeRepositoryInterface;
use Ainnomix\EtmCore\Api\Data\AttributeInterface;
use Magento\Framework\App\RequestInterface;

class Attribute
{

    const DEFAULT_REQUEST_PARAM = 'id';

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var string
     */
    private $requestParamName;

    /**
     * @var AttributeInterface
     */
    private $attribute;

    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        RequestInterface $request,
        string $requestParamName = self::DEFAULT_REQUEST_PARAM
    ) {

        $this->attributeRepository = $attributeRepository;
        $this->request = $request;
        $this->requestParamName = $requestParamName;
    }

    public function get(): AttributeInterface
    {
        if (!$this->attribute) {
            $attributeId = (int) $this->request->getParam($this->requestParamName);
            $this->attribute = $this->attributeRepository->get($attributeId);
        }

        return $this->attribute;
    }

    public function set(AttributeInterface $attribute): void
    {
        $this->attribute = $attribute;
    }
}
