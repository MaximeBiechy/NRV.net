<?php

namespace nrv\core\services\party;

use nrv\core\dto\party\CreatePartyDTO;
use nrv\core\dto\party\PartyDetailsDTO;
use nrv\core\dto\party\PartyDTO;

interface PartyServiceInterface
{
    public function getParties(): array;
    public function getParty(string $id): PartyDetailsDTO;
    public function createParty(CreatePartyDTO $party): PartyDTO;
    public function getPartyByShow(string $showId): array;

}