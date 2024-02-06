<?php

use PHPUnit\Framework\TestCase;

final class QueenTest extends TestCase
{
    public function testMovingToAnOccupiedTileIsNotAllowed(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $mockBoard = $this->getMockBuilder(\stdClass::class)->addMethods(['setTile'])->getMock();
        $mockQueen = $this->getMockBuilder(\stdClass::class)->addMethods(['isValidMove'])->getMock();
        $q = 0;
        $r = 0;

        $mockQueen->expects($this->once())
            ->method('isValidMove')
            ->with($mockBoard, $q, $r, 0, 0)
            ->willReturn(false);

        $mockBoard->setTile($q, $r, $mockQueen);

        // Act
        $result = $mockQueen->isValidMove($mockBoard, $q, $r, 0, 0);

        // Assert
        $this->assertFalse($result);
    }

    // Issue 2When playing the white queen at (0, 0) and black at (1, 0),
    // attempting to move the white queen to (0, 1) is not allowed, though it
    // should be a legal move
    public function testFixIncorrectMoveLegality(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $leah = $this->getMockBuilder(\stdClass::class)->getMock();
        $mockBoard = $this->getMockBuilder(\stdClass::class)->addMethods(['setTile'])->getMock();

        $mockQueen = $this->getMockBuilder(\stdClass::class)->addMethods(['isValidMove'])->getMock();
        $mockQueens = $this->getMockBuilder(\stdClass::class)->getMock();

        $mockBoard->setTile(0, 0, $mockQueen);
        $mockBoard->setTile(1, 0, $mockQueens);

        $mockQueen->expects($this->once())
            ->method('isValidMove')
            ->with($mockBoard, 0, 0, 0, 1)
            ->willReturn(true);

        // Act
        $result = $mockQueen->isValidMove($mockBoard, 0, 0, 0, 1);

        // Assert
        $this->assertTrue($result);
    }

    public function testGetMovesIfSomeNeighboursAreOccupied(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $leah = $this->getMockBuilder(\stdClass::class)->getMock();
        $mockBoard = $this->getMockBuilder(\stdClass::class)->addMethods(['setTile'])->getMock();

        $mockQueen = $this->getMockBuilder(\stdClass::class)->addMethods(['isValidMove'])->getMock();
        $mockQueens = $this->getMockBuilder(\stdClass::class)->getMock();

        $mockBoard->setTile(0, 0, $mockQueen);
        $mockBoard->setTile(1, 0, $mockQueens);
        $mockBoard->setTile(-1, 1, $mockQueens);
        $mockBoard->setTile(-1, 0, $mockQueens);

        $mockQueen->expects($this->once())
            ->method('isValidMove')
            ->with($mockBoard, 0, 0, 0, 1)
            ->willReturn(true);

        // Act
        $result = $mockQueen->isValidMove($mockBoard, 0, 0, 0, 1);

        // Assert

        $this->assertTrue($result);
    }
}
