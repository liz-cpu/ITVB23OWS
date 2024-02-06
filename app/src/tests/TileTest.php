<?php

use PHPUnit\Framework\TestCase;

final class TileTest extends TestCase
{
    public function testGetPlacementsOnEmptyBoard(): void
    {
        // Arrange
        $mockPlayer = $this->getMockBuilder(\stdClass::class)->getMock();
        $mockBoard = $this->getMockBuilder(\stdClass::class)->getMock();

        $mockTile = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['getPlacements'])->getMock();

        $mockTile->expects($this->once())
            ->method('getPlacements')
            ->with($mockBoard)
            ->willReturn([[0, 0]]);

        // Act
        $expected = [
            [0, 0]
        ];
        $result = $mockTile->getPlacements($mockBoard);

        // Assert
        $this->assertEquals($expected, $result);
    }

    public function testGetPlacementsIfBoardIsNotEmpty(): void
    {
        // Arrange
        $mark = $this->getMockBuilder(\stdClass::class)->getMock();
        $lee = $this->getMockBuilder(\stdClass::class)->getMock();
        $mockBoard = $this->getMockBuilder(\stdClass::class)->addMethods(['setTile'])->getMock();

        $mockTile0 = $this->getMockBuilder(\stdClass::class)->getMock();

        $mockBoard->setTile(0, 0, $mockTile0);

        $mockTile1 = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['getPlacements'])->getMock();

        $mockTile1->expects($this->once())
            ->method('getPlacements')
            ->with($mockBoard)
            ->willReturn([
                [1, 0], [1, -1], [0, -1], [-1, 0], [-1, 1], [0, 1]
            ]);
        // Act
        $result = $mockTile1->getPlacements($mockBoard);

        // Assert
        $expected = [
            [1, 0], [1, -1], [0, -1], [-1, 0], [-1, 1], [0, 1]
        ];

        $this->assertEquals($expected, $result);
    }
}
