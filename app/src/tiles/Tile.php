<?php

namespace tiles;

use game\Board;
use game\Player;

abstract class Tile
{
    protected string $type_value = '?';
    protected Player $player;
    protected int $z;

    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->z = 0;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getTypeValue(): string
    {
        return $this->type_value;
    }

    public function setZ(int $z): void
    {
        $this->z = $z;
    }

    public function getZ(): int
    {
        return $this->z;
    }

    /**
     * Tiles can be placed in the six directions around the tile where they
     * will not neighbor any enemy tiles or stack on top of any tiles. So they
     * can be placed in any empty tile that is adjacent to a tile of the same
     * player.
     */
    public function getPlacements(Board $board): array
    {
        $offsets = [
            [1, 0], [1, -1], [0, -1], [-1, 0], [-1, 1], [0, 1]
        ];

        if ($board->isEmpty()) {
            return [[0, 0]];
        }

        $placements = [];

        foreach ($board->getInnerBoard() as $q => $row) {
            foreach ($row as $r => $_) {
                $tile = $board->getTile($q, $r);

                if ($tile->getPlayer() === $this->player) {

                    foreach ($offsets as $offset) {
                        $q_offset = $offset[0];
                        $r_offset = $offset[1];

                        $q_new = $q + $q_offset;
                        $r_new = $r + $r_offset;

                        if ($board->isTileEmpty($q_new, $r_new)) {

                            if (!self::hasEnemyNeighbour($board, $q_new, $r_new, $this->player)) {

                                $placements[] = [$q_new, $r_new];
                            }
                        }
                    }
                }
            }
        }

        if (count($board->getInnerBoard()) === 1) {
            if ($board->getTile(0, 0)->getPlayer() !== $this->player) {
                return [[1, 0], [1, -1], [0, -1], [-1, 0], [-1, 1], [0, 1]];
            }
        }

        return $placements;
    }

    function isValidPlacement(Board $board, int $q, int $r): bool
    {
        $placements = $this->getPlacements($board);

        foreach ($placements as $placement) {
            if ($placement[0] === $q && $placement[1] === $r) {
                return true;
            }
        }

        return false;
    }
    /***
     * Check if the given coordinates have an enemy neighbour.
     *
     * @param Board $board The board.
     * @param int $q The q-offset.
     * @param int $r The r-offset.
     * @param Player $player The player to check the enemy of.
     * @return bool True if the coordinates have an enemy neighbour, false otherwise.
     */
    static public function hasEnemyNeighbour(Board $board, int $q, int $r, Player $player): bool
    {
        $offsets = [
            [1, 0], [1, -1], [0, -1], [-1, 0], [-1, 1], [0, 1]
        ];

        foreach ($offsets as $offset) {
            $q_offset = $offset[0];
            $r_offset = $offset[1];

            $q_new = $q + $q_offset;
            $r_new = $r + $r_offset;

            if (!$board->isTileEmpty($q_new, $r_new)) {
                $tile = $board->getTile($q_new, $r_new);
                if ($tile->getPlayer() !== $player) {
                    return true;
                }
            }
        }
        return false;
    }

    abstract public function getMoves(Board $board, int $q, int $r): array;

    public function isValidMove(Board $b, int $q, int $r, int $q_new, int $r_new): bool
    {
        if ($this->z < 0) {
            return false;
        }
        $moves = $this->getMoves($b, $q, $r);

        foreach ($moves as $move) {
            if ($move[0] == $q_new && $move[1] == $r_new) {
                return true;
            }
        }
        return false;
    }
}
