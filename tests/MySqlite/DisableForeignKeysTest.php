<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class DisableForeignKeysTest extends TestCase
{
    public function testOutputsMySql(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'SET FOREIGN_KEY_CHECKS=0',
            MySqlite::disableForeignKeys(),
        );
    }

    public function testOutputsSqlite(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'PRAGMA foreign_keys = 0',
            MySqlite::disableForeignKeys(),
        );
    }
}
