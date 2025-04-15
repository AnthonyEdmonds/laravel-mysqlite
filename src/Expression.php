<?php

namespace AnthonyEdmonds\LaravelMySqlite;

use Illuminate\Database\Query\Expression as BaseExpression;
use Illuminate\Support\Facades\DB;

class Expression extends BaseExpression
{
    public function __toString(): string
    {
        return $this->getValue(DB::getQueryGrammar());
    }
}
