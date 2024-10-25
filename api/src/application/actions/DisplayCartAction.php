<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\auth\AuthentificationServiceBadDataException;
use nrv\core\services\auth\AuthentificationServiceInterface;
use nrv\core\services\auth\AuthentificationServiceInternalServerErrorException;
use nrv\core\services\auth\AuthentificationServiceNotFoundException;
use nrv\core\services\ticket\TicketBadDataException;
use nrv\core\services\ticket\TicketServiceInterface;
use nrv\core\services\ticket\TicketServiceInternalServerErrorException;
use nrv\core\services\ticket\TicketServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Rfc4122\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class DisplayCartAction extends AbstractAction
{
    private TicketServiceInterface $ticketServiceInterface;
    private AuthentificationServiceInterface $authentificationService;

    public function __construct(TicketServiceInterface $ticketServiceInterface, AuthentificationServiceInterface $authentificationService)
    {
        $this->ticketServiceInterface = $ticketServiceInterface;
        $this->authentificationService = $authentificationService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $user_id = $args['ID-USER'];
            $uuidValidator = new Validator();
            if (!$uuidValidator->validate($user_id)) {
                throw new HttpBadRequestException($rq, "Invalid UUID format.");
            }
            $this->authentificationService->getUserById($user_id);

            $cart = $this->ticketServiceInterface->getCartByUserId($user_id);
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();
            $urlSelf = $routeParser->urlFor('users_id_cart', ['ID-USER' => $user_id]);
            $tickets = $cart->tickets;
            $tickets = array_map(function ($ticket) use ($routeParser) {
                $urlSelf = $routeParser->urlFor('tickets_id', ['ID-TICKET' => $ticket->id]);
                return [
                    'id' => $ticket->id,
                    'name' => $ticket->name,
                    'quantity' => $ticket->quantity,
                    'party_id' => $ticket->party_id,
                    'price' => $ticket->price,
                    'links' => [
                        'self' => ['href' => $urlSelf],
                        'party' => ['href' => $routeParser->urlFor('parties_id', ['ID-PARTY' => $ticket->party_id])]
                    ]
                ];
            }, $tickets);
            $response = [
                "type" => "resource",
                "locale" => "fr-FR",
                "cart" => [
                    "id" => $cart->id,
                    "user_id" => $cart->user_id,
                    "state" => $cart->state,
                    "tickets" => $tickets,
                    "price_HT" => $cart->priceHT,
                    "tva" => $cart->tva,
                    "total_price" => $cart->price,
                    "links" => [
                        "self" => ['href' => $urlSelf],
                        'add_ticket' => ['href' => $routeParser->urlFor('carts_id', ['ID-CART' => $cart->id])],
                        'update_cart' => ['href' => $routeParser->urlFor('update_card_id', ['ID-CART' => $cart->id])]
                    ]
                ]
            ];
            return JsonRenderer::render($rs, 200, $response);
        } catch (TicketServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (TicketServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (TicketBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (AuthentificationServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (AuthentificationServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        } catch (AuthentificationServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

    }
}