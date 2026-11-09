<?php

namespace App\Tests\Entity;


use PHPUnit\Framework\TestCase;

final class TestAvantCodeTest extends TestCase
{
    public function testParDefaut(): void
    {
        $this->assertSame(10,10);
    }
}

