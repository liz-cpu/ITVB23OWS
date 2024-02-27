<?php

use PHPUnit\Framework\TestCase;
use game\Board;
use tiles\Grasshopper;
use tiles\Queen;
use tiles\Beetle;
use game\Player;

final class GrasshopperTest extends TestCase
{
    public function testCanJumpOverTiles(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $ahmed = new Player('Ahmed', false);
        $board = new Board();

        $queen0 = new Queen($mark);
        $board->setTile(0, 0, $queen0);
        $queen1 = new Queen($ahmed);
        $board->setTile(0, 1, $queen1);
        $beetle0 = new Beetle($mark);
        $board->setTile(-1, 1, $beetle0);
        $beetle1 = new Beetle($ahmed);
        $board->setTile(-1, 0, $beetle1);
        $beetle2 = new Beetle($mark);
        $board->setTile(1, 1, $beetle2);
        $beetle3 = new Beetle($ahmed);
        $board->setTile(0, 2, $beetle3);
        $grasshopper = new Grasshopper($mark);
        $board->setTile(-2, 1, $grasshopper);

        // Act
        $result = $grasshopper->isValidMove($board, -2, 1, 0, -1);


        $this->assertTrue($result);
    }


    public function testCannotJumpSlanted(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $ahmed = new Player('Ahmed', false);
        $board = new Board();

        $queen0 = new Queen($mark);
        $board->setTile(0, 0, $queen0);
        $queen1 = new Queen($ahmed);
        $board->setTile(0, 1, $queen1);
        $beetle0 = new Beetle($mark);
        $board->setTile(-1, 1, $beetle0);
        $beetle1 = new Beetle($ahmed);
        $board->setTile(-1, 0, $beetle1);
        $beetle2 = new Beetle($mark);
        $board->setTile(1, 1, $beetle2);
        $beetle3 = new Beetle($ahmed);
        $board->setTile(0, 2, $beetle3);
        $grasshopper = new Grasshopper($mark);
        $board->setTile(-2, 1, $grasshopper);

        // Act
        $result0 = $grasshopper->isValidMove($board, -2, 1, 1, 0);
        $result1 = $grasshopper->isValidMove($board, -2, 1, 1, 2);


        $this->assertFalse($result0);
        $this->assertFalse($result1);
    }
}
