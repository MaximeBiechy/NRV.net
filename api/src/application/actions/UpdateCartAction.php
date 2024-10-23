<?php

namespace nrv\application\actions;

use nrv\application\renderer\JsonRenderer;
use nrv\core\services\ticket\TicketServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class UpdateCartAction extends AbstractAction
{

    private TicketServiceInterface $ticketService;

    public function __construct(TicketServiceInterface $ticketService) {
        $this->ticketService = $ticketService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $param = $rq->getQueryParams();
        $card_id = $args["ID-CART"];

        switch ($param['state']) {
            case VALIDATE_CART:
                $cart = $this->ticketService->validateCart($card_id);
                break;
            case VALIDATE_COMMAND:
                $cart = $this->ticketService->validateCommand($card_id);
                break;
            case PAYED:
                $numero_cb = $rq->getParsedBody()['num_cb'];
                $date_exp = $rq->getParsedBody()['date_exp'];
                $code = $rq->getParsedBody()['code'];
                $data = $rq->getParsedBody();
                $placeInputValidator = Validator::key('num_cb', Validator::stringType()->notEmpty())
                    ->key('date_exp', Validator::stringType()->notEmpty())
                    ->key('code', Validator::stringType()->notEmpty());
                try{
                    $placeInputValidator->assert($data);
                } catch (NestedValidationException $e) {
                    throw new HttpBadRequestException($rq, $e->getFullMessage());
                }
                if(filter_var($numero_cb,FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $numero_cb){
                    throw new HttpBadRequestException($rq, "Bad data format num cb");
                }
                if(filter_var($date_exp,FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $date_exp){
                    throw new HttpBadRequestException($rq, "Bad data format date exp");
                }
                if(filter_var($code,FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $code){
                    throw new HttpBadRequestException($rq, "Bad data format code");
                }
                if (strlen($numero_cb) != 19 || strlen($date_exp) != 4 || strlen($code) != 3) {
                    throw new HttpBadRequestException($rq, "Invalid card number, expiration date or code");
                }
                $cart = $this->ticketService->payCart($card_id);
                break;
            default:
                break;
        }

        $routeContext = RouteContext::fromRequest($rq);
        $routeParser = $routeContext->getRouteParser();
        $urlSelf = $routeParser->urlFor('users_id_cart', ['ID-USER' => $cart->user_id]);
        $response = [
            "type" => "resource",
            "locale" => "fr-FR",
            "cart" => [
                "id" => $cart->id,
                "user_id" => $cart->user_id,
                "state" => $cart->state,
                "tickets" => $cart->tickets,
                "links" => [
                    "self" => ['href' => $urlSelf]
                ]
            ]
        ];
        return JsonRenderer::render($rs,200, $response);

    }
}