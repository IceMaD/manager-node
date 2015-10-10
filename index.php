<?php

$loader = require __DIR__ . '/vendor/autoload.php';

use ManagerNode\Node;

// Creating Nodes
$root = new Node(10, 'form.identity');
$patrimony = new Node(20, 'form.patrimony');
$experience = new Node(30, 'form.experience');
$target = new Node(40, 'form.target');
$choice = new Node(50, 'form.identity_proof.choice');
$passeport = new Node(51, 'form.identity_proof.passeport'); // These two steps have equal priority, we'll let the user decide which one he want
$rectoId = new Node(51, 'form.identity_proof.identity-recto'); // These two steps have equal priority, we'll let the user decide which one he want
$versoId = new Node(52, 'form.identity_proof.identity-verso');
$domicile = new Node(60, 'form.justification.dom');
$signature = new Node(70, 'form.signature');

// Assembling nodes
$root->addChildren($patrimony);
$patrimony->addChildren($experience);
$experience->addChildren($target);
$target->addChildren($choice);
$choice->addChildren($passeport);
$choice->addChildren($rectoId);
$rectoId->addChildren($versoId);
$versoId->addChildren($domicile);
$passeport->addChildren($domicile);
$domicile->addChildren($signature);

// Mock the symfony validator
$root->setValidity(true);
$patrimony->setValidity(true);
$experience->setValidity(true);
$target->setValidity(true);
$choice->setValidity(true);

$passeport->setValidity(false);
$rectoId->setValidity(true);
$versoId->setValidity(true);
$domicile->setValidity(false);

$signature->setValidity(true);


// Go !
$best = $root->tryAccess($signature->prioritize());

var_dump($best->getName());
