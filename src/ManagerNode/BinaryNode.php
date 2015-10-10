<?php

namespace ManagerNode;

class BinaryNode extends Node
{
    private $invalidName;

    public function __construct($priority, $validName, $invalidName)
    {
        parent::__construct($priority, $validName);

        $this->invalidName = $invalidName;
    }

    public function getName()
    {
        return $this->isValid ? $this->name : $this->invalidName;
    }
}
