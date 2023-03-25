<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class HourTest extends TestCase
{
    public function testCreatesMySqlDateFormat(): void
    {
        $this->asMySql();

        $this->assertEquals(
            'HOUR(my_column)',
            MySqlite::hour('my_column'),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertEquals(
            'HOUR(my_column) AS my_alias',
            MySqlite::hour('my_column', 'my_alias'),
        );
    }

    public function testCreatesSqliteDateFormat(): void
    {
        $this->asSqlite();

        $this->assertEquals(
            'STRFTIME(\'%H\', my_column)',
            MySqlite::hour('my_column'),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertEquals(
            'STRFTIME(\'%H\', my_column) AS my_alias',
            MySqlite::hour('my_column', 'my_alias'),
        );
    }
}
