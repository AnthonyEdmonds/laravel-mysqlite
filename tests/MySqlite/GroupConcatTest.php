<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class GroupConcatTest extends TestCase
{
    public function testCreatesMySql(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'GROUP_CONCAT(first_column SEPARATOR :)',
            MySqlite::groupConcat(
                ['first_column'],
                ':',
            ),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();

        $this->assertQueryExpression(
            'GROUP_CONCAT(first_column SEPARATOR :) AS my_alias',
            MySqlite::groupConcat(
                ['first_column'],
                ':',
                'my_alias',
            ),
        );
    }

    public function testCreatesSqlite(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'GROUP_CONCAT(first_column, :)',
            MySqlite::groupConcat(
                ['first_column'],
                ':',
            ),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();

        $this->assertQueryExpression(
            'GROUP_CONCAT(first_column, :) AS my_alias',
            MySqlite::groupConcat(
                ['first_column'],
                ':',
                'my_alias',
            ),
        );
    }
}
