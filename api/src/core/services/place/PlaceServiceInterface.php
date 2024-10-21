<?php

namespace nrv\core\services\place;

use nrv\core\dto\place\CreatePlaceDTO;
use nrv\core\dto\place\PlaceDTO;

interface PlaceServiceInterface
{
    public function getPlaces(): array;
    public function getPlace(int $id): PlaceDTO;
    public function createPlace(CreatePlaceDTO $place): PlaceDTO;

}