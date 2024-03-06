<?php

namespace core;

use game\Game;

/**
 * Class PageActions
 * Used to handle the actions from the buttons used on index.php
 * such as making moves or resetting the game
 */
class PageActions
{

    private Game $game;



    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function handleAction()
    {

        if (!isset($_POST['action'])) {
            return;
        }

        if ($_POST['action'] === 'reset') {
            $this->reset();
        } else if ($_POST['action'] === 'pass') {
            $this->pass();
        } else if ($_POST['action'] === 'place') {
            $this->place();
        } else if ($_POST['action'] === 'undo') {
            $this->undo();
        } else if ($_POST['action'] === 'move') {
            $this->move();
        }
    }

    public function reset()
    {
        unset($_SESSION['game']);
        header('Location: index.php');
    }

    public function pass()
    {
    }

    // Place a tile on the board
    public function place()
    {
        if ($_POST['tile'] && $_POST['coords']) {
            $tile = $_POST['tile'];
            $coords = $_POST['coords'];
            $coords = explode(',', $coords);
            $q = intval($coords[0]);
            $r = intval($coords[1]);

            $this->game->placeTile($q, $r, $tile);

            $_SESSION['game'] = serialize($this->game);

            header('Location: index.php');
        }
    }

    public function undo()
    {
    }

    public function move()
    {
    }
}
