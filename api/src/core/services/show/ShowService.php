<?php

namespace nrv\core\services\show;

use nrv\core\domain\entities\show\Show;
use nrv\core\dto\show\CreateShowDTO;
use nrv\core\dto\show\ShowDTO;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
use nrv\core\repositoryInterfaces\ShowRepositoryInterface;

class ShowService implements ShowServiceInterface
{
    private ShowRepositoryInterface $showRepository;

    public function __construct(ShowRepositoryInterface $showRepository)
    {
        $this->showRepository = $showRepository;
    }

    public function getShows(): array
    {
        try{
            $shows = $this->showRepository->getShows();
            $result = [];
            foreach ($shows as $show) {
                $result[] = new ShowDTO($show);
            }
            return $result;
        }catch (RepositoryInternalServerError $e){
            throw new ShowServiceInternalServerErrorException($e->getMessage());
        }
    }

    public function getShow(int $id): ShowDTO
    {
        try{
            $show = $this->showRepository->getShowById($id);
            return new ShowDTO($show);
        }catch (RepositoryInternalServerError $e){
            throw new ShowServiceInternalServerErrorException($e->getMessage());
        }catch (RepositoryEntityNotFoundException $e){
            throw new ShowServiceNotFoundException($e->getMessage());
        }
    }

    public function createShow(CreateShowDTO $show): ShowDTO
    {
        try{
            $show = new Show($show->title, $show->description, $show->video, $show->images, $show->artists, $show->begin);
            $id = $this->showRepository->save($show);
            $show->setID($id);
            return new ShowDTO($show);
        }catch (RepositoryInternalServerError $e){
            throw new ShowServiceInternalServerErrorException($e->getMessage());
        }
    }
}