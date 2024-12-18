<?php

use nrv\application\actions\AddTicketToUserCartAction;
use nrv\application\actions\CreatePartyAction;
use nrv\application\actions\CreateShowAction;
use nrv\application\actions\DisplayArtistAction;
use nrv\application\actions\DisplayArtistsAction;
use nrv\application\actions\DisplayCartAction;
use nrv\application\actions\DisplayPartiesAction;
use nrv\application\actions\DisplayPartyAction;
use nrv\application\actions\DisplayPartyByShowAction;
use nrv\application\actions\DisplayPartyGaugeAction;
use nrv\application\actions\DisplayPlaceAction;
use nrv\application\actions\DisplayPlacesAction;
use nrv\application\actions\DisplayShowAction;
use nrv\application\actions\DisplayShowsAction;
use nrv\application\actions\DisplaySoldTicketsByUserAction;
use nrv\application\actions\DisplaySpectatorGaugeAction;
use nrv\application\actions\DisplayStylesAction;
use nrv\application\actions\DisplayTicketAction;
use nrv\application\actions\DisplayTicketsAction;
use nrv\application\actions\DisplayTicketsByPartyAction;
use nrv\application\actions\RefreshTokenAction;
use nrv\application\actions\SigninAction;
use nrv\application\actions\SignupAction;
use nrv\application\actions\UpdateCartAction;
use nrv\application\actions\UpdatePlaceAction;
use nrv\application\middlewares\Auth;
use nrv\application\provider\auth\AuthProviderInterface;
use nrv\application\provider\auth\JWTAuthProvider;
use nrv\application\provider\auth\JWTManager;
use nrv\core\repositoryInterfaces\AuthRepositoryInterface;
use nrv\core\repositoryInterfaces\PartyRepositoryInterface;

use nrv\core\repositoryInterfaces\PlaceRepositoryInterface;
use nrv\core\repositoryInterfaces\ShowRepositoryInterface;
use nrv\core\repositoryInterfaces\TicketRepositoryInterface;
use nrv\core\services\auth\AuthentificationService;
use nrv\core\services\auth\AuthentificationServiceInterface;
use nrv\core\services\party\AuthzPartyService;
use nrv\core\services\party\AuthzPartyServiceInterface;
use nrv\core\services\place\AuthzPlaceService;
use nrv\core\services\place\AuthzPlaceServiceInterface;
use nrv\core\services\place\PlaceService;
use nrv\core\services\place\PlaceServiceInterface;
use nrv\core\services\show\AuthzShowService;
use nrv\core\services\show\AuthzShowServiceInterface;
use nrv\core\services\show\ShowService;
use nrv\core\services\show\ShowServiceInterface;
use nrv\core\services\party\PartyServiceInterface;
use nrv\core\services\party\PartyService;
use nrv\core\services\ticket\AuthzTicketService;
use nrv\core\services\ticket\AuthzTicketServiceInterface;
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
        return new AuthentificationService($c->get(AuthRepositoryInterface::class), $c->get(TicketRepositoryInterface::class));
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
    AuthzPartyServiceInterface::class => function (ContainerInterface $c) {
        return new AuthzPartyService($c->get(PartyRepositoryInterface::class), $c->get(AuthRepositoryInterface::class));
    },
    AuthzPlaceServiceInterface::class => function (ContainerInterface $c) {
        return new AuthzPlaceService($c->get(PlaceRepositoryInterface::class), $c->get(AuthRepositoryInterface::class));
    },
    AuthzShowServiceInterface::class => function (ContainerInterface $c) {
        return new AuthzShowService($c->get(ShowRepositoryInterface::class), $c->get(AuthRepositoryInterface::class));
    },
    AuthzTicketServiceInterface::class => function (ContainerInterface $c) {
        return new AuthzTicketService($c->get(TicketRepositoryInterface::class), $c->get(AuthRepositoryInterface::class));
    },
    AuthProviderInterface::class => function (ContainerInterface $c) {
        return new JWTAuthProvider($c->get(AuthentificationServiceInterface::class), $c->get(JWTManager::class));
    },
    JWTManager::class => function (ContainerInterface $c) {
        return new JWTManager();
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
    AddTicketToUserCartAction::class => function (ContainerInterface $c) {
        return new AddTicketToUserCartAction($c->get(TicketServiceInterface::class));
    },
    DisplayCartAction::class => function (ContainerInterface $c) {
        return new DisplayCartAction($c->get(TicketServiceInterface::class), $c->get(AuthentificationServiceInterface::class));
    },
    UpdateCartAction::class => function (ContainerInterface $c) {
        return new UpdateCartAction($c->get(TicketServiceInterface::class));
    },
    DisplaySpectatorGaugeAction::class => function (ContainerInterface $c) {
        return new DisplaySpectatorGaugeAction($c->get(PartyServiceInterface::class), $c->get(TicketServiceInterface::class));
    },
    DisplaySoldTicketsByUserAction::class => function (ContainerInterface $c) {
        return new DisplaySoldTicketsByUserAction($c->get(TicketServiceInterface::class), $c->get(AuthentificationServiceInterface::class));
    },
    DisplayArtistAction::class => function (ContainerInterface $c) {
        return new DisplayArtistAction($c->get(ShowServiceInterface::class));
    },
    DisplayStylesAction::class => function (ContainerInterface $c) {
        return new DisplayStylesAction($c->get(ShowServiceInterface::class));
    },
    DisplayTicketsAction::class => function (ContainerInterface $c) {
        return new DisplayTicketsAction($c->get(TicketServiceInterface::class));
    },
    DisplayTicketAction::class => function (ContainerInterface $c) {
        return new DisplayTicketAction($c->get(TicketServiceInterface::class));
    },
    CreateShowAction::class => function (ContainerInterface $c) {
        return new CreateShowAction($c->get(ShowServiceInterface::class));
    },
    DisplayPartiesAction::class => function (ContainerInterface $c) {
        return new DisplayPartiesAction($c->get(PartyServiceInterface::class), $c->get(ShowServiceInterface::class));
    },
    CreatePartyAction::class => function (ContainerInterface $c) {
        return new CreatePartyAction($c->get(PartyServiceInterface::class), $c->get(PlaceServiceInterface::class));
    },
    Auth::class => function (ContainerInterface $c) {
        return new Auth($c->get(AuthProviderInterface::class));
    },
    UpdatePlaceAction::class => function (ContainerInterface $c) {
        return new UpdatePlaceAction($c->get(PlaceServiceInterface::class));
    },
    DisplayTicketsByPartyAction::class => function (ContainerInterface $c) {
        return new DisplayTicketsByPartyAction($c->get(TicketServiceInterface::class), $c->get(PartyServiceInterface::class));
    },
    DisplayPartyGaugeAction::class => function (ContainerInterface $c) {
        return new DisplayPartyGaugeAction($c->get(PartyServiceInterface::class), $c->get(TicketServiceInterface::class));
    },
    RefreshTokenAction::class => function (ContainerInterface $c) {
        return new RefreshTokenAction($c->get(AuthProviderInterface::class));
    },
];