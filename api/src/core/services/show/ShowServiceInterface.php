<?php

namespace nrv\core\services\show;

use nrv\core\dto\artist\ArtistDTO;
use nrv\core\dto\show\CreateShowDTO;
use nrv\core\dto\show\ShowDTO;

interface ShowServiceInterface
{
    public function getShows(): array;
    public function getShow(string $id): ShowDTO;
    public function createShow(CreateShowDTO $show): ShowDTO;
    public function getArtists(): array;
    public function getArtist(string $id): ArtistDTO;

}