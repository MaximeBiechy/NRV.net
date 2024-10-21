<?php

namespace nrv\core\services\party;

use nrv\core\dto\party\CreatePartyDTO;
use nrv\core\dto\party\PartyDTO;

interface PartyServiceInterface
{
    public function getParties(): array;
    public function getParty(int $id): PartyDTO;
    public function createParty(CreatePartyDTO $party): PartyDTO;
    public function getPartyByShow(int $showId): array;

}