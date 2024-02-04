<?php

use PHPUnit\Framework\TestCase;

final class BoardTest extends TestCase
{
    public function testSetTile(): void
    {
        // Arrange
        $mockPlayer = $this->getMockBuilder(\stdClass::class)
            ->getMock();

        $mockTile = $this->getMockBuilder(\stdClass::class)
            ->getMock();

        $mockBoard = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['getTile', 'setTile'])->getMock();

        $mockBoard->expects($this->once())
            ->method('getTile')
            ->willReturn($mockTile);

        $mockBoard->setTile(0, 0, $mockTile);

        // Act

        $result = $mockBoard->getTile(0, 0, $mockTile);

        // Assert
        $this->assertEquals($mockTile, $result);
    }

    public function testIsEmpty(): void
    {
        // Arrange
        $mockBoard = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['isEmpty'])
            ->getMock();

        $mockBoard->expects($this->once())
            ->method('isEmpty')
            ->willReturn(true);

        // Act
        $result = $mockBoard->isEmpty();

        // Assert
        $this->assertTrue($result);
    }

    public function testIsTileEmpty(): void
    {
        // Arrange
        $mockBoard = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['isTileEmpty', 'setTile'])
            ->getMock();

        $mockBoard->expects($this->once())
            ->method('isTileEmpty')
            ->willReturn(true);

        $mockTile = $this->getMockBuilder(\stdClass::class)
            ->getMock();

        $mockBoard->setTile(0, 0, $mockTile);

        // Act
        $result = $mockBoard->isTileEmpty(0, -1);

        // Assert
        $this->assertTrue($result);
    }

    public function testGetTile(): void
    {
        // Arrange
        $mockPlayer = $this->getMockBuilder(\stdClass::class)
            ->getMock();

        $mockBoard = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['getTile', 'setTile'])
            ->getMock();
        $mockTile = $this->getMockBuilder(\stdClass::class)
            ->getMock();
        $mockBoard->expects($this->once())
            ->method('getTile')
            ->willReturn($mockTile);



        $mockBoard->setTile(0, 0, $mockTile);
        // Act
        $result = $mockBoard->getTile(0, 0);
        // Assert
        $this->assertEquals($mockTile, $result);
    }

    public function testRemoveTile(): void
    {
        // Arrange
        $mockPlayer = $this->getMockBuilder(\stdClass::class)
            ->getMock();
        $mockBoard = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['removeTile', 'setTile', 'isTileEmpty'])
            ->getMock();

        $mockTile = $this->getMockBuilder(\stdClass::class)
            ->getMock();

        $mockBoard->expects($this->once())
            ->method('removeTile')
            ->willReturn($mockTile);

        $mockBoard->expects($this->once())
            ->method('isTileEmpty')
            ->willReturn(true);


        $mockBoard->setTile(0, 0, $mockTile);

        // Act
        $resultTile = $mockBoard->removeTile(0, 0);
        $resultIsEmpty = $mockBoard->isTileEmpty(0, 0);

        // Assert
        $this->assertEquals($mockTile, $resultTile);
        $this->assertTrue($resultIsEmpty);
    }
}
