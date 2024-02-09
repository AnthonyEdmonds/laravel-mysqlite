<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests;

use AnthonyEdmonds\LaravelMySqlite\Expression;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::partialMock()
            ->shouldReceive('raw')
            ->andReturnUsing(function (string $sql) {
                return new Expression($sql);
            });
    }

    protected function asSqlite(): void
    {
        DB::partialMock()
            ->shouldReceive('getDefaultConnection')
            ->andReturn('sqlite');
    }

    protected function asMySql(): void
    {
        DB::partialMock()
            ->shouldReceive('getDefaultConnection')
            ->andReturn('mysql');
    }
    
    protected function assertQueryExpression(string $expected, Expression $actual): void
    {
        $this->assertEquals(
            $expected,
            $actual->getValue(new Grammar()),
        );
    }
}
