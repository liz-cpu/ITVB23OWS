<?php

namespace tiles;

use game\Board;

final class Beetle extends Tile
{
    protected string $type_value = 'B';

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


            $moves[] = [$q_new, $r_new];
        }

        return $moves;
    }
}
