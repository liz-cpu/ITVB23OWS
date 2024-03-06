<?php

namespace game;

use tiles\Tile;
use tiles\Queen;
use game\Board;
use game\Player;
use tiles\Beetle;



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

        $p1Hand = [new Queen($player0), new Beetle($player0), new Beetle($player0)];
        $p2Hand = [new Queen($player1), new Beetle($player1), new Beetle($player1)];

        $player0->setHand($p1Hand);
        $player1->setHand($p2Hand);

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

    public function placeTile(int $q, int $r, string $tile_str): void
    {
        $hand = $this->current_player->getHand();
        foreach ($hand as $tile) {

            if ($tile->getTypeValue() === $tile_str) {
                if ($tile->isValidPlacement($this->board, $q, $r) && in_array($tile, $this->current_player->getHand())) {
                    $this->board->setTile($q, $r, $tile);
                    $this->current_player->removeFromHand($tile);
                    $this->current_player->setHand(array_values($this->current_player->getHand()));
                    $this->switchPlayer();
                } else {
                    echo "Invalid placement";
                }
            }
        }
    }

    public function placeQueenThenSwitchPlayer(): void
    {
        if ($this->current_player === $this->player0) {
            $q = 0;
            $r = 0;
        } else {
            $q = -1;
            $r = 1;
        }
        $queen = $this->current_player->getHand()[0];
        $this->board->setTile($q, $r, $queen);
        $this->current_player->removeFromHand($queen);
        $this->current_player->setHand(array_values($this->current_player->getHand()));

        $this->switchPlayer();
    }

    public function renderBoard(): string
    {
        $tileSize = 50;
        $board = $this->getBoard();

        ob_start();
?>
        <div class="board">
            <?php
            foreach ($board->getInnerBoard() as $q => $row) {
                foreach ($row as $r => $_) {
                    list($minQ, $minR) = $board->getSmallestOffsets();

                    $qOffset = ($tileSize * ($r - $minR)) + ($tileSize * 0.5 * ($q - $minQ));
                    $rOffset = ($tileSize - 5) * ($q - $minQ);

                    $tile = $board->getTile($q, $r);
                    if ($tile !== null) {
                        $tileType = $tile->getTypeValue();
                        $tileColor = $tile->getPlayer()->getColorClass();
                        $coords = $q . ',' . $r;
            ?>
                        <div class='tile <?php echo $tileType; ?> <?php echo $tileColor; ?>' label='<?php echo $coords; ?>' style='top: <?php echo $qOffset; ?>px; left: <?php echo $rOffset; ?>px; width: <?php echo $tileSize; ?>px; height: <?php echo $tileSize; ?>px;'><?php echo $tileType; ?></div>
            <?php
                    }
                }
            }
            ?>
        </div>
    <?php
        return ob_get_clean();
    }

    public function renderSidebar()
    {
        ob_start();
    ?>
        <aside id="sidebar">
            <h2><?php echo $this->getCurrentPlayer()->getName(); ?>'s turn</h2>
            <form method="post">
                <button name="action" value="place">Place</button>
                <button name="action" value="reset">Reset</button>
                <select name="tile" id="tile">
                    <?php
                    $hand = $this->getCurrentPlayer()->getHand();
                    foreach ($hand as $tile) {
                        $tileType = $tile->getTypeValue();
                        $tileColor = $tile->getPlayer()->getColorClass();
                        echo "<option value='$tileType' class='$tileType $tileColor'>$tileType</option>";
                    }
                    ?>
                </select>
                <select name="coords" id="coords">
                    <?php

                    $placements = $hand[0]->getPlacements($this->getBoard());
                    foreach ($placements as $placement) {
                        $q = $placement[0];
                        $r = $placement[1];
                        echo "<option value='$q,$r'>($q, $r)</option>";
                    }
                    ?>
                </select>
            </form>
        </aside>
<?php
        return ob_get_clean();
    }
}
