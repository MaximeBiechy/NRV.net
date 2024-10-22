<?php

namespace nrv\core\services\party;

use nrv\core\domain\entities\Artist\Artist;
use nrv\core\domain\entities\party\Party;
use nrv\core\dto\artist\ArtistDTO;
use nrv\core\dto\party\CreatePartyDTO;
use nrv\core\dto\party\PartyDetailsDTO;
use nrv\core\dto\party\PartyDTO;
use nrv\core\dto\show\ShowDTO;
use nrv\core\repositoryInterfaces\PartyRepositoryInterface;
use nrv\core\repositoryInterfaces\ShowRepositoryInterface;

class PartyService implements PartyServiceInterface
{
    private PartyRepositoryInterface $partyRepository;
    private ShowRepositoryInterface $showService;

    public function __construct(PartyRepositoryInterface $partyRepository, ShowRepositoryInterface $showService)
    {
        $this->partyRepository = $partyRepository;
        $this->showService = $showService;
    }

    public function getParties(): array
    {
        $parties = $this->partyRepository->getParties();
        $partiesDTO = [];
        foreach ($parties as $party) {
            $s = [];
            foreach ($party->getShows() as $show) {
                $request = $this->showService->getShowById($show);
                $a = [];
                foreach ($request->getArtists() as $artist) {
                    $art = new Artist($artist['name'], $artist['style'], $artist['image']);
                    $art->setID($artist['id']);
                    $a[] = new ArtistDTO($art);
                }
                $request->setArtists($a);
                $s[] = new ShowDTO($request);
            }
            $party->setShows($s);
            $partiesDTO[] = new PartyDTO($party);
        }
        return $partiesDTO;
    }

    public function getParty(string $id): PartyDetailsDTO
    {
        $party = $this->partyRepository->getPartyById($id);
        $s = [];
        foreach ($party->getShows() as $show) {
            $request = $this->showService->getShowById($show);
            $a = [];
            foreach ($request->getArtists() as $artist) {
                $art = new Artist($artist['name'], $artist['style'], $artist['image']);
                $art->setID($artist['id']);
                $a[] = new ArtistDTO($art);
            }
            $request->setArtists($a);
            $s[] = new ShowDTO($request);
        }
        $party->setShows($s);
        return new PartyDetailsDTO($party);
    }

    public function createParty(CreatePartyDTO $party): PartyDTO
    {
        $party = new Party($party->name, $party->theme, $party->price, $party->date, $party->begin, $party->shows, $party->place);
//        __construct(string $name, string $theme, int $price, \DateTimeImmutable $date, \DateTimeImmutable $begin, array $shows, string $place_id)
        $id = $this->partyRepository->save($party);
        $party->setId($id);
        return new PartyDTO($party);
    }

    public function getPartyByShow(string $showId): array
    {
        $parties = $this->partyRepository->getPartyByShow($showId);
        $partiesDTO = [];
        foreach ($parties as $party) {
            $s = [];
            foreach ($party->getShows() as $show) {
                $request = $this->showService->getShowById($show);
                $a = [];
                foreach ($request->getArtists() as $artist) {
                    $art = new Artist($artist['name'], $artist['style'], $artist['image']);
                    $art->setID($artist['id']);
                    $a[] = new ArtistDTO($art);
                }
                $request->setArtists($a);
                $s[] = new ShowDTO($request);
            }
            $party->setShows($s);
            $partiesDTO[] = new PartyDetailsDTO($party);
        }
        return $partiesDTO;
    }
}