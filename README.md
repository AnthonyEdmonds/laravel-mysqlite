# Laravel MySqlite

Generate MySQL and SQLite3 expressions on the fly based on the active database.

Designed primarily for situations where an SQLite3 database is used for testing, but MySQL is used for production.

Calling the `MySqlite::`  helper will provide the correct syntax for the default database connection.

## Installation

1. Install via Composer: `composer require anthonyedmonds\laravel-mysqlite`
2. Use in your code: `use AnthonyEdmonds\LaravelMySqlite\MySqlite`

## Usage

Laravel MySqlite provides syntax for the following MySQL/SQLite conversions:

| MySqlite Method              | MySQL Syntax     | SQLite Syntax               | Notes |
| ---------------------------- | ---------------- | --------------------------- | ----- |
| MySqlite::setAutoIncrement() | `ALTER TABLE...` | `UPDATE sqlite_sequence...` | Used as a standalone statement |
| MySqlite::cast()             | `CAST()`         | `CAST()`                    | Must be a value from `MySqlite::CASTS_MYSQL` |
| MySqlite::concat()           | `CONCAT()`       | `\|\|`                      | Pass literal strings with quotation marks, such as `'"String"'` |
| MySqlite::day()              | `DAY()`          | `STRFTIME()`                | |
| MySqlite::dateFormat()       | `DATE_FORMAT()`  | `STRFTIME()`                | Use date formats supported by both MySQL and SQLite |
| MySqlite::hour()             | `HOUR()`         | `STRFTIME()`                | |
| MySqlite::month()            | `MONTH()`        | `STRFTIME()`                | |
| MySqlite::year()             | `YEAR()`         | `STRFTIME()`                | |

The helper returns a `DB::raw` expression, so you may use it directly inside queries:

```php
DB::table('users')
    ->select([
        MySqlite::concat(['users.first_name', '" "', 'users.last_name'], 'name'),
        MySqlite::dateFormat('users.created_at', '%d/%m/%Y', 'formatted_date'),
        MySqlite::day('AVG(users.updated_at)', 'aggregated_day'),
    ])
    ->groupBy([
        MySqlite::year('users.updated_at')
    ])
    ->get();
```

### Columns
The column/columns value of a method accepts a string/array of:

* A column name `'users.first_name'`
* An aggregate method `'COUNT(users.id)'`
* A string literal in quotation marks `'"Literally this"'`
* Any other valid SQL expression

### Aliasing / As

The optional `$as` parameter adds a column alias when set:

`MySqlite::hour('users.created_at', 'potato') === YEAR(users.created_at) AS potato`

## Roadmap

There are more syntax differences between MySQL and SQLite that can be compensated for with minor syntax changes, which will be added as they are encountered.

If you require a particular method conversion, raise an issue.
