<?php

namespace game;

use tiles\Tile;
use game\Player;

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
        if (!isset($this->inner_board[$q][$r])) {
            return null;
        }
        $tiles_at_coordinates = $this->inner_board[$q][$r];

        return reset($tiles_at_coordinates);
    }


    /**
     * Set the tile at the given coordinates.
     * @param int $q The q-offset.
     * @param int $r The r-offset.
     * @param Tile $tile The tile to set.
     */
    public function setTile(int $q, int $r, Tile $tile): void
    {
        if (!isset($this->inner_board[$q][$r])) {
            $this->inner_board[$q][$r] = [];
        }

        $the_stack = $this->inner_board[$q][$r];

        array_unshift($the_stack, $tile);

        $this->updateZCoordinates($the_stack);

        $this->inner_board[$q][$r] = $the_stack;
    }


    /**
     * Set the correct Z-values to the tiles in an array.
     * The first tile in the array will have a Z-value of 1, the second -1,
     * the third -2, and so on. If there is only one tile in the array, its
     * Z-value will be 0.
     * @param array $tiles The array of tiles.
     * @return void
     */
    private function updateZCoordinates(array $tiles): void
    {
        if (count($tiles) === 1) {
            $tiles[0]->setZ(0);
        } else {
            $tiles[0]->setZ(1);
            for ($i = 1; $i < count($tiles); $i++) {
                $tiles[$i]->setZ(-$i);
            }
        }
    }


    public function removeTile(int $q, int $r): ?Tile
    {
        if (!isset($this->inner_board[$q][$r])) {
            return null;
        }

        $stacked_tiles = $this->inner_board[$q][$r];

        if (count($stacked_tiles) > 1) {
            $tile = array_shift($stacked_tiles);
            $this->updateZCoordinates($stacked_tiles);
            $this->inner_board[$q][$r] = $stacked_tiles;
            return $tile;
        } else {
            $tile = array_shift($stacked_tiles);
            unset($this->inner_board[$q][$r]);
            return $tile;
        }
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
