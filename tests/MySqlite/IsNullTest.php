<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class IsNullTest extends TestCase
{
    public function testCreatesMySql(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'ISNULL(my_column, my_value)',
            MySqlite::isNull('my_column', 'my_value'),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'ISNULL(my_column, my_value) AS my_alias',
            MySqlite::isNull('my_column', 'my_value', 'my_alias'),
        );
    }

    public function testCreatesSqlite(): void
    {
        $this->asSqlite();
        $this->assertQueryExpression(
            'IFNULL(my_column, my_value)',
            MySqlite::isNull('my_column', 'my_value'),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'IFNULL(my_column, my_value) AS my_alias',
            MySqlite::isNull('my_column', 'my_value', 'my_alias'),
        );
    }
}
