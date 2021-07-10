<?php
/*
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2021 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Model\EntityType\Command\Save;

use InvalidArgumentException;

class OperationPool
{

    private $operations = [];

    public function __construct(array $operations = [])
    {
        $this->operations = $operations;
    }

    public function getOperation(string $operationName): OperationInterface
    {
        if (isset($this->operations[$operationName])) {
            return $this->operations[$operationName];
        }

        throw new InvalidArgumentException('There is no such operation declared');
    }
}
