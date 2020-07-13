<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Rezon73\PDOClickHouse;

class Database extends PDOClickHouse
{
    /**
     * @param $host
     * @param int $port
     * @codeCoverageIgnore
     */
    public function __construct($host = '127.0.0.1', $port = 8123)
    {
        parent::__construct($host, $port);
    }

    /**
     * @codeCoverageIgnore
     *
     * @return array<int, mixed>
     */
    protected function getDefaultOptions(): array
    {
        return [];
    }

    /**
     * @param Clause\Method|null $procedure
     *
     * @return Statement\Call
     */
    public function call(Clause\Method $procedure = null): Statement\Call
    {
        return new Statement\Call($this, $procedure);
    }

    /**
     * @param array<int|string, string> $columns
     *
     * @return Statement\Select
     */
    public function select(array $columns = ['*']): Statement\Select
    {
        return new Statement\Select($this, $columns);
    }

    /**
     * @param array<int|string, mixed> $pairs
     *
     * @return Statement\Insert
     */
    public function insert(array $pairs = []): Statement\Insert
    {
        return new Statement\Insert($this, $pairs);
    }

    /**
     * @param array<string, mixed> $pairs
     *
     * @return Statement\Update
     */
    public function update(array $pairs = []): Statement\Update
    {
        return new Statement\Update($this, $pairs);
    }

    /**
     * @param string|array<string, string> $table
     *
     * @return Statement\Delete
     */
    public function delete($table = null): Statement\Delete
    {
        return new Statement\Delete($this, $table);
    }
}
