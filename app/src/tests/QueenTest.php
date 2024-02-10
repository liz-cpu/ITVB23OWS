<?php

use PHPUnit\Framework\TestCase;
use game\Board;
use tiles\Queen;
use game\Player;

final class QueenTest extends TestCase
{
    public function testMovingToAnOccupiedTileIsNotAllowed(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $board = new Board();
        $queen = new Queen($mark);
        $q = 0;
        $r = 0;

        $board->setTile($q, $r, $queen);

        // Act
        $result = $queen->isValidMove($board, $q, $r, 0, 0);

        // Assert
        $this->assertFalse($result);
    }

    // Issue 2When playing the white queen at (0, 0) and black at (1, 0),
    // attempting to move the white queen to (0, 1) is not allowed, though it
    // should be a legal move
    public function testFixIncorrectMoveLegality(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $leah = new Player('Leah', false);
        $board = new Board();

        $queen = new Queen($mark);
        $board->setTile(0, 0, $queen);
        $board->setTile(1, 0, new Queen($leah));

        // Act
        $result = $queen->isValidMove($board, 0, 0, 0, 1);

        // Assert
        $this->assertTrue($result);
    }

    public function testGetMovesIfSomeNeighboursAreOccupied(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $leah = new Player('Leah', false);
        $board = new Board();

        $queen = new Queen($mark);
        $board->setTile(0, 0, $queen);
        $board->setTile(1, 0, new Queen($leah));
        $board->setTile(-1, 1, new Queen($mark));
        $board->setTile(-1, 0, new Queen($leah));

        // Act
        $result = $queen->isValidMove($board, 0, 0, 0, 1);

        // Assert

        $this->assertTrue($result);
    }
}
