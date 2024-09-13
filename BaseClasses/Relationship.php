<?php

use Exception;

/**
 * Abstract class representing a relationship between two nodes.
 */
abstract class Relationship extends Entity implements IRelationship
{
    /**
     * The incoming node of the relationship.
     * @var Node
     */
    protected $inNode;

    /**
     * The outgoing node of the relationship.
     * @var Node
     */
    protected $outNode;

    /**
     * Relationship constructor.
     *
     * @param Node|null $inNode
     * @param Node|null $outNode
     * @throws Exception
     */
    public function __construct($inNode = null, $outNode = null)
    {
        parent::__construct();

        if ($inNode !== null && $outNode !== null) {
            if (!$inNode instanceof Node) {
                throw new Exception('inNode must be an instance of Node');
            }
            if (!$outNode instanceof Node) {
                throw new Exception('outNode must be an instance of Node');
            }

            $this->inNode = $inNode;
            $this->outNode = $outNode;
        }
    }

    /**
     * Get the incoming node.
     *
     * @return Node
     */
    public function getInNode()
    {
        return $this->inNode;
    }

    /**
     * Set the incoming node.
     *
     * @param Node $inNode
     * @throws Exception
     */
    public function setInNode($inNode)
    {
        if (!$inNode instanceof Node) {
            throw new Exception('inNode must be an instance of Node');
        }
        $this->inNode = $inNode;
    }

    /**
     * Get the outgoing node.
     *
     * @return Node
     */
    public function getOutNode()
    {
        return $this->outNode;
    }

    /**
     * Set the outgoing node.
     *
     * @param Node $outNode
     * @throws Exception
     */
    public function setOutNode($outNode)
    {
        if (!$outNode instanceof Node) {
            throw new Exception('outNode must be an instance of Node');
        }
        $this->outNode = $outNode;
    }

    /**
     * Get the GUID of the incoming node.
     *
     * @return string
     */
    public function getInNodeId()
    {
        return $this->inNode ? $this->inNode->guid : null;
    }

    /**
     * Get the labels of the incoming node.
     *
     * @return array
     */
    public function getInNodeLabels()
    {
        return $this->inNode ? $this->inNode->labels : [];
    }

    /**
     * Get the GUID of the outgoing node.
     *
     * @return string
     */
    public function getOutNodeId()
    {
        return $this->outNode ? $this->outNode->guid : null;
    }

    /**
     * Get the labels of the outgoing node.
     *
     * @return array
     */
    public function getOutNodeLabels()
    {
        return $this->outNode ? $this->outNode->labels : [];
    }
}
