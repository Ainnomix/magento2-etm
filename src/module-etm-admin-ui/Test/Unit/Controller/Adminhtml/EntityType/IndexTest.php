<?php
/*
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

namespace Ainnomix\EtmAdminUi\Test\Unit\Controller\Adminhtml\EntityType;

use Ainnomix\EtmAdminUi\Controller\Adminhtml\EntityType\Index;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Page\Title;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Result\Page;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{

    /**
     * @var MockObject|ResultFactory
     */
    private $resultFactoryMock;

    /**
     * @var Index
     */
    private $action;

    protected function setUp(): void
    {
        $contextMock = $this->getMockBuilder(Context::class)
            ->setMethods(
                [
                    'getAuthorization',
                    'getAuth',
                    'getHelper',
                    'getBackendUrl',
                    'getFormKeyValidator',
                    'getLocaleResolver',
                    'getCanUseBaseUrl',
                    'getSession',
                    'getObjectManager',
                    'getEventManager',
                    'getUrl',
                    'getActionFlag',
                    'getRedirect',
                    'getView',
                    'getMessageManager',
                    'getRequest',
                    'getResponse',
                    'getResultRedirectFactory',
                    'getResultFactory'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultFactoryMock = $this->getMockBuilder(ResultFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $contextMock->expects($this->once())
            ->method('getResultFactory')
            ->willReturn($this->resultFactoryMock);

        $this->action = new Index($contextMock);
    }

    public function testExecute(): void
    {
        $pageMock = $this->getMockBuilder(Page::class)
            ->disableOriginalConstructor()
            ->setMethods(['setActiveMenu', 'getConfig'])
            ->getMock();

        $this->resultFactoryMock->expects($this->once())
            ->method('create')
            ->with(ResultFactory::TYPE_PAGE)
            ->willReturn($pageMock);

        $pageMock->expects($this->once())
            ->method('setActiveMenu')
            ->with('Ainnomix_EtmAdminUi::management_index');

        $configMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->setMethods(['getTitle'])
            ->getMock();
        $titleMock = $this->getMockBuilder(Title::class)
            ->disableOriginalConstructor()
            ->setMethods(['prepend'])
            ->getMock();

        $pageMock->expects($this->atLeast(2))
            ->method('getConfig')
            ->willReturn($configMock);
        $configMock->expects($this->atLeast(2))
            ->method('getTitle')
            ->willReturn($titleMock);
        $titleMock->expects($this->at(0))
            ->method('prepend')
            ->with(__('Entity Type Manager'));
        $titleMock->expects($this->at(1))
            ->method('prepend')
            ->with(__('Manage Entity Types'));

        $resultPage = $this->action->execute();
        $this->assertInstanceOf(Page::class, $resultPage);
    }
}
