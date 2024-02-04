<?php

use PHPUnit\Framework\TestCase;

final class PlayerTest extends TestCase
{
    public function testGetName(): void
    {
        $name = 'Mark';
        // Arrange
        $mockPlayer = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['getName'])->getMock();

        $mockPlayer->expects($this->once())
            ->method('getName')
            ->willReturn($name);

        // Act
        $result = $mockPlayer->getName();

        // Assert
        $this->assertEquals($name, $result);
    }

    public function testGetColorClass(): void
    {
        // Arrange
        $name = 'Mark';
        $isZero = true;
        $mockPlayer = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['getColorClass'])->getMock();

        $mockPlayer->expects($this->once())
            ->method('getColorClass')
            ->willReturn('player0');

        // Act
        $result = $mockPlayer->getColorClass();

        // Assert
        $this->assertEquals('player0', $result);
    }
}
