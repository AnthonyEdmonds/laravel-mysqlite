<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class JsonUnquoteTest extends TestCase
{
    public function testCreatesMySql(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'JSON_UNQUOTE(my_column)',
            MySqlite::jsonUnquote('my_column')
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'JSON_UNQUOTE(my_column) AS my_alias',
            MySqlite::jsonUnquote('my_column', 'my_alias')
        );
    }

    public function testCreatesSqlite(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'TRIM(my_column, """")',
            MySqlite::jsonUnquote('my_column')
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'TRIM(my_column, """") AS my_alias',
            MySqlite::jsonUnquote('my_column', 'my_alias')
        );
    }
}
