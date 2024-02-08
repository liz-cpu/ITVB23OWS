<?php

namespace game;

use game\Board;
use game\Player;



/**
 * Represents the game. This encompasses the board, the players, and the game
 * loop itself. This class also renders the game and is the connection between
 * the game and the user interface.
 */
class Game
{
    private Board $board;
    private Player $player0;
    private Player $player1;
    private Player $current_player;
    private bool $is_over;

    public function __construct()
    {
        $this->board = new Board();
        $this->init_players();
        $this->current_player = $this->player0;
        $this->is_over = false;
    }

    public function init_players(): void
    {
        $player0 = new Player('Player 1', true);
        $player1 = new Player('Player 2', false);

        $this->player0 = $player0;
        $this->player1 = $player1;
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getPlayer0(): Player
    {
        return $this->player0;
    }

    public function getPlayer1(): Player
    {
        return $this->player1;
    }

    public function getCurrentPlayer(): Player
    {
        return $this->current_player;
    }

    public function isOver(): bool
    {
        return $this->is_over;
    }

    public function switchPlayer(): void
    {
        $this->current_player = $this->current_player === $this->player0 ? $this->player1 : $this->player0;
    }

    public function endGame(): void
    {
        $this->is_over = true;
    }

}
