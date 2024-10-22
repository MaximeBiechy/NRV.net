<?php

use nrv\application\actions\AddTicketToUserCardAction;
use nrv\application\actions\DisplayArtistsAction;
use nrv\application\actions\DisplayPartyAction;
use nrv\application\actions\DisplayPartyByShowAction;
use nrv\application\actions\DisplayPlaceAction;
use nrv\application\actions\DisplayPlacesAction;
use nrv\application\actions\DisplayShowAction;
use nrv\application\actions\DisplayShowsAction;
use nrv\application\actions\SigninAction;
use nrv\application\actions\SignupAction;
use nrv\application\provider\auth\JWTAuthProvider;
use nrv\core\repositoryInterfaces\AuthRepositoryInterface;
use nrv\core\repositoryInterfaces\PartyRepositoryInterface;

use nrv\core\repositoryInterfaces\PlaceRepositoryInterface;
use nrv\core\repositoryInterfaces\ShowRepositoryInterface;
use nrv\core\repositoryInterfaces\TicketRepositoryInterface;
use nrv\core\services\auth\AuthentificationService;
use nrv\core\services\auth\AuthentificationServiceInterface;
use nrv\core\services\place\PlaceService;
use nrv\core\services\place\PlaceServiceInterface;
use nrv\core\services\show\ShowService;
use nrv\core\services\show\ShowServiceInterface;
use nrv\core\services\party\PartyServiceInterface;
use nrv\core\services\party\PartyService;
use nrv\core\services\ticket\TicketService;
use nrv\core\services\ticket\TicketServiceInterface;
use nrv\infrastructure\db\PDOAuthRepository;
use nrv\infrastructure\db\PDOPartyRepository;
use nrv\infrastructure\db\PDOPlaceRepository;
use nrv\infrastructure\db\PDOShowRepository;
use nrv\infrastructure\db\PDOTicketRepository;
use Psr\Container\ContainerInterface;
return [
    'auth.pdo' => function (ContainerInterface $c) {
        $data = parse_ini_file($c->get('auth.ini'));
        $pdo_praticien = new PDO('pgsql:host=' . $data['host'] . ';dbname=' . $data['dbname'], $data['username'], $data['password']);
        $pdo_praticien->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo_praticien;
    },
    'show.pdo' => function (ContainerInterface $c) {
        $data = parse_ini_file($c->get('show.ini'));
        $pdo_praticien = new PDO('pgsql:host=' . $data['host'] . ';dbname=' . $data['dbname'], $data['username'], $data['password']);
        $pdo_praticien->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo_praticien;
    },
    'place.pdo' => function (ContainerInterface $c) {
        $data = parse_ini_file($c->get('place.ini'));
        $pdo_praticien = new PDO('pgsql:host=' . $data['host'] . ';dbname=' . $data['dbname'], $data['username'], $data['password']);
        $pdo_praticien->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo_praticien;
    },
    'party.pdo' => function (ContainerInterface $c) {
        $data = parse_ini_file($c->get('party.ini'));
        $pdo_praticien = new PDO('pgsql:host=' . $data['host'] . ';dbname=' . $data['dbname'], $data['username'], $data['password']);
        $pdo_praticien->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo_praticien;
    },
    'ticket.pdo' => function (ContainerInterface $c) {
        $data = parse_ini_file($c->get('ticket.ini'));
        $pdo_praticien = new PDO('pgsql:host=' . $data['host'] . ';dbname=' . $data['dbname'], $data['username'], $data['password']);
        $pdo_praticien->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo_praticien;
    },

    // Repositories
    PartyRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOPartyRepository($c->get('party.pdo'), $c->get('place.pdo'));
    },
    AuthRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOAuthRepository($c->get('auth.pdo'));
    },
    PlaceRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOPlaceRepository($c->get('place.pdo'));
    },
    ShowRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOShowRepository($c->get('show.pdo'), $c->get('place.pdo'), $c->get('party.pdo'));
    },
    TicketRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOTicketRepository($c->get('ticket.pdo'));
    },

    // Services
    AuthentificationServiceInterface::class => function (ContainerInterface $c) {
        return new AuthentificationService($c->get(AuthRepositoryInterface::class));
    },
    PlaceServiceInterface::class => function (ContainerInterface $c) {
        return new PlaceService($c->get(PlaceRepositoryInterface::class));
    },
    ShowServiceInterface::class => function (ContainerInterface $c) {
        return new ShowService($c->get(ShowRepositoryInterface::class));
    },
    PartyServiceInterface::class => function (ContainerInterface $c) {
        return new PartyService($c->get(PartyRepositoryInterface::class), $c->get(ShowRepositoryInterface::class));
    },
    TicketServiceInterface::class => function (ContainerInterface $c) {
        return new TicketService($c->get(TicketRepositoryInterface::class));
    },

    //Actions
    DisplayShowsAction::class => function (ContainerInterface $c) {
        return new DisplayShowsAction($c->get(ShowServiceInterface::class));
    },
    DisplayPartyAction::class => function (ContainerInterface $c) {
        return new DisplayPartyAction($c->get(PartyServiceInterface::class), $c->get(ShowServiceInterface::class));
    },
    DisplayPartyByShowAction::class => function (ContainerInterface $c) {
        return new DisplayPartyByShowAction($c->get(PartyServiceInterface::class));
    },
    DisplayShowAction::class => function (ContainerInterface $c) {
        return new DisplayShowAction($c->get(ShowServiceInterface::class));
    },
    SignupAction::class => function (ContainerInterface $c) {
        return new SignupAction($c->get(JWTAuthProvider::class));
    },
    SigninAction::class => function (ContainerInterface $c) {
        return new SigninAction($c->get(JWTAuthProvider::class));
    },
    DisplayArtistsAction::class => function (ContainerInterface $c) {
        return new DisplayArtistsAction($c->get(ShowServiceInterface::class));
    },
    DisplayPlaceAction::class => function (ContainerInterface $c) {
        return new DisplayPlaceAction($c->get(PlaceServiceInterface::class));
    },
    DisplayPlacesAction::class => function (ContainerInterface $c) {
        return new DisplayPlacesAction($c->get(PlaceServiceInterface::class));
    },
    AddTicketToUserCardAction::class => function (ContainerInterface $c) {
        return new AddTicketToUserCardAction($c->get(TicketServiceInterface::class));
    }
];
