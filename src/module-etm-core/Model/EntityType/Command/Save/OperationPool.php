<?php

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
