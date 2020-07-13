<?php

namespace Rezon73\PDOClickHouse;

use ClickHouse\Client;

class PDOClickHouse
{
    protected $client;

    public function __construct($host = 'http://127.0.0.1', $port = 8123, $username = null, $password = null, $settings = [], $transport = null)
    {
        $this->client = new Client($host, $port, $username, $password, $settings, $transport);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function prepare($qry)
    {
        return new PDOClickHouseStatement($this->client, $qry);
    }

    public function lastInsertId()
    {
        return null;
    }
}