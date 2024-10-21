<?php

use nrv\core\repositoryInterfaces\PartyRepositoryInterface;
use Psr\Container\ContainerInterface;

return [

    'pdo_party' => function (ContainerInterface $c) {
        $data = parse_ini_file($c->get('party.ini'));
        $pdo_party = new PDO('pgsql:host='.$data['host'].';dbname='.$data['dbname'], $data['username'], $data['password']);
        $pdo_party->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo_party;
    },

    // Repositories
    PartyRepositoryInterface::class => function (ContainerInterface $c) {
        return new \nrv\infrastructure\db\PDOPartyRepository($c->get('pdo_party'));
    }

];
