<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\party\Party;

interface PartyRepositoryInterface
{
    public function save(Party $party): string;
    public function getPartyById(string $id): Party;

}