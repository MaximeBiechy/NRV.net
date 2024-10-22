<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\place\Place;
use nrv\core\domain\entities\place\string;

interface PlaceRepositoryInterface
{
    public function getPlaces(): array;
    public function getPlaceById(int $id): Place;
    public function save(Place $place): string;

}