<?php

namespace ManagerNode;

class Node
{
    /**
     * @var Integer
     */
    protected $priority;

    /**
     * @var Node[]
     */
    protected $children = [];

    /**
     * Mock the symfony validator
     *
     * @var Boolean
     */
    protected $isValid = true;

    /**
     * @var String
     */
    protected $name;

    public function __construct($priority, $name)
    {
        $this->priority = $priority;
        $this->name = $name;
    }

    /**
     * best result passing by this node
     *
     * @param Node $targetNode
     * @return Node
     */
    public function tryAccess(Node $targetNode)
    {
        /**
         * I can not or I do not want to go further
         */
        if (!$this->validate() || $this === $targetNode || empty($this->children)) {
            return $this;
        }

        /**
         * I try to guess where I can go
         */
        $scores = [];
        foreach ($this->children as $node) {
            $resultNode = $node->tryAccess($targetNode);
            $resultNodePriority = $resultNode->getPriority();

            /**
             * I have multiple pathes with same priority, I'll let the user choose
             */
            if (isset($scores[$resultNodePriority])) {
                return $this;
            }

            $scores[$resultNodePriority] = $resultNode;
        }

        /**
         * Return the highest score
         */
        return end($scores);
    }

    /**
     * Prioritize a step to force access to this even if another one have a bigger
     * This method allow to come back in an already validated node
     *
     * @return $this
     */
    public function prioritize()
    {
        $this->priority = $this->priority * 100;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param Node $node
     * @return $this
     */
    public function addChildren(Node $node)
    {
        $this->children[] = $node;

        return $this;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Mock the symfony validator
     *
     * @param $isValid
     * @return $this
     */
    public function setValidity($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * Mock the symfony validator
     *
     * @return bool
     */
    private function validate()
    {
        return $this->isValid;
    }
}
