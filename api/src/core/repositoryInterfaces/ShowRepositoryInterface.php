<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\artist\Artist;
use nrv\core\domain\entities\show\Show;

interface ShowRepositoryInterface
{
    public function save(Show $show): string;
    public function getShows(): array;
    public function getShowById(string $id): Show;
    public function getArtists(): array;
    public function getArtistById(string $id): Artist;
    public function getShowsByDate(string $date): array;
    public function getShowsByStyle(string $style_name): array;
    public function getShowsByPlace(string $place_name): array;
}