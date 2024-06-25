<?php

declare(strict_types=1);

namespace TwentyI\API\Test;

use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    public function test(): void
    {
        $this->assertTrue(
            class_exists("TwentyI\API\Authentication"),
            "Authentication: loads"
        );
        $this->assertTrue(
            class_exists("TwentyI\API\ControlPanel"),
            "ControlPanel: loads"
        );
        $this->assertTrue(
            class_exists("TwentyI\API\Services"),
            "Services: loads"
        );
    }
}
