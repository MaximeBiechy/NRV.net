<?php

namespace nrv\application\actions;

use nrv\application\actions\AbstractAction;
use nrv\application\renderer\JsonRenderer;
use nrv\core\dto\show\CreateShowDTO;
use nrv\core\services\show\ShowServiceBadDataException;
use nrv\core\services\show\ShowServiceInterface;
use nrv\core\services\show\ShowServiceInternalServerErrorException;
use nrv\core\services\show\ShowServiceNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

class CreateShowAction extends AbstractAction
{

    private ShowServiceInterface $showService;

    public function __construct(ShowServiceInterface $showService)
    {
        $this->showService = $showService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $routeContext = RouteContext::fromRequest($rq);
            $routeParser = $routeContext->getRouteParser();

            $data = $rq->getParsedBody();
            $placeInputValidator = Validator::key('title', Validator::stringType()->notEmpty())
                ->key('description', Validator::stringType()->notEmpty())
                ->key('video', Validator::stringType()->notEmpty())
                ->key('images', Validator::arrayType()->notEmpty())
                ->key('artists', Validator::arrayType()->notEmpty())
                ->key('date', Validator::stringType()->notEmpty());
            try{
                $placeInputValidator->assert($data);
            } catch (NestedValidationException $e) {
                throw new HttpBadRequestException($rq, $e->getFullMessage());
            }
            if(filter_var($data["title"],FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["title"] ){
                throw new HttpBadRequestException($rq, "Bad data format title");
            }
            if(filter_var($data["description"],FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["description"] ){
                throw new HttpBadRequestException($rq, "Bad data format description");
            }
            if(filter_var($data["video"],FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["video"] ){
                throw new HttpBadRequestException($rq, "Bad data format video");
            }
            if (!is_array($data["images"])) {
                throw new HttpBadRequestException($rq, "Bad data format images");
            }
            if (!is_array($data["artists"])) {
                throw new HttpBadRequestException($rq, "Bad data format artists");
            }
            if(filter_var($data["date"],FILTER_SANITIZE_FULL_SPECIAL_CHARS) !== $data["date"] ){
                throw new HttpBadRequestException($rq, "Bad data format date");
            }
            $showDto = new CreateShowDTO($data['title'], $data['description'], $data['video'], $data['images'], $data['artists'], \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['date']));
            $show = $this->showService->createShow($showDto);
            $urlShow = $routeParser->urlFor('shows_id', ['ID-SHOW' => $show->id]);
            $response = [
               'type' => 'resource',
                'locale' => 'fr-FR',
                'show' => $show,
                'link' => [
                    "self" => ['href' => $urlShow]
                ]
            ];

            return JsonRenderer::render($rs, 201, $response);
        } catch (ShowServiceBadDataException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (ShowServiceInternalServerErrorException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (ShowServiceNotFoundException $e) {
            throw new HttpNotFoundException($rq, $e->getMessage());
        }
    }
}