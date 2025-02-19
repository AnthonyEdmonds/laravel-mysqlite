<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\Expression;
use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class MidTest extends TestCase
{
    public function testCreatesMySql(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'MID(my_column, 5, 3)',
            MySqlite::mid('my_column', 5, 3),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'MID(my_column, 5, 3) AS my_alias',
            MySqlite::mid('my_column', '5', '3', 'my_alias'),
        );
    }

    public function testCreatesSqlite(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'SUBSTR(my_column, start_column, length_column)',
            MySqlite::mid('my_column', new Expression('start_column'), new Expression('length_column')),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'SUBSTR(my_column, 5, 3) AS my_alias',
            MySqlite::mid('my_column', 5, 3, 'my_alias'),
        );
    }
}
