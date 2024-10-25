<?php

namespace nrv\core\services\party;

use nrv\core\domain\entities\artist\Artist;
use nrv\core\domain\entities\party\Party;
use nrv\core\dto\artist\ArtistDTO;
use nrv\core\dto\party\CreatePartyDTO;
use nrv\core\dto\party\PartyDetailsDTO;
use nrv\core\dto\party\PartyDTO;
use nrv\core\dto\show\ShowDTO;
use nrv\core\repositoryInterfaces\PartyRepositoryInterface;
use nrv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use nrv\core\repositoryInterfaces\RepositoryInternalServerError;
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
        try {
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
                $partiesDTO[] = new PartyDetailsDTO($party);
            }
            return $partiesDTO;
        } catch (RepositoryInternalServerError $e) {
            throw new PartyServiceInternalServerErrorException($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new PartyServiceNotFoundException($e->getMessage());
        }
    }

    public function getParty(string $id): PartyDetailsDTO
    {
        try {
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
        } catch (RepositoryInternalServerError $e) {
            throw new PartyServiceInternalServerErrorException($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new PartyServiceNotFoundException($e->getMessage());
        }
    }

    public function createParty(CreatePartyDTO $party): PartyDTO
    {
        try {
            $party = new Party($party->name, $party->theme, $party->price, $party->date, $party->begin, $party->shows, $party->place);
            $id = $this->partyRepository->save($party);
            $party->setId($id);
            return new PartyDTO($party);
        } catch (RepositoryInternalServerError $e) {
            throw new PartyServiceInternalServerErrorException($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new PartyServiceNotFoundException($e->getMessage());
        }
    }

    public function getPartyByShow(string $showId): array
    {
        try {
            if ($this->showService->getShowById($showId) === null) {
                throw new PartyServiceNotFoundException('Show not found');
            }
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
        } catch (RepositoryInternalServerError $e) {
            throw new PartyServiceInternalServerErrorException($e->getMessage());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new PartyServiceNotFoundException($e->getMessage());
        }
    }
}