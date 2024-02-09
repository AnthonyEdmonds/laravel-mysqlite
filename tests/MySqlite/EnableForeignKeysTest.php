<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class EnableForeignKeysTest extends TestCase
{
    public function testOutputsMySql(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'SET FOREIGN_KEY_CHECKS=1',
            MySqlite::enableForeignKeys(),
        );
    }

    public function testOutputsSqlite(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'PRAGMA foreign_keys = 1',
            MySqlite::enableForeignKeys(),
        );
    }
}
