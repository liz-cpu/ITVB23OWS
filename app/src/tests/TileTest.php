<?php

use PHPUnit\Framework\TestCase;
use game\Board;
use tiles\Tile;
use game\Player;

final class TileTest extends TestCase
{
    public function testGetPlacementsOnEmptyBoard(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $board = new Board();

        $mockTile = self::getMockBuilder(Tile::class)
            ->setConstructorArgs([$mark])
            ->onlyMethods(['getMoves'])->getMock();

        // Act
        $expected = [
            [0, 0]
        ];
        $result = $mockTile->getPlacements($board);

        // Assert
        $this->assertEquals($expected, $result);
    }

    public function testGetPlacementsIfBoardIsNotEmpty(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $lee = new Player('Lee', false);
        $board = new Board();

        $mockTile0 = self::getMockBuilder(Tile::class)
        ->setConstructorArgs([$mark])
        ->onlyMethods(['getMoves'])->getMock();

        $board->setTile(0, 0, $mockTile0);

        $mockTile1 = self::getMockBuilder(Tile::class)
        ->setConstructorArgs([$lee])
        ->onlyMethods(['getMoves'])->getMock();

        // Act
        $result = $mockTile1->getPlacements($board);

        // Assert
        $expected = [
            [1, 0], [1, -1], [0, -1], [-1, 0], [-1, 1], [0, 1]
        ];

        $this->assertEquals($expected, $result);
    }
}
