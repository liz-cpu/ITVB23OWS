<?php

namespace game;

use tiles\Tile;

/**
 * Represents the game board. The game uses a hexagonal grid with axial
 * coordinates. The board is represented as a 2D array of tiles, where each
 * tile is either a piece or empty. The keys of the outer array are
 * q-offsets, and the keys of the inner arrays are r-offsets.
 * Going west (left) increases the q-offset, going east (right) decreases it.
 * Where you to go north-east, the r-offset would decrease and the q-offset would
 * increase. Going south-west would be the opposite.
 * Note: There is a s-offset, but it is implicitly defined as s = -q - r.
 *
 * The first tile is always at (0, 0), and the board grows from there. From
 * there, the board can grow in all 6 directions. The board is unbounded.
 * @package game
 */
class Board
{
    private array $inner_board;

    public function __construct()
    {
        $this->inner_board = [];
    }


    /**
     * Get the top tile at the given coordinates.
     * @param int $q The q-offset.
     * @param int $r The r-offset.
     * @return Tile|null The top tile at the given coordinates, or null if there is no tile.
     */
    public function getTile(int $q, int $r): ?Tile
    {
        return $this->inner_board[$q][$r] ?? null;
    }


    /**
     * Set the tile at the given coordinates.
     * @param int $q The q-offset.
     * @param int $r The r-offset.
     * @param Tile $tile The tile to set.
     */
    public function setTile(int $q, int $r, Tile $tile): void
    {
        $this->inner_board[$q][$r] = $tile;
    }



    public function removeTile(int $q, int $r): ?Tile
    {
        $tile = $this->inner_board[$q][$r] ?? null;
        unset($this->inner_board[$q][$r]);
        return $tile;
    }



    /**
     * Get the inner board.
     * @return array The inner board.
     */
    public function getInnerBoard(): array
    {
        return $this->inner_board;
    }


    /**
     * Check if the board is empty.
     * @return bool True if the board is empty, false otherwise.
     */
    public function isEmpty(): bool
    {
        return empty($this->inner_board);
    }


    /**
     * Check if the given coordinates are empty.
     * 
     * @param int $q The q-offset.
     * @param int $r The r-offset.
     * @return bool True if the coordinates are empty, false otherwise.
     */
    public function isTileEmpty(int $q, int $r): bool
    {
        return !$this->getTile($q, $r);
    }


    /**
     * Get the smallest q and r offsets. This is useful for rendering the board.
     * @return array The smallest q and r offsets.
     */
    public function getSmallestOffsets(): array
    {
        if ($this->isEmpty()) {
            return [0, 0];
        }
        $q_offsets = array_keys($this->inner_board);
        $r_offsets = [];

        foreach ($this->inner_board as $row) {
            $r_offsets = array_merge($r_offsets, array_keys($row));
        }

        return [min($q_offsets), min($r_offsets)];
    }
}
