<?php
/**
 * Do not edit or add to this file if you wish to upgrade Entity Type Manager to newer
 * versions in the future.
 *
 * @category  Ainnomix
 * @package   Ainnomix\EtmCore
 * @author    Roman Tomchak <romantomchak@gmail.com>
 * @copyright 2019 Ainnomix
 * @license   Open Software License ("OSL") v. 3.0
 */

declare(strict_types=1);

namespace Ainnomix\EtmCore\Api\Data;

/**
 * Entity type model interface
 *
 * @category Ainnomix_Etm
 * @package  Ainnomix\EtmCore
 * @author   Roman Tomchak <romantomchak@gmail.com>
 */
interface EntityTypeInterface
{

    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_TYPE_ID = 'entity_type_id';
    const ENTITY_TYPE_CODE = 'entity_type_code';
    const ENTITY_TYPE_NAME = 'entity_type_name';

    public function getEntityTypeId(): ?int;

    public function setEntityTypeId(int $typeId): void;

    public function getEntityTypeCode(): ?string;

    public function setEntityTypeCode(string $code): void;

    public function getEntityTypeName(): ?string;

    public function setEntityTypeName(string $name): void;
}
