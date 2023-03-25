<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class CastTest extends TestCase
{
    public function testThrowsExceptionWhenWrongType(): void
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Potato is not a recognised MySQL cast type');

        MySqlite::cast('my_column', 'Potato');
    }

    public function testCreatesMySqlCast(): void
    {
        $this->asMySql();

        $this->assertEquals(
            'CAST(my_column AS CHAR)',
            MySqlite::cast('my_column', MySqlite::CHAR),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertEquals(
            'CAST(my_column AS CHAR) AS my_alias',
            MySqlite::cast('my_column', MySqlite::CHAR, 'my_alias'),
        );
    }

    public function testCreatesSqliteCast(): void
    {
        $this->asSqlite();

        $this->assertEquals(
            'CAST(my_column AS TEXT)',
            MySqlite::cast('my_column', MySqlite::CHAR),
        );
    }

    public function testCreatesSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertEquals(
            'CAST(my_column AS TEXT) AS my_alias',
            MySqlite::cast('my_column', MySqlite::CHAR, 'my_alias'),
        );
    }
}
