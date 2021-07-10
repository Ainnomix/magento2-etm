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

namespace Ainnomix\EtmAdminUi\Ui\Component\Form\EntityAttribute\Element;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Form\Element\Input;

class Labels extends Input
{

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        ContextInterface $context,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $components, $data);

        $this->storeManager = $storeManager;
    }

    public function prepare()
    {
        $config = $this->getData('config');

        foreach ($this->storeManager->getStores() as $store) {
            $config['storeOptions'][] = ['value' => $store->getId(), 'label' => $store->getName()];
        }

        $this->setData('config', $config);

        parent::prepare();
    }
}
