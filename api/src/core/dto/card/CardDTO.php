<?php

namespace nrv\core\dto\card;

use nrv\core\domain\entities\card\Card;
use nrv\core\dto\DTO;

class CardDTO extends DTO
{
    protected string $id, $user_id;
    protected int $price;
    protected array $tickets;

    public function __construct(Card $card)
    {
        $this->id = $card->getId();
        $this->price = $card->getTotalPrice();
        $this->user_id = $card->getUserId();
        $this->tickets = $card->getTickets();
    }

}