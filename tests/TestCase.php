<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function asSqlite(): void
    {
        $this->app['config']['database.default'] = 'sqlite';
    }

    protected function asMySql(): void
    {
        $this->app['config']['database.default'] = 'mysql';
    }

    protected function assertQueryExpression(string $expected, Expression $actual): void
    {
        $this->assertEquals(
            $expected,
            $actual->getValue(DB::getQueryGrammar()),
        );
    }
}
