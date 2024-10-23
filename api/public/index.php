<?php
declare(strict_types=1);


require_once __DIR__ . '/../vendor/autoload.php';

/* application boostrap */
$appli = require_once __DIR__ . '/../config/bootstrap.php';

// Constantes d'opérations
const VALIDATE_CART = 1;
const VALIDATE_COMMAND = 2;
const PAYED = 3;

$appli->run();
