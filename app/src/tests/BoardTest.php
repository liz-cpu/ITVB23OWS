<?php

use PHPUnit\Framework\TestCase;
use game\Board;
use tiles\Tile;
use game\Player;

final class BoardTest extends TestCase
{
    public function testSetTile(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $board = new Board();

        $mockTile = self::getMockBuilder(Tile::class)
            ->setConstructorArgs([$mark])
            ->onlyMethods(['getMoves'])->getMock();

        // Act
        $board->setTile(0, 0, $mockTile);
        $result = $board->getTile(0, 0);

        // Assert
        $this->assertEquals($mockTile, $result);
    }

    public function testIsEmpty(): void
    {
        // Arrange
        $board = new Board();

        // Act
        $result = $board->isEmpty();

        // Assert
        $this->assertTrue($result);
    }

    public function testIsTileEmpty(): void
    {
        // Arrange
        $board = new Board();

        $mockTile = self::getMockBuilder(Tile::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getMoves'])->getMock();

        $board->setTile(0, 0, $mockTile);

        // Act
        $result = $board->isTileEmpty(0, -1);

        // Assert
        $this->assertTrue($result);
    }

    public function testGetTile(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $board = new Board();

        $mockTile = self::getMockBuilder(Tile::class)
            ->setConstructorArgs([$mark])
            ->onlyMethods(['getMoves'])->getMock();

        $board->setTile(0, 0, $mockTile);

        // Act
        $result = $board->getTile(0, 0);

        // Assert
        $this->assertEquals($mockTile, $result);
    }

    public function testRemoveTile(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $board = new Board();

        $mockTile = self::getMockBuilder(Tile::class)
            ->setConstructorArgs([$mark])
            ->onlyMethods(['getMoves'])->getMock();

        $board->setTile(0, 0, $mockTile);

        // Act
        $resultTile = $board->removeTile(0, 0);
        $resultIsEmpty = $board->isTileEmpty(0, 0);

        // Assert
        $this->assertEquals($mockTile, $resultTile);
        $this->assertTrue($resultIsEmpty);
    }
}
