<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmAdminUi
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmAdminUi\Observer;

use Magento\Backend\Block\Menu;
use Magento\Backend\Model\Menu\Config;
use Magento\Framework\Acl\AclResource\Provider;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class FlushMenuCacheObserver implements ObserverInterface
{

    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function execute(Observer $observer)
    {
        $this->cache->clean([Menu::CACHE_TAGS]);
        $this->cache->remove(Config::CACHE_MENU_OBJECT);
        $this->cache->remove(Provider::ACL_RESOURCES_CACHE_KEY);
    }
}
