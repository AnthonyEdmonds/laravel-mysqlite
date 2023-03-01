<?php

namespace AnthonyEdmonds\LaravelMySqlite\Tests\MySqlite;

use AnthonyEdmonds\LaravelMySqlite\MySqlite;
use AnthonyEdmonds\LaravelMySqlite\Tests\TestCase;

class DateFormatTest extends TestCase
{
    public function testCreatesMySqlDateFormat(): void
    {
        $this->asMySql();
        
        $this->assertEquals(
            'DATE_FORMAT(my_column, \'format\')',
            MySqlite::dateFormat('my_column', 'format'),
        );
    }

    public function testAppendsMySqlAs(): void
    {
        $this->asMySql();
        
        $this->assertEquals(
            'DATE_FORMAT(my_column, \'format\') AS my_alias',
            MySqlite::dateFormat('my_column', 'format', 'my_alias'),
        );
    }

    public function testCreatesSqliteDateFormat(): void
    {
        $this->asSqlite();
        
        $this->assertEquals(
            'STRFTIME(\'format\', my_column)',
            MySqlite::dateFormat('my_column', 'format'),
        );
    }

    public function testAppendsSqliteAs(): void
    {
        $this->asSqlite();
        
        $this->assertEquals(
            'STRFTIME(\'format\', my_column) AS my_alias',
            MySqlite::dateFormat('my_column', 'format', 'my_alias'),
        );
    }
}
