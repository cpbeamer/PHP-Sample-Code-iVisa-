<?php

use DateTime;

class Entity implements IEntity
{
    private $guid;
    private $id;
    private $labels = [];
    private $createdDate;
    private $modifiedDate;
    private $archivedDate;

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function setGuid(string $guid): void
    {
        $this->guid = $guid;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function setLabels(array $labels): void
    {
        $this->labels = $labels;
    }

    public function getCreatedDate(): DateTime
    {
        return $this->createdDate;
    }

    public function setCreatedDate(DateTime $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    public function getModifiedDate(): DateTime
    {
        return $this->modifiedDate;
    }

    public function setModifiedDate(DateTime $modifiedDate): void
    {
        $this->modifiedDate = $modifiedDate;
    }

    public function getArchivedDate(): DateTime
    {
        return $this->archivedDate;
    }

    public function setArchivedDate(DateTime $archivedDate): void
    {
        $this->archivedDate = $archivedDate;
    }
}
