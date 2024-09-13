<?php

use Exception;

class CreateRelationship
{
    private $relationship;
    private $inNodeName = 'n';
    private $outNodeName = 'o';
    private $relationshipName = 'r';
    private $query;

    public function __construct($relationship, $inNodeName = null, $outNodeName = null, $relationshipName = null)
    {
        $this->relationship = $relationship;

        if ($inNodeName) {
            $this->inNodeName = $inNodeName;
        }
        if ($outNodeName) {
            $this->outNodeName = $outNodeName;
        }
        if ($relationshipName) {
            $this->relationshipName = $relationshipName;
        }

        $this->createQuery();
    }

    private function createQuery()
    {
        if (!$this->relationship) {
            throw new Exception("Relationship is null");
        } elseif (!$this->relationship->getInNode()) {
            throw new Exception("InNode is null");
        } elseif (!$this->relationship->getOutNode()) {
            throw new Exception("OutNode is null");
        }

        $relationshipProperties = $this->getRelationshipProperties();
        $inNodeLabel = $this->getGraphLabel(get_class($this->relationship->getInNode()));
        $outNodeLabel = $this->getGraphLabel(get_class($this->relationship->getOutNode()));
        $relationshipLabel = $this->getGraphLabel(get_class($this->relationship));

        $outNode = $this->relationship->getOutNode();
        $inNode = $this->relationship->getInNode();

        $queryBuilder = "MATCH ({$this->outNodeName}:{$outNodeLabel->getName()} {Guid: '{$outNode->getGuid()}'})";
        $queryBuilder .= ", ({$this->inNodeName}:{$inNodeLabel->getName()} {Guid: '{$inNode->getGuid()}'})";
        $queryBuilder .= " CREATE ({$this->outNodeName})-[{$this->relationshipName}:{$relationshipLabel->getName()}";

        if ($relationshipProperties && count($relationshipProperties) > 0) {
            $queryBuilder .= " {";

            $properties = [];
            foreach ($relationshipProperties as $propertyName => $propertyValue) {
                $properties[] = "{$this->sanitizePropertyName($propertyName)}: '{$propertyValue}'";
            }

            $queryBuilder .= implode(", ", $properties);
            $queryBuilder .= "}";
        }

        $queryBuilder .= "]->({$this->inNodeName})";
        $queryBuilder .= " SET {$this->relationshipName}.CreatedDate = timestamp(), {$this->relationshipName}.ModifiedDate = timestamp()";

        if ($this->relationship->getGuid() === null) {
            $queryBuilder .= ", {$this->relationshipName}.Guid = uuid()";
        } else {
            $queryBuilder .= ", {$this->relationshipName}.Guid = '{$this->relationship->getGuid()}'";
        }

        $queryBuilder .= " RETURN {$this->outNodeName}, {$this->relationshipName}, {$this->inNodeName}";

        $this->query = $queryBuilder;
    }

    public function runQueryAsync($repo)
    {
        $client = ClientBuilder::create()
            ->addConnection('default', 'http://neo4j:password@localhost:7474') // Modify connection string accordingly
            ->build();

        $result = $client->run($this->query);
        return $this->parseResult($result);
    }

    private function parseResult($result)
    {
        foreach ($result->records() as $record) {
            $this->relationship = $this->populateRelationship($record->get('r'));
            $this->relationship->setOutNode($this->populateNode($record->get('o')));
            $this->relationship->setInNode($this->populateNode($record->get('n')));
        }

        return $this->relationship;
    }

    private function getRelationshipProperties()
    {
        // This is a placeholder function that would return relationship properties based on your logic.
        return [];
    }

    private function getGraphLabel($type)
    {
        // This function retrieves the GraphLabel attribute from the type. Adjust this logic based on your implementation.
        return new GraphLabel();
    }

    private function sanitizePropertyName($name)
    {
        // Implement sanitization logic here
        return $name;
    }

    private function populateRelationship($relationshipData)
    {
        // Populate relationship object from Neo4j data
        return new Relationship();
    }

    private function populateNode($nodeData)
    {
        // Populate node object from Neo4j data
        return new Node();
    }
}
