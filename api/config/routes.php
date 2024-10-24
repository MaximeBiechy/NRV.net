<?php
declare(strict_types=1);


use nrv\application\actions\AddTicketToUserCartAction;
use nrv\application\actions\CreateShowAction;
use nrv\application\actions\DisplayArtistAction;
use nrv\application\actions\DisplayArtistsAction;
use nrv\application\actions\DisplayPartiesAction;
use nrv\application\actions\DisplaySoldTicketsByUserAction;
use nrv\application\actions\DisplayCartAction;
use nrv\application\actions\DisplayPartyAction;
use nrv\application\actions\DisplayPartyByShowAction;
use nrv\application\actions\DisplayPlaceAction;
use nrv\application\actions\DisplayPlacesAction;
use nrv\application\actions\DisplaySpectatorGaugeAction;
use nrv\application\actions\DisplayStylesAction;
use nrv\application\actions\DisplayTicketAction;
use nrv\application\actions\DisplayTicketsAction;
use nrv\application\actions\SigninAction;
use nrv\application\actions\SignupAction;
use nrv\application\actions\UpdateCartAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use nrv\application\actions\DisplayShowAction;
use nrv\application\actions\DisplayShowsAction;

return function(\Slim\App $app):\Slim\App {


    $app->options('/{routes:.+}', function (Request $rq, Response $rs, array $args): Response {
        return $rs;
    });

    // Programme du festival
    $app->get('/shows[/]', DisplayShowsAction::class)->setName('shows');
    $app->get('/shows/{ID-SHOW}[/]', DisplayShowAction::class)->setName('shows_id');
    $app->get('/shows/{ID-SHOW}/party[/]', DisplayPartyByShowAction::class)->setName('shows_id_party');
    $app->post('/shows[/]', CreateShowAction::class)->setName('create_show');

    $app->get('/parties[/]', DisplayPartiesAction::class)->setName('parties');
    $app->get('/parties/gauge[/]', DisplaySpectatorGaugeAction::class)->setName('parties_gauge');
    $app->get('/parties/{ID-PARTY}[/]', DisplayPartyAction::class)->setName('parties_id');

    // Compte et profil d'utilisateur
    $app->post('/signup[/]', SignupAction::class)->setName('signup');
    $app->post('/signin[/]', SigninAction::class)->setName('signin');

    // Artistes
    $app->get('/artists[/]', DisplayArtistsAction::class)->setName('artists');
    $app->get('/artists/{ID-ARTIST}[/]', DisplayArtistAction::class)->setName('artists_id');

    // Places
    $app->get('/places[/]', DisplayPlacesAction::class)->setName('places');
    $app->get('/places/{ID-PLACE}[/]', DisplayPlaceAction::class)->setName('places_id');

    // Tickets
    $app->patch('/carts/{ID-CART}/ticket[/]', AddTicketToUserCartAction::class)->setName('carts_id');
    $app->patch('/carts/{ID-CART}[/]', UpdateCartAction::class)->setName('update_card_id');

    $app->get('/users/{ID-USER}/cart[/]', DisplayCartAction::class)->setName('users_id_cart');
    $app->get('/users/{ID-USER}/sold_tickets[/]', DisplaySoldTicketsByUserAction::class)->setName('users_id_sold_tickets');

    $app->get('/styles[/]', DisplayStylesAction::class)->setName('styles');

    $app->get('/tickets[/]', DisplayTicketsAction::class)->setName('tickets');
    $app->get('/tickets/{ID-TICKET}[/]', DisplayTicketAction::class)->setName('tickets_id');



    return $app;
};
