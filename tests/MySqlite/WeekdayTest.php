<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class WeekdayTest extends TestCase
{
    public function testCreatesMySqlDateFormat(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'WEEKDAY(my_column)',
            MySqlite::weekday('my_column'),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'WEEKDAY(my_column) AS my_alias',
            MySqlite::weekday('my_column', 'my_alias'),
        );
    }

    public function testCreatesSqliteDateFormat(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            '(STRFTIME(\'%u\', my_column) - 1)',
            MySqlite::weekday('my_column'),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            '(STRFTIME(\'%u\', my_column) - 1) AS my_alias',
            MySqlite::weekday('my_column', 'my_alias'),
        );
    }
}
