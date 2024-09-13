<?php

class Generics
{
    public static function create($repo, $item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        $createQuery = new CreateNode($item);
        $createQuery->runQuery($repo);
        return $createQuery->nodeToCreate;
    }

    public static function createMultiple($repo, array $items)
    {
        if (empty($items)) {
            throw new \InvalidArgumentException('Items cannot be empty');
        }

        $createQuery = new CreateNodes($items);
        return $createQuery->runQuery($repo);
    }

    public static function createRelationship($repo, $item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        $createQuery = new CreateRelationship($item);
        $createQuery->runQuery($repo);
        return $createQuery->relationship;
    }

    public static function createMultipleRelationships($repo, array $items)
    {
        if (empty($items)) {
            throw new \InvalidArgumentException('Items cannot be empty');
        }

        $createQuery = new CreateRelationships($items);
        return $createQuery->runQuery($repo);
    }

    public static function delete($repo, $item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        $deleteQuery = new DeleteNode($item);
        $deleteQuery->runQuery($repo);
    }

    public static function deleteMultiple($repo, array $items)
    {
        if (empty($items)) {
            throw new \InvalidArgumentException('Items cannot be empty');
        }

        $deleteQuery = new DeleteNodes($items);
        $deleteQuery->runQuery($repo);
    }

    public static function deleteRelationship($repo, $item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        $deleteQuery = new DeleteRelationship($item);
        $deleteQuery->runQuery($repo);
    }

    public static function get($repo, $itemId)
    {
        if (empty($itemId)) {
            return null;
        }

        $getQuery = new GetNode($itemId);
        return $getQuery->runQuery($repo);
    }

    public static function getByProperty($repo, $propertyName, $propertyValue)
    {
        $getQuery = new GetNode($propertyName, $propertyValue);
        return $getQuery->runQuery($repo);
    }

    public static function getAll($repo)
    {
        $getQuery = new GetNodes();
        return $getQuery->runQuery($repo);
    }

    public static function update($repo, $item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        $updateQuery = new UpdateNode($item);
        return $updateQuery->runQuery($repo);
    }

    public static function archive($repo, $item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        if (!isset($item->id)) {
            return $item;
        }

        $item->archivedDate = new \DateTime();
        $updateQuery = new UpdateNode($item);
        return $updateQuery->runQuery($repo);
    }

    public static function unarchive($repo, $item)
    {
        if ($item === null) {
            throw new \InvalidArgumentException('Item cannot be null');
        }

        if (!isset($item->id)) {
            return $item;
        }

        $item->archivedDate = null;
        $updateQuery = new UpdateNode($item);
        return $updateQuery->runQuery($repo);
    }

    public static function getAdjacent($repo, $origin)
    {
        $getQuery = new GetAdjacent($origin);
        return $getQuery->runQuery($repo);
    }

    public static function getAdjacentWithRelationships($repo, $origin)
    {
        $getQuery = new GetAdjacentWithRelationships($origin);
        return $getQuery->runQuery($repo);
    }

    public static function updateMultiple($repo, array $items)
    {
        if (empty($items)) {
            throw new \InvalidArgumentException('Items cannot be empty');
        }

        $updateQuery = new UpdateNodes($items);
        return $updateQuery->runQuery($repo);
    }
}