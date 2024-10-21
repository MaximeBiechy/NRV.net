<?php

namespace nrv\core\services\party;

use nrv\core\domain\entities\party\Party;
use nrv\core\dto\party\CreatePartyDTO;
use nrv\core\dto\party\PartyDetailsDTO;
use nrv\core\dto\party\PartyDTO;
use nrv\core\repositoryInterfaces\PartyRepositoryInterface;

class PartyService implements PartyServiceInterface
{
    private PartyRepositoryInterface $partyRepository;

    public function __construct(PartyRepositoryInterface $partyRepository)
    {
        $this->partyRepository = $partyRepository;
    }

    public function getParties(): array
    {
        $parties = $this->partyRepository->getParties();
        $partiesDTO = [];
        foreach ($parties as $party) {
            $partiesDTO[] = new PartyDTO($party);
        }
        return $partiesDTO;
    }

    public function getParty(int $id): PartyDTO
    {
        $party = $this->partyRepository->getPartyById($id);
        return new PartyDTO($party);
    }

    public function createParty(CreatePartyDTO $party): PartyDTO
    {
        $party = new Party($party->id, $party->name, $party->theme, $party->prices, $party->date, $party->begin, $party->shows, $party->place);
        $id = $this->partyRepository->save($party);
        $party->setId($id);
        return new PartyDTO($party);
    }

    public function getPartyByShow(int $showId): array
    {
        $parties = $this->partyRepository->getPartyByShow($showId);
        $partiesDTO = [];
        foreach ($parties as $party) {
            $partiesDTO[] = new PartyDetailsDTO($party);
        }
        return $partiesDTO;
    }
}