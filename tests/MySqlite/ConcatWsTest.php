<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class ConcatWsTest extends TestCase
{
    public function testCreates(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'CONCAT_WS(", ", first_column, "second_column", third_column)',
            MySqlite::concatWs(
                ['first_column', '"second_column"', 'third_column'],
            ),
        );
    }

    public function testAppendsAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'CONCAT_WS("; ", first_column, "second_column", third_column) AS my_alias',
            MySqlite::concatWs(
                ['first_column', '"second_column"', 'third_column'],
                '; ',
                'my_alias',
            ),
        );
    }
}
