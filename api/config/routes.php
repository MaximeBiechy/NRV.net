<?php
declare(strict_types=1);


use nrv\application\actions\AddTicketToUserCartAction;
use nrv\application\actions\DisplayArtistAction;
use nrv\application\actions\DisplayArtistsAction;
use nrv\application\actions\DisplayCartAction;
use nrv\application\actions\DisplayPartyAction;
use nrv\application\actions\DisplayPartyByShowAction;
use nrv\application\actions\DisplayPlaceAction;
use nrv\application\actions\DisplayPlacesAction;
use nrv\application\actions\SigninAction;
use nrv\application\actions\SignupAction;
use nrv\application\actions\ValidateCardAction;
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
    $app->patch('/carts/{ID-CART}/[/]', AddTicketToUserCartAction::class)->setName('carts_id');

    $app->get('/users/{ID-USER}/cart[/]', DisplayCartAction::class)->setName('users_id_cart');

    return $app;
};
