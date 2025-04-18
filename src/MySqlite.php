<?php

namespace AnthonyEdmonds\LaravelMySqlite;

use ErrorException;
use Illuminate\Contracts\Database\Query\Expression as ExpressionContract;
use Illuminate\Support\Facades\DB;

/**
 * Tired of having to deal with the differences between SQLite and MySql?
 * So am I. Call this helper to help you out when you need interoperability!
 *
 * Use a "quotation mark" when passing literal strings
 *
 * @author Anthony Edmonds
 *
 * @link https://github.com/AnthonyEdmonds/laravel-mysqlite
 */
class MySqlite
{
    /* Casts ================================= */
    public const string DATE = 'DATE';

    public const string DATETIME = 'DATETIME';

    public const string DECIMAL = 'DECIMAL';

    public const string TIME = 'TIME';

    public const string CHAR = 'CHAR';

    public const string NCHAR = 'NCHAR';

    public const string SIGNED = 'SIGNED';

    public const string UNSIGNED = 'UNSIGNED';

    public const string BINARY = 'BINARY';

    public const array CASTS_MYSQL = [
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

    public const array CASTS_SQLITE = [
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

    public const string TRIM_BOTH = 'BOTH';

    public const string TRIM_LEADING = 'LEADING';

    public const string TRIM_TRAILING = 'TRAILING';

    public const array TRIM_MODES = [
        self::TRIM_BOTH,
        self::TRIM_LEADING,
        self::TRIM_TRAILING,
    ];

    public static function cast(string $column, string $type, ?string $as = null): Expression
    {
        if (in_array($type, self::CASTS_MYSQL) === false) {
            throw new ErrorException("$type is not a recognised MySQL cast type");
        }

        return self::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "CAST($column AS " . self::CASTS_SQLITE[$type] . ')' . self::as($as)
                : "CAST($column AS $type)" . self::as($as),
        );
    }

    /* Dates ================================= */
    public static function dateDiff(string $fromColumn, string $toColumn, ?string $as = null): Expression
    {
        return self::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "(JULIANDAY($fromColumn) - JULIANDAY($toColumn))" . self::as($as)
                : "DATEDIFF($fromColumn, $toColumn)" . self::as($as),
        );
    }

    public static function dateFormat(string $column, string $format, ?string $as = null): Expression
    {
        $isSqlite = DB::getDefaultConnection() === 'sqlite';

        if ($isSqlite === true) {
            $format = str_replace('%i', '%M', $format);
        }

        return self::raw(
            $isSqlite === true
                ? "STRFTIME('$format', $column)" . self::as($as)
                : "DATE_FORMAT($column, '$format')" . self::as($as),
        );
    }

    public static function year(string $column, ?string $as = null): Expression
    {
        return self::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "STRFTIME('%Y', $column)" . self::as($as)
                : "YEAR($column)" . self::as($as),
        );
    }

    public static function month(string $column, ?string $as = null): Expression
    {
        return self::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "STRFTIME('%m', $column)" . self::as($as)
                : "MONTH($column)" . self::as($as),
        );
    }

    public static function day(string $column, ?string $as = null): Expression
    {
        return self::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "STRFTIME('%d', $column)" . self::as($as)
                : "DAY($column)" . self::as($as),
        );
    }

    public static function hour(string $column, ?string $as = null): Expression
    {
        return self::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "STRFTIME('%H', $column)" . self::as($as)
                : "HOUR($column)" . self::as($as),
        );
    }

    public static function weekday(string $column, ?string $as = null): Expression
    {
        return self::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? "(STRFTIME('%u', $column) - 1)" . self::as($as)
                : "WEEKDAY($column)" . self::as($as),
        );
    }

    /* Strings =============================== */
    public static function trim(
        string $needle,
        ExpressionContract|string $haystack,
        ?string $as = null,
        string $side = self::TRIM_BOTH,
    ): Expression {
        $haystack = self::parseExpression($haystack);

        if (DB::getDefaultConnection() === 'sqlite') {
            $method = match ($side) {
                self::TRIM_LEADING => 'LTRIM',
                self::TRIM_TRAILING => 'RTRIM',
                default => 'TRIM',
            };

            $sql = "$method($haystack, $needle)" . self::as($as);
        } else {
            $sql = "TRIM($side $needle FROM $haystack)" . self::as($as);
        }

        return self::raw($sql);
    }

    public static function concat(array $columns, ?string $as = null): Expression
    {
        return self::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? implode(' || ', $columns) . self::as($as)
                : 'CONCAT(' . implode(',', $columns) . ')' . self::as($as),
        );
    }

    public static function groupConcat(array $columns, string $separator = ', ', ?string $as = null): Expression
    {
        return self::raw(
            DB::getDefaultConnection() === 'sqlite'
                ? 'GROUP_CONCAT(' . implode(', ', $columns) . ', ' . "'$separator'" . ')' . self::as($as)
                : 'GROUP_CONCAT(' . implode(', ', $columns) . ' SEPARATOR ' . "'$separator'" . ')' . self::as($as),
        );
    }

    public static function jsonUnquote(string $column, ?string $as = null): Expression
    {
        return DB::getDefaultConnection() === 'sqlite'
            ? self::trim('""""', $column, $as)
            : self::raw("JSON_UNQUOTE($column)" . self::as($as));
    }

    public static function mid(
        string $column,
        ExpressionContract|string|int $start,
        ExpressionContract|string|int|null $length = null,
        ?string $as = null,
    ): Expression {
        $start = self::parseExpression($start);
        $length = self::parseExpression($length);

        return self::raw(
            implode([
                DB::getDefaultConnection() === 'sqlite'
                    ? 'SUBSTR'
                    : 'MID',
                "($column, $start",
                $length !== null
                    ? ", $length"
                    : '',
                ')',
                self::as($as),
            ]),
        );
    }

    /* Utilities ============================= */
    public static function disableForeignKeys(): Expression
    {
        return self::foreignKeys(0);
    }

    public static function enableForeignKeys(): Expression
    {
        return self::foreignKeys(1);
    }

    public static function isNull(string $column, string $value, ?string $as = null): Expression
    {
        $term = DB::getDefaultConnection() === 'sqlite' ? 'IFNULL' : 'ISNULL';

        return self::raw("$term($column, $value)" . self::as($as));
    }

    public static function setAutoIncrement(string $table, int $value = 1): Expression
    {
        return DB::getDefaultConnection() === 'sqlite'
            ? self::raw("UPDATE sqlite_sequence SET seq = $value WHERE name = '$table'")
            : self::raw("ALTER TABLE $table AUTO_INCREMENT = $value");
    }

    protected static function as(?string $as = null): string
    {
        return $as !== null ? " AS $as" : '';
    }

    protected static function foreignKeys(int $mode): Expression
    {
        return DB::getDefaultConnection() === 'sqlite'
            ? self::raw("PRAGMA foreign_keys = $mode")
            : self::raw("SET FOREIGN_KEY_CHECKS=$mode");
    }

    protected static function parseExpression(ExpressionContract|string|int|null $expression): ?string
    {
        return match (true) {
            $expression === null => null,
            $expression instanceof ExpressionContract === true => $expression->getValue(DB::getQueryGrammar()),
            default => (string) $expression,
        };
    }

    public static function raw(string $expression): Expression
    {
        return new Expression($expression);
    }
}
