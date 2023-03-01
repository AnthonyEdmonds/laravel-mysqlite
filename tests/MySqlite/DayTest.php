<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class DayTest extends TestCase
{
    public function testCreatesMySqlDateFormat(): void
    {
        $this->asMySql();

        $this->assertEquals(
            'DAY(my_column)',
            MySqlite::day('my_column'),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertEquals(
            'DAY(my_column) AS my_alias',
            MySqlite::day('my_column', 'my_alias'),
        );
    }

    public function testCreatesSqliteDateFormat(): void
    {
        $this->asSqlite();

        $this->assertEquals(
            'STRFTIME(\'%d\', my_column)',
            MySqlite::day('my_column'),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertEquals(
            'STRFTIME(\'%d\', my_column) AS my_alias',
            MySqlite::day('my_column', 'my_alias'),
        );
    }
}
