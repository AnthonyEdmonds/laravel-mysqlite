<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class DateDiffTest extends TestCase
{
    public function testCreatesMySqlDateFormat(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'DATEDIFF(from_column, to_column)',
            MySqlite::dateDiff('from_column', 'to_column'),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'DATEDIFF(from_column, to_column) AS my_alias',
            MySqlite::dateDiff('from_column', 'to_column', 'my_alias'),
        );
    }

    public function testCreatesSqliteDateFormat(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            '(JULIANDAY(from_column) - JULIANDAY(to_column))',
            MySqlite::dateDiff('from_column', 'to_column'),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            '(JULIANDAY(from_column) - JULIANDAY(to_column)) AS my_alias',
            MySqlite::dateDiff('from_column', 'to_column', 'my_alias'),
        );
    }
}
