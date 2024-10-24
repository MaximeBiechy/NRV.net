<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\place\Place;

interface PlaceRepositoryInterface
{
    public function getPlaces(): array;
    public function getPlaceById(string $id): Place;
    public function save(Place $place): string;
    public function update(Place $place): string;

}