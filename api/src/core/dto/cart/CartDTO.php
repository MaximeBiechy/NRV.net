<?php

namespace nrv\core\dto\cart;

use nrv\core\domain\entities\cart\Cart;
use nrv\core\dto\DTO;

class CartDTO extends DTO
{
    protected string $id, $user_id;
    protected float $price;
    protected float $priceHT;
    protected float $tva;
    protected array $tickets;
    protected int $state;

    public function __construct(Cart $card)
    {
        $this->id = $card->getId();
        $this->price = $card->getTotalPrice();
        $this->user_id = $card->getUserId();
        $this->tickets = $card->getTickets();
        $this->state = $card->getState();
        $this->priceHT = $this->price * 0.8;
        $this->tva = $this->price * 0.2;
    }

}