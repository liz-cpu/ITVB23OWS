<?php

use PHPUnit\Framework\TestCase;

final class BeetleTest extends TestCase
{
    public function testMovingToAnUnoccupiedTileIsAllowed(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $board = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['setTile'])
            ->getMock();

        $queen = $this->getMockBuilder(\stdClass::class)->getMock();
        $beetle = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['isValidMove'])
            ->getMock();

        $mockTile = $this->getMockBuilder(\stdClass::class)->getMock();

        $board->setTile(0, 0, $queen);
        $board->setTile(0, 1, $beetle);

        $beetle->expects($this->once())
            ->method('isValidMove')
            ->with($board, 0, 1, 1, 0)
            ->willReturn(true);

        //Act
        $result = $beetle->isValidMove($board, 0, 1, 1, 0);

        //Assert
        $this->assertTrue($result);
    }

    public function testGetMovesWhenYouCanStackOnTopOfAnotherTile(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $zina = $this->getMockBuilder(\stdClass::class)->getMock();
        $board = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['setTile'])
            ->getMock();

        $beetle = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['getMoves'])
            ->getMock();

        $mockTile = $this->getMockBuilder(\stdClass::class)->getMock();

        $board->setTile(0, 0, $mockTile);
        $board->setTile(1, 0, $mockTile);
        $board->setTile(0, 1, $beetle);

        $beetle->expects($this->once())
            ->method('getMoves')
            ->with($board, 0, 1)
            ->willReturn([[1, 0], [-1, 1]]);

        // Act
        $result = $beetle->getMoves($board, 0, 1);

        // Assert
        $expected = [
            [1, 0], [-1, 1]
        ];
        $this->assertEquals($expected, $result);
    }

    public function testTileCannotMoveIfStackedUpon(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $zina = $this->getMockBuilder(\stdClass::class)->getMock();
        $board = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['setTile'])
            ->getMock();

        $beetleBot = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['isValidMove'])
            ->getMock();

        $beetleTop = $this->getMockBuilder(\stdClass::class)->getMock();

        $mockTile = $this->getMockBuilder(\stdClass::class)->getMock();

        $board->setTile(0, 0, $mockTile);
        $board->setTile(1, 0, $mockTile);
        $board->setTile(0, 1, $beetleBot);
        $board->setTile(0, 1, $beetleTop);

        $beetleBot->expects($this->once())
            ->method('isValidMove')
            ->with($board, 0, 1, 0, 0)
            ->willReturn(false);

        // Act
        $result = $beetleBot->isValidMove($board, 0, 1, 0, 0);

        // Assert
        $this->assertFalse($result);
    }

    public function testTileCanMoveIfItsTopOfStack(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $zina = $this->getMockBuilder(\stdClass::class)->getMock();
        $board = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['setTile'])
            ->getMock();

        $beetleBot = $this->getMockBuilder(\stdClass::class)->getMock();
        $beetleTop = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['isValidMove'])
            ->getMock();

        $mockTile = $this->getMockBuilder(\stdClass::class)->getMock();

        $board->setTile(0, 0, $mockTile);
        $board->setTile(1, 0, $mockTile);
        $board->setTile(0, 1, $beetleBot);
        $board->setTile(0, 1, $beetleTop);

        $beetleTop->expects($this->once())
            ->method('isValidMove')
            ->with($board, 0, 1, -1, 1)
            ->willReturn(true);

        // Act
        $result = $beetleTop->isValidMove($board, 0, 1, -1, 1);

        // Assert
        $this->assertTrue($result);
    }

    public function testTileCanMoveIfItsTopOfAVeryHighStack(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $zina = $this->getMockBuilder(\stdClass::class)->getMock();
        $board = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['setTile'])
            ->getMock();

        $beetleHighest = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['getMoves'])
            ->getMock();

        $mockTile = $this->getMockBuilder(\stdClass::class)->getMock();


        $board->setTile(1, -1, $mockTile);
        $board->setTile(0, 0, $mockTile);
        $board->setTile(1, -1, $mockTile);
        $board->setTile(1, -1, $mockTile);
        $board->setTile(1, -1, $mockTile);
        $board->setTile(1, -1, $beetleHighest);

        $beetleHighest->expects($this->once())
            ->method('getMoves')
            ->with($board, 1, -1)
            ->willReturn([[0, -1], [1, 0]]);

        // Act
        $result = $beetleHighest->getMoves($board, 1, -1);

        // Assert
        $expected = [
            [0, -1], [1, 0]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testTileCannotMoveIfItsNotTopOfStack(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $zina = $this->getMockBuilder(\stdClass::class)->getMock();
        $board = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['setTile'])
            ->getMock();

        $queenFoundation = $this->getMockBuilder(\stdClass::class)->addMethods(['getMoves'])->getMock();
        $beetleOnQueen = $this->getMockBuilder(\stdClass::class)->addMethods(['getMoves'])->getMock();
        $beetleOnTopOfBeetleOnQueen = $this->getMockBuilder(\stdClass::class)->addMethods(['getMoves'])->getMock();
        $beetleEvenHigher = $this->getMockBuilder(\stdClass::class)->addMethods(['getMoves'])->getMock();
        $beetleHighest = $this->getMockBuilder(\stdClass::class)->addMethods(['getMoves'])->getMock();

        $queenFoundation->expects($this->once())
            ->method('getMoves')
            ->with($board, 1, -1)
            ->willReturn([]);
        $beetleOnQueen->expects($this->once())
            ->method('getMoves')
            ->with($board, 1, -1)
            ->willReturn([]);
        $beetleOnTopOfBeetleOnQueen->expects($this->once())
            ->method('getMoves')
            ->with($board, 1, -1)
            ->willReturn([]);
        $beetleEvenHigher->expects($this->once())
            ->method('getMoves')
            ->with($board, 1, -1)
            ->willReturn([]);
        $beetleHighest->expects($this->once())
            ->method('getMoves')
            ->with($board, 1, -1)
            ->willReturn([]);

        $mockTile = $this->getMockBuilder(\stdClass::class)->getMock();

        $board->setTile(1, -1, $queenFoundation);
        $board->setTile(0, 0, $mockTile);
        $board->setTile(1, -1, $beetleOnQueen);
        $board->setTile(1, -1, $beetleOnTopOfBeetleOnQueen);
        $board->setTile(1, -1, $beetleEvenHigher);
        $board->setTile(1, -1, $beetleHighest);

        // Act
        $result1 = $queenFoundation->getMoves($board, 1, -1);
        $result2 = $beetleOnQueen->getMoves($board, 1, -1);
        $result3 = $beetleOnTopOfBeetleOnQueen->getMoves($board, 1, -1);
        $result4 = $beetleEvenHigher->getMoves($board, 1, -1);
        $result5 = $beetleHighest->getMoves($board, 1, -1);

        // Assert
        $expected = [];

        $this->assertEquals($expected, $result1);
        $this->assertEquals($expected, $result2);
        $this->assertEquals($expected, $result3);
        $this->assertEquals($expected, $result4);
        $this->assertEquals($expected, $result5);
    }
}
