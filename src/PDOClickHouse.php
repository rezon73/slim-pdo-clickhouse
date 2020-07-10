<?php

namespace Rezon73\PDOClickHouse;

class PDOClickHouse
{
    protected $conn;

    public function __construct($host, $port = 8123, $username = null, $password = null, $settings = [], $transport = null)
    {
        $this->conn = new \ClickHouse\Client($host, $port, $username, $password, $settings, $transport);
    }

    public function prepare($qry)
    {
        return new PDOClickHouseStatement($this->conn, $qry);
    }

    public function lastInsertId()
    {
        return null;
    }
}