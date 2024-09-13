<?php

use DateTime;
use Exception;

abstract class Entity implements \Configure\Lib\Core\Interfaces\IEntity
{
    /**
     * Create a new instance of this entity
     */
    public function __construct()
    {
        // Constructor logic
    }

    /**
     * Timestamp of when this entity was archived.
     * @var DateTime
     */
    public $archivedDate;

    /**
     * Timestamp of when this entity was created.
     * @var DateTime
     */
    public $createdDate;

    /**
     * Unique identifier of this entity.
     * @var string
     */
    public $guid;

    /**
     * Unique identifier used as a partition key.
     * @var int
     */
    public $id;

    /**
     * Labels associated with the entity.
     * @var array
     */
    public $labels = [];

    /**
     * Timestamp of when this entity was last modified.
     * @var DateTime
     */
    public $modifiedDate;

    /**
     * Timestamp of the date last accessed.
     * @var DateTime
     */
    public $lastAccessed;

    /**
     * Check if this entity exists in the database.
     * @return bool
     */
    public function existsInDatabase()
    {
        return !empty($this->guid);
    }

    /**
     * Determine if the entity has been archived.
     * @return bool
     */
    public function isArchived()
    {
        if ($this->existsInDatabase()) {
            return $this->archivedDate > $this->createdDate;
        }
        return false;
    }

    /**
     * Determine if the entity is not archived.
     * @return bool
     */
    public function isNotArchived()
    {
        return !$this->isArchived();
    }

    /**
     * Create a shallow copy of the entity.
     * @return Entity
     */
    public function shallowCopy()
    {
        return clone $this;
    }

    /**
     * Override the Equals method to compare entities.
     * @param object $obj
     * @return bool
     */
    public function equals($obj)
    {
        if ($obj === null) {
            return false;
        }

        if ($obj instanceof Entity) {
            if ($obj->existsInDatabase()) {
                return $obj->guid === $this->guid;
            } else {
                return parent::equals($obj);
            }
        } else {
            return parent::equals($obj);
        }
    }

    /**
     * Override the GetHashCode method.
     * @return int
     */
    public function getHashCode()
    {
        return spl_object_hash($this);
    }

    /**
     * Override the ToString method to provide a string representation.
     * @return string
     */
    public function __toString()
    {
        try {
            $valueBuilder = [];

            if ($this->existsInDatabase()) {
                $valueBuilder[] = implode(",", $this->labels);
                $valueBuilder[] = "Guid: {$this->guid}";
            }

            if ($this->isArchived()) {
                $valueBuilder[] = "Is Archived";
            }

            $value = implode("; ", $valueBuilder);

            if (empty($value)) {
                return parent::__toString();
            }

            return $value;
        } catch (Exception $e) {
            return parent::__toString();
        }
    }
}
