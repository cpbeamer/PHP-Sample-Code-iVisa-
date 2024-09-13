<?php

class GenericFunctionsService
{
    protected $repo;

    public function __construct($repo)
    {
        $this->repo = $repo;
    }

    public function create($item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        return Generics::create($this->repo, $item);
    }

    public function createMultiple(array $items)
    {
        if (empty($items)) {
            throw new \InvalidArgumentException('Items cannot be empty');
        }

        return Generics::createMultiple($this->repo, $items);
    }

    public function createRelationship($item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        return Generics::createRelationship($this->repo, $item);
    }

    public function delete($item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        Generics::delete($this->repo, $item);
    }

    public function deleteMultiple(array $items)
    {
        if (empty($items)) {
            throw new \InvalidArgumentException('Items cannot be empty');
        }

        Generics::deleteMultiple($this->repo, $items);
    }

    public function get($id)
    {
        if (empty($id)) {
            return null;
        }

        return Generics::get($this->repo, $id);
    }

    public function getByProperty($propertyName, $propertyValue)
    {
        return Generics::getByProperty($this->repo, $propertyName, $propertyValue);
    }

    public function getAll()
    {
        return Generics::getAll($this->repo);
    }

    public function update($item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        return Generics::update($this->repo, $item);
    }

    public function archive($item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        if (!isset($item->id)) {
            return $item;
        }

        $item->archivedDate = new \DateTime();
        return Generics::archive($this->repo, $item);
    }

    public function unarchive($item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        if (!isset($item->id)) {
            return $item;
        }

        $item->archivedDate = null;
        return Generics::unarchive($this->repo, $item);
    }

    public function getAdjacent($origin)
    {
        return Generics::getAdjacent($this->repo, $origin);
    }

    public function getAdjacentWithRelationships($origin)
    {
        return Generics::getAdjacentWithRelationships($this->repo, $origin);
    }

    public function updateMultiple(array $items)
    {
        if (empty($items)) {
            throw new \InvalidArgumentException('Items cannot be empty');
        }

        return Generics::updateMultiple($this->repo, $items);
    }
}
