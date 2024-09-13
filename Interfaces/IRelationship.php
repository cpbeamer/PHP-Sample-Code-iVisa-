<?php

/**
 * Interface IRelationship
 * Extends IEntity
 */
interface IRelationship extends IEntity
{
    /**
     * Get the InNodeId.
     *
     * @return string
     */
    public function getInNodeId(): string;

    /**
     * Get the InNodeLabels.
     *
     * @return array
     */
    public function getInNodeLabels(): array;

    /**
     * Get the OutNodeId.
     *
     * @return string
     */
    public function getOutNodeId(): string;

    /**
     * Get the OutNodeLabels.
     *
     * @return array
     */
    public function getOutNodeLabels(): array;
}

/**
 * Interface IRelationshipWithNodes
 * Extends IRelationship
 */
interface IRelationshipWithNodes extends IRelationship
{
    /**
     * Get the InNode.
     *
     * @return Node
     */
    public function getInNode(): Node;

    /**
     * Set the InNode.
     *
     * @param Node $inNode
     */
    public function setInNode(Node $inNode): void;

    /**
     * Get the OutNode.
     *
     * @return Node
     */
    public function getOutNode(): Node;

    /**
     * Set the OutNode.
     *
     * @param Node $outNode
     */
    public function setOutNode(Node $outNode): void;
}
