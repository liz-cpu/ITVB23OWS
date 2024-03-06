<?php

namespace game;

use tiles\Queen;
use tiles\Tile;

class Player
{

    private string $name;
    private bool $isZero;
    private array $hand;
    private int $moves;

    public function __construct(string $name,  bool $isZero)
    {
        $this->name = $name;
        $this->isZero = $isZero;
        $this->hand = array();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColorClass(): string
    {
        return $this->isZero ? 'player0' : 'player1';
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function setHand(array $hand): void
    {
        $this->hand = $hand;
    }

    public function removeFromHand(Tile $tile): void
    {
        $key = array_search($tile, $this->hand);
        if ($key !== false) {
            unset($this->hand[$key]);
        }
    }

    public function incrementMoves(): void
    {
        $this->moves++;
    }
}
