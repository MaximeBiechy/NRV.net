<?php
declare(strict_types=1);


require_once __DIR__ . '/../vendor/autoload.php';

/* application boostrap */
$appli = require_once __DIR__ . '/../config/bootstrap.php';

// Constantes d'opérations
const UPDATABLE = 0;
const VALIDATE_CART = 1;
const VALIDATE_COMMAND = 2;
const PAYED = 3;
const ADD_TICKET_TO_CART = 4;
const CREATE_SHOW = 5;
const CREATE_PARTY = 6;
const CREATE_PLACE = 7;
const CREATE_TICKET = 8;
const CONSULTING_CART = 9;
const CONSULTING_SOLD_TICKET = 10;

// USERS ROLES
const USER = 0;
const ADMIN = 10;
const SUPER_ADMIN = 100;

$appli->run();
