<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class MonthTest extends TestCase
{
    public function testCreatesMySqlDateFormat(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'MONTH(my_column)',
            MySqlite::month('my_column'),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'MONTH(my_column) AS my_alias',
            MySqlite::month('my_column', 'my_alias'),
        );
    }

    public function testCreatesSqliteDateFormat(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'STRFTIME(\'%m\', my_column)',
            MySqlite::month('my_column'),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'STRFTIME(\'%m\', my_column) AS my_alias',
            MySqlite::month('my_column', 'my_alias'),
        );
    }
}
