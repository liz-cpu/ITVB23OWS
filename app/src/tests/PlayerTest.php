<?php

use PHPUnit\Framework\TestCase;
use tiles\Tile;
use game\Player;

final class PlayerTest extends TestCase
{
    public function testGetName(): void
    {
        // Arrange
        $name = 'Mark';
        $isZero = true;
        $player = new Player($name, $isZero);

        // Act
        $result = $player->getName();

        // Assert
        $this->assertEquals($name, $result);
    }

    public function testGetColorClass(): void
    {
        // Arrange
        $name = 'Mark';
        $isZero = true;
        $player = new Player($name, $isZero);

        // Act
        $result = $player->getColorClass();

        // Assert
        $this->assertEquals('player0', $result);
    }
}
