<?php

use PHPUnit\Framework\TestCase;
use game\Board;
use tiles\Queen;
use tiles\Beetle;
use game\Player;

final class BeetleTest extends TestCase
{
    public function testMovingToAnUnoccupiedTileIsAllowed(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $board = new Board();

        $queen = new Queen($mark);
        $beetle = new Beetle($mark);

        $board->setTile(0, 0, $queen);
        $board->setTile(0, 1, $beetle);

        //Act
        $result = $beetle->isValidMove($board, 0, 1, 1, 0);

        //Assert
        $this->assertTrue($result);
    }

    public function testGetMovesWhenYouCanStackOnTopOfAnotherTile(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $zina = new Player('Zina', false);
        $board = new Board();

        $board->setTile(0, 0, new Queen($mark));
        $board->setTile(1, 0, new Beetle($zina));

        $beetle = new Beetle($mark);
        $board->setTile(0, 1, $beetle);

        // Act
        $result = $beetle->isValidMove($board, 0, 1, 1, 0);

        $this->assertTrue($result);
    }

    public function testTileCannotMoveIfStackedUpon(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $zina = new Player('Zina', false);
        $board = new Board();

        $board->setTile(0, 0, new Queen($mark));
        $board->setTile(1, 0, new Queen($zina));

        $beetleBot = new Beetle($mark);
        $board->setTile(0, 1, $beetleBot);
        $beetleTop = new Beetle($mark);
        $board->setTile(0, 1, $beetleTop);

        // Act
        $result = $beetleBot->isValidMove($board, 0, 1, 0, 0);

        // Assert
        $this->assertFalse($result);
    }

    public function testTileCanMoveIfItsTopOfStack(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $zina = new Player('Zina', false);
        $board = new Board();

        $board->setTile(0, 0, new Queen($mark));
        $board->setTile(1, 0, new Queen($zina));

        $beetleBot = new Beetle($mark);
        $board->setTile(0, 1, $beetleBot);
        $beetleTop = new Beetle($mark);
        $board->setTile(0, 1, $beetleTop);

        // Act
        $result = $beetleTop->isValidMove($board, 0, 1, -1, 1);

        // Assert
        $this->assertTrue($result);
    }

    public function testTileCanMoveIfItsTopOfAVeryHighStack(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $zina = new Player('Zina', false);
        $board = new Board();

        $queenFoundation = new Queen($mark);
        $board->setTile(1, -1, $queenFoundation);
        $queenUnstacked = new Queen($zina);
        $board->setTile(0, 0, $queenUnstacked);
        $beetleOnQueen = new Beetle($mark);
        $board->setTile(1, -1, $beetleOnQueen);
        $beetleOnTopOfBeetleOnQueen = new Beetle($zina);
        $board->setTile(1, -1, $beetleOnTopOfBeetleOnQueen);
        $beetleEvenHigher = new Beetle($mark);
        $board->setTile(1, -1, $beetleEvenHigher);
        $beetleHighest = new Beetle($zina);
        $board->setTile(1, -1, $beetleHighest);

        // Act
        $result = $beetleHighest->isValidMove($board, 1, -1, 0, -1);

        $this->assertTrue($result);
    }

    public function testTileCannotMoveIfItsNotTopOfStack(): void
    {
        // Arrange
        $mark = new Player('Mark', true);
        $zina = new Player('Zina', false);
        $board = new Board();

        $queenFoundation = new Queen($mark);
        $board->setTile(1, -1, $queenFoundation);
        $queenUnstacked = new Queen($zina);
        $board->setTile(0, 0, $queenUnstacked);
        $beetleOnQueen = new Beetle($mark);
        $board->setTile(1, -1, $beetleOnQueen);
        $beetleOnTopOfBeetleOnQueen = new Beetle($zina);
        $board->setTile(1, -1, $beetleOnTopOfBeetleOnQueen);
        $beetleEvenHigher = new Beetle($mark);
        $board->setTile(1, -1, $beetleEvenHigher);
        $beetleHighest = new Beetle($zina);
        $board->setTile(1, -1, $beetleHighest);

        // Act
        $result1 = $queenFoundation->getMoves($board, 1, -1);
        $result2 = $beetleOnQueen->getMoves($board, 1, -1);
        $result3 = $beetleOnTopOfBeetleOnQueen->getMoves($board, 1, -1);
        $result4 = $beetleEvenHigher->getMoves($board, 1, -1);

        // Assert
        $expected = [];

        $this->assertEquals($expected, $result1);
        $this->assertEquals($expected, $result2);
        $this->assertEquals($expected, $result3);
        $this->assertEquals($expected, $result4);
    }
}
