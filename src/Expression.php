<?php

namespace AnthonyEdmonds\LaravelMySqlite;

use Illuminate\Database\Query\Expression as QueryExpression;
use Illuminate\Support\Facades\DB;

class Expression extends QueryExpression
{
    public function __toString(): string
    {
        return $this->getValue(DB::getQueryGrammar());
    }
}
