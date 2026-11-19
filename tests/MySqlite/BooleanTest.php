<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class BooleanTest extends TestCase
{
    public function test(): void
    {
        $this->assertQueryExpression(
            'CASE WHEN potato = 1 THEN "Goose" ELSE "Barn" END AS family',
            MySqlite::boolean('potato', 'Goose', 'Barn', 'family'),
        );
    }
}
