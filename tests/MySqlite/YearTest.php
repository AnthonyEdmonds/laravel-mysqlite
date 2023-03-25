<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class YearTest extends TestCase
{
    public function testCreatesMySqlDateFormat(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'YEAR(my_column)',
            MySqlite::year('my_column'),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'YEAR(my_column) AS my_alias',
            MySqlite::year('my_column', 'my_alias'),
        );
    }

    public function testCreatesSqliteDateFormat(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'STRFTIME(\'%Y\', my_column)',
            MySqlite::year('my_column'),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'STRFTIME(\'%Y\', my_column) AS my_alias',
            MySqlite::year('my_column', 'my_alias'),
        );
    }
}
