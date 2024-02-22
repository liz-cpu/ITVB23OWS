<?php

namespace tiles;

use game\Board;

final class Queen extends Tile
{
    protected string $type_value = 'Q';

    public function getMoves(Board $board, int $q, int $r): array
    {
        if ($this->z < 0) {
            return [];
        }
        $offsets = [
            [1, 0], [1, -1], [0, -1], [-1, 0], [-1, 1], [0, 1]
        ];

        $moves = [];

        foreach ($offsets as $offset) {
            $q_offset = $offset[0];
            $r_offset = $offset[1];

            $q_new = $q + $q_offset;
            $r_new = $r + $r_offset;

            if ($board->isTileEmpty($q_new, $r_new)) {
                $moves[] = [$q_new, $r_new];
            }
        }

        return $moves;
    }

    // public function getPlacements(Board $board): array
    // {
    //     $offsets = [
    //         [1, 0], [1, -1], [0, -1], [-1, 0], [-1, 1], [0, 1]
    //     ];

    //     if ($board->isEmpty()) {
    //         return [[0, 0]];
    //     }

    //     if ($board->getTile(0, 0)->getPlayer() !== $this->player) {
    //         return [[1, 0], [1, -1], [0, -1], [-1, 0], [-1, 1], [0, 1]];
    //     }
    //     return [];
    // }
}
