<?php

namespace Hive;

class Game
{
    private $board;
    private $player;
    private $hand;

    public function __construct($board, $player, $hand)
    {
        $this->board = $board;
        $this->player = $player;
        $this->hand = $hand;
    }

    public function renderBoard()
    {
        $min_p = 1000;
        $min_q = 1000;
        $board = $this->board;
        foreach ($board as $pos => $tile) {
            $pq = explode(',', $pos);
            if ($pq[0] < $min_p) {
                $min_p = $pq[0];
            }
            if ($pq[1] < $min_q) {
                $min_q = $pq[1];
            }
        }
        foreach (array_filter($board) as $pos => $tile) {
            $pq = explode(',', $pos);
            $pq[0];
            $pq[1];
            $h = count($tile);
            echo '<div class="tile player';
            echo $tile[$h - 1][0];
            if ($h > 1) {
                echo ' stacked';
            }
            echo '" style="left: ';
            echo ($pq[0] - $min_p) * 4 + ($pq[1] - $min_q) * 2;
            echo 'em; top: ';
            echo ($pq[1] - $min_q) * 4;
            echo "em;\">($pq[0],$pq[1])<span>";
            echo $tile[$h - 1][1];
            echo '</span></div>';
        }
    }

    public function renderHand($player)
    {
        $hand = $this->hand;
        foreach ($hand[$player] as $tile => $ct) {
            for ($i = 0; $i < $ct; $i++) {
                echo '<div class="tile player' . $player . '"><span>' . $tile . "</span></div> ";
            }
        }
    }

    public function renderTurn()
    {
        if ($this->player == 0) {
            echo "White";
        } else {
            echo "Black";
        }
    }

    // Add more methods as needed for game functionality
}
