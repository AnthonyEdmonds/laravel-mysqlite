<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class TrimTest extends TestCase
{
    public function testCreatesMySql(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'TRIM(BOTH "," FROM my_column)',
            MySqlite::trim('","', 'my_column'),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'TRIM(LEADING "," FROM my_column) AS my_alias',
            MySqlite::trim(
                '","',
                'my_column',
                'my_alias',
                MySqlite::TRIM_LEADING,
            ),
        );
    }

    public function testCreatesSqlite(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'TRIM(my_column, ",")',
            MySqlite::trim('","', 'my_column'),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'LTRIM(my_column, ",") AS my_alias',
            MySqlite::trim(
                '","',
                'my_column',
                'my_alias',
                MySqlite::TRIM_LEADING,
            ),
        );
    }
}
