<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class SetAutoIncrementTest extends TestCase
{
    public function testCreatesMySql(): void
    {
        $this->asMySql();

        $this->assertEquals(
            'ALTER TABLE my_table AUTO_INCREMENT = 3',
            MySqlite::setAutoIncrement('my_table', 3)
        );
    }
    
    public function testCreatesSqlite(): void
    {
        $this->asSqlite();

        $this->assertEquals(
            'UPDATE sqlite_sequence SET seq = 3 WHERE name = \'my_table\'',
            MySqlite::setAutoIncrement('my_table', 3)
        );
    }
}
