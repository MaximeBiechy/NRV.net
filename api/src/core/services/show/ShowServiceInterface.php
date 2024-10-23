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
    public function getShowsByDate(string $date): array;
    public function getShowsByStyle(string $style_name): array;
    public function getShowsByPlace(string $place_name): array;
    public function getShowsPaginated(int $page, int $size): array;
    public function getShowsByDatePaginated(string $date, int $page, int $size): array;
    public function getShowsByStylePaginated(string $style_name, int $page, int $size): array;
    public function getShowsByPlacePaginated(string $place_name, int $page, int $size): array;

}