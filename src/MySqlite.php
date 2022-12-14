<?php

namespace AnthonyEdmonds\LaravelMySqlite;

use ErrorException;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;

/**
 * Tired of having to deal with the differences between SQLite and MySql?
 * So am I. Call this helper to help you out when you need interoperability!
 *
 * Use a "quotation mark" when passing literal strings
 *
 * @author Anthony Edmonds
 * @link https://github.com/AnthonyEdmonds/laravel-mysqlite
 */
class MySqlite
{
    /* Casts ================================= */
    const DATE = 'DATE';
    const DATETIME = 'DATETIME';
    const DECIMAL = 'DECIMAL';
    const TIME = 'TIME';
    const CHAR = 'CHAR';
    const NCHAR = 'NCHAR';
    const SIGNED = 'SIGNED';
    const UNSIGNED = 'UNSIGNED';
    const BINARY = 'BINARY';

    const CASTS_MYSQL = [
        self::DATE,
        self::DATETIME,
        self::DECIMAL,
        self::TIME,
        self::CHAR,
        self::NCHAR,
        self::SIGNED,
        self::UNSIGNED,
        self::BINARY,
    ];

    const CASTS_SQLITE = [
        self::DATE => 'NUMERIC',
        self::DATETIME => 'NUMERIC',
        self::DECIMAL => 'NUMERIC',
        self::TIME => 'NUMERIC',
        self::CHAR => 'TEXT',
        self::NCHAR => 'TEXT',
        self::SIGNED => 'INTEGER',
        self::UNSIGNED => 'INTEGER',
        self::BINARY => 'TEXT',
    ];

    public static function cast(string $column, string $type, string $as = null): Expression
    {
        if (in_array($type, self::CASTS_MYSQL) === false) {
            throw new ErrorException("$type is not a recognised MySQL cast type");
        }

        return DB::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "CAST($column AS " . self::CASTS_SQLITE[$type] . ")" . self::as($as)
                : "CAST($column AS $type)" . self::as($as)
        );
    }

    /* Dates ================================= */

    public static function dateFormat(string $column, string $format, string $as = null): Expression
    {
        return DB::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "STRFTIME('$format', $column)" . self::as($as)
                : "DATE_FORMAT($column, '$format')" . self::as($as)
        );
    }

    public static function year(string $column, string $as = null): Expression
    {
        return DB::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "STRFTIME('%Y', $column)" . self::as($as)
                : "YEAR($column)" . self::as($as)
        );
    }

    public static function month(string $column, string $as = null): Expression
    {
        return DB::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "STRFTIME('%m', $column)" . self::as($as)
                : "MONTH($column)" . self::as($as)
        );
    }

    public static function day(string $column, string $as = null): Expression
    {
        return DB::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "STRFTIME('%d', $column)" . self::as($as)
                : "DAY($column)" . self::as($as)
        );
    }

    public static function hour(string $column, string $as = null): Expression
    {
        return DB::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "STRFTIME('%H', $column)" . self::as($as)
                : "HOUR($column)" . self::as($as)
        );
    }

    /* Strings =============================== */
    public static function concat(array $columns, string $as = null): Expression
    {
        return DB::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? implode(' || ', $columns) . self::as($as)
                : 'CONCAT(' . implode(',', $columns) . ')' . self::as($as)
        );
    }

    /* Utilities ============================= */
    public static function setAutoIncrement(string $table, int $value = 1): Expression
    {
        return DB::getDefaultConnection() === 'sqlite'
            ? DB::raw("UPDATE sqlite_sequence SET seq = $value WHERE name = '$table'")
            : DB::raw("ALTER TABLE $table AUTO_INCREMENT = $value");
    }
    
    protected static function as(string|null $as = null): string
    {
        return $as !== null ? " AS $as" : '';
    }
}
