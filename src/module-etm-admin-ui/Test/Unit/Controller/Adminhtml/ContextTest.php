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

namespace Ainnomix\EtmAdminUi\Test\Unit\Controller\Adminhtml;

use Ainnomix\EtmAdminUi\Controller\Adminhtml\Context;
use Ainnomix\EtmAdminUi\Model\Acl\TypeResource\ProviderInterface;
use Ainnomix\EtmAdminUi\Model\Ui\EntityTypeProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ContextTest extends TestCase
{
    /**
     * @var EntityTypeProvider|MockObject
     */
    private $providerMock;

    /**
     * @var ProviderInterface|MockObject
     */
    private $aclIdProviderMock;

    /**
     * @var Context
     */
    private $context;

    protected function setUp(): void
    {
        $this->aclIdProviderMock = $this->getMockForAbstractClass(ProviderInterface::class);
        $this->providerMock = $this->getMockBuilder(EntityTypeProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->context = new class($this->providerMock, $this->aclIdProviderMock) extends Context {
        };
    }

    public function testGetEntityTypeProvider(): void
    {
        $this->assertEquals($this->providerMock, $this->context->getEntityTypeProvider());
    }

    public function testGetAclIdProvider(): void
    {
        $this->assertEquals($this->aclIdProviderMock, $this->context->getAclIdProvider());
    }
}
