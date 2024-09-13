<?php

abstract class Node extends Entity implements \Configure\Lib\Core\Interfaces\INode
{
    /**
     * URL of the image.
     * @var string
     */
    public $imageUrl = '';

    /**
     * Node constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}
