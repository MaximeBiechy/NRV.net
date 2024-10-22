<?php
declare(strict_types=1);


use nrv\application\actions\DisplayPartyAction;
use nrv\application\actions\DisplayPartyByShowAction;
use nrv\application\actions\SigninAction;
use nrv\application\actions\SignupAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use nrv\application\actions\DisplayShowAction;
use nrv\application\actions\DisplayShowsAction;
use nrv\application\middlewares\Cors;

return function(\Slim\App $app):\Slim\App {

    $app->add(Cors::class);

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

    return $app;
};
