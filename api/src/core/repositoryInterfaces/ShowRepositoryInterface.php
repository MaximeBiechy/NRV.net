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
    public function getShowsPaginated(int $page, int $size): array;
    public function getShowsByDatePaginated(string $date, int $page, int $size): array;
    public function getShowsByStylePaginated(string $style_name, int $page, int $size): array;
    public function getShowsByPlacePaginated(string $place_name, int $page, int $size): array;
    public function getStyles(): array;
    public function getArtistsPaginated(int $page, int $size): array;
}