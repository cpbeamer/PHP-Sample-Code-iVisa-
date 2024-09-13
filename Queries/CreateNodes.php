<?php

use GraphAware\Neo4j\Client\ClientBuilder;

class CreateNodes
{
    private $nodesToCreate = [];
    private $query;

    public function __construct(array $nodesToCreate)
    {
        $this->nodesToCreate = $nodesToCreate;
        $this->createQuery();
    }

    public function getNodesToCreate()
    {
        return $this->nodesToCreate;
    }

    public function getQuery()
    {
        return $this->query;
    }

    private function createQuery()
    {
        $nodeLabel = $this->getGraphLabel();
        $nodeNames = [];
        $counter = 0;
        $onNewNode = true;

        $queryBuilder = '';

        foreach ($this->nodesToCreate as $item) {
            $nodeNames[] = 'n' . $counter;

            foreach (get_object_vars($item) as $property => $value) {
                // Skip properties based on the C# version
                if (in_array($property, ['Guid', 'CreatedDate', 'ArchivedDate', 'ModifiedDate'])) {
                    continue;
                }

                $propertyName = $this->sanitizePropertyName($property);
                $propertyValue = $this->sanitizePropertyValue($item, $property);

                if (empty($queryBuilder) || $onNewNode) {
                    $queryBuilder .= " CREATE ({$nodeNames[$counter]}:$nodeLabel {";
                    $queryBuilder .= "$propertyName:$propertyValue";
                    $onNewNode = false;
                } else {
                    $queryBuilder .= ", $propertyName:$propertyValue";
                }
            }

            $queryBuilder .= "})";
            $queryBuilder .= " SET";
            $queryBuilder .= " {$nodeNames[$counter]}.CreatedDate = timestamp()";
            $queryBuilder .= ", {$nodeNames[$counter]}.ModifiedDate = timestamp()";

            if (empty($item->Guid)) {
                $queryBuilder .= ", {$nodeNames[$counter]}.Guid = uuid()";
            } else {
                $queryBuilder .= ", {$nodeNames[$counter]}.Guid = '{$item->Guid}'";
            }

            $counter++;
            $onNewNode = true;
        }

        $queryBuilder .= " RETURN " . implode(', ', $nodeNames);
        $this->query = $queryBuilder;
    }

    private function getGraphLabel()
    {
        // Simulate getting the attribute like in C#
        return 'YourNodeLabel'; // Placeholder
    }

    private function sanitizePropertyName($property)
    {
        // Function to sanitize property name, similar to C# version
        return strtolower($property);
    }

    private function sanitizePropertyValue($item, $property)
    {
        // Function to sanitize the value of the property for a query
        return "'" . $item->$property . "'";
    }

    public function runQueryAsync($repo)
    {
        $client = ClientBuilder::create()
            ->addConnection('default', 'http://neo4j:password@localhost:7474') // Example connection
            ->build();

        $query = $this->getQuery();
        $result = $client->run($query);

        $retList = [];
        foreach ($result->records() as $record) {
            foreach ($this->nodesToCreate as $i => $node) {
                $retList[] = $this->populateNode($record->get("n$i"));
            }
        }

        $this->nodesToCreate = $retList;
        return $retList;
    }

    private function populateNode($neo4jNode)
    {
        // Populate the node object based on the result from Neo4j
        $node = new Node(); // Replace Node with your actual node class
        $node->setGuid($neo4jNode->value('Guid'));
        $node->setCreatedDate($neo4jNode->value('CreatedDate'));
        $node->setModifiedDate($neo4jNode->value('ModifiedDate'));
        // Map other properties as needed
        return $node;
    }
}