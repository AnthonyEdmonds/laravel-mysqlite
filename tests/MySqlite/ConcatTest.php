<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class ConcatTest extends TestCase
{
    public function testCreatesMySql(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'CONCAT(first_column,"second_column",third_column)',
            MySqlite::concat(
                ['first_column', '"second_column"', 'third_column'],
            ),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'CONCAT(first_column,"second_column",third_column) AS my_alias',
            MySqlite::concat(
                ['first_column', '"second_column"', 'third_column'],
                'my_alias',
            ),
        );
    }

    public function testCreatesSqlite(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'first_column || "second_column" || third_column',
            MySqlite::concat(
                ['first_column', '"second_column"', 'third_column'],
            ),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'first_column || "second_column" || third_column AS my_alias',
            MySqlite::concat(
                ['first_column', '"second_column"', 'third_column'],
                'my_alias',
            ),
        );
    }
}
