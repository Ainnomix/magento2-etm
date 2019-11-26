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

    /**
     * Retrieve entity type ID
     *
     * @return int|null
     */
    public function getEntityTypeId(): ?int;

    /**
     * Set entity type ID
     *
     * @param int $typeId
     *
     * @return void
     */
    public function setEntityTypeId(int $typeId): void;

    /**
     * Retrieve entity type code
     *
     * @return string|null
     */
    public function getEntityTypeCode(): ?string;

    /**
     * Set entity type code
     *
     * @param string $code
     *
     * @return void
     */
    public function setEntityTypeCode(string $code): void;

    /**
     * Retrieve entity type name
     *
     * @return string|null
     */
    public function getEntityTypeName(): ?string;

    /**
     * Set entity type name
     *
     * @param string $name
     *
     * @return void
     */
    public function setEntityTypeName(string $name): void;
}
