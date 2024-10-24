<?php

namespace nrv\core\services\place;

use nrv\core\domain\entities\place\Place;
use nrv\core\dto\place\CreatePlaceDTO;
use nrv\core\dto\place\PlaceDTO;
use nrv\core\repositoryInterfaces\PlaceRepositoryInterface;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;

class PlaceService implements PlaceServiceInterface
{
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function getPlaces(): array
    {
        try{
            $places = $this->placeRepository->getPlaces();
            $result = [];
            foreach ($places as $place) {
                $result[] = new PlaceDTO($place);
            }
            return $result;
        }catch (RepositoryInternalServerError $e){
            throw new PlaceServiceInternalServerErrorException($e->getMessage());
        }

    }

    public function getPlace(string $id): PlaceDTO
    {
        try{
            $place = $this->placeRepository->getPlaceById($id);
            return new PlaceDTO($place);
        }catch (RepositoryInternalServerError $e){
            throw new PlaceServiceInternalServerErrorException($e->getMessage());
        }catch (RepositoryEntityNotFoundException $e){
            throw new PlaceServiceNotFoundException($e->getMessage());
        }

    }

    public function createPlace(CreatePlaceDTO $place): PlaceDTO
    {
        try{
            $place = new Place($place->name, $place->address,$place->nbSit, $place->nbStand, $place->images);
            $id = $this->placeRepository->save($place);
            $place->setID($id);
            return new PlaceDTO($place);
        }catch (RepositoryInternalServerError $e){
            throw new PlaceServiceInternalServerErrorException($e->getMessage());
        }
    }

    public function updatePlace(string $id, CreatePlaceDTO $placeDTO): PlaceDTO
    {
        try{
            $place = $this->placeRepository->getPlaceById($id);
            $place->setName($placeDTO->name);
            $place->setAddress($placeDTO->address);
            $place->setNbSit($placeDTO->nbSit);
            $place->setNbStand($placeDTO->nbStand);
            $place->setImages($placeDTO->images);
            $this->placeRepository->update($place);
            return new PlaceDTO($place);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new PlaceServiceNotFoundException($e->getMessage());
        } catch (RepositoryInternalServerError $e) {
            throw new PlaceServiceInternalServerErrorException($e->getMessage());
        }
    }
}