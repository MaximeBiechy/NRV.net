<?php

namespace nrv\core\services\show;

use nrv\core\domain\entities\Artist\Artist;
use nrv\core\domain\entities\show\Show;
use nrv\core\dto\artist\ArtistDTO;
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

            foreach ($shows as $show) {
                $ars = [];
                foreach ($show->getArtists() as $artist) {
                    $ars[] = new ArtistDTO($artist);
                }
                $show->setArtists($ars);
            }
            $result = [];
            foreach ($shows as $show) {
                $result[] = new ShowDTO($show);
            }
            return $result;
        }catch (RepositoryInternalServerError $e){
            throw new ShowServiceInternalServerErrorException($e->getMessage());
        }
    }

    public function getShow(string $id): ShowDTO
    {
        try{
            $show = $this->showRepository->getShowById($id);
            $ars = [];
            foreach ($show->getArtists() as $artist) {
                $a = new Artist($artist['name'], $artist['style'], $artist['image']);
                $a->setID($artist['id']);
                $ars[] = new ArtistDTO($a);
            }
            $show->setArtists($ars);
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
            $ars = [];
            foreach ($show->getArtists() as $artist) {
                $a = new Artist($artist['name'], $artist['style'], $artist['image']);
                $a->setID($artist['id']);
                $ars[] = new ArtistDTO($a);
            }
            $show->setArtists($ars);
            return new ShowDTO($show);
        }catch (RepositoryInternalServerError $e){
            throw new ShowServiceInternalServerErrorException($e->getMessage());
        }
    }

    public function getArtists(): array
    {
        try{
            $artists = $this->showRepository->getArtists();
            $result = [];
            foreach ($artists as $artist) {
                $result[] = new ArtistDTO($artist);
            }
            return $result;
        }catch (RepositoryInternalServerError $e){
            throw new ShowServiceInternalServerErrorException($e->getMessage());
        }
    }

    public function getArtist(string $id): ArtistDTO
    {
        try{
            $artist = $this->showRepository->getArtistById($id);
            return new ArtistDTO($artist);
        }catch (RepositoryInternalServerError $e){
            throw new ShowServiceInternalServerErrorException($e->getMessage());
        }catch (RepositoryEntityNotFoundException $e){
            throw new ShowServiceArtistNotFoundException($e->getMessage());
        }
    }
}