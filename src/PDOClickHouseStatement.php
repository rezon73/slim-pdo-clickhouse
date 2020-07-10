<?php

namespace Rezon73\PDOClickHouse;

use ClickHouse\Client;

class PDOClickHouseStatement
{
    protected $qry;
    protected $param;
    protected $conn;

    /** @var \ClickHouse\Statement */
    protected $stmt;

    public function __construct(Client $conn, $qry)
    {
        $this->conn = $conn;

        $this->qry = preg_replace('/(?<=\s|^):[^\s:]++/um', '?', $qry);
        $this->param = null;

        $this->extractParam($qry);
    }

    public function bindValue($param, $val)
    {
        if (!is_null($val)) {
            $this->param[$param] = $val;
        }
    }

    public function execute($params = [])
    {
        if (!empty($params)) {
            foreach ($params as $param => $val) {
                $this->bindValue($param, $val);
            }
        }

        if($this->param == null) {
            $this->stmt = $this->conn->execute($this->qry);
        } else {
            $this->stmt = $this->conn->execute($this->qry, $this->param);
        }

        $this->clearParam();

        return $this->stmt;
    }

    public function fetch($option = null)
    {
        return $this->stmt->fetchOne();
    }

    public function fetchAll($option = null)
    {
        return $this->stmt->fetchAll();
    }

    public function rowCount()
    {
        return $this->stmt->rowsCount();
    }

    public function errorInfo(): array
    {
        return $this->stmt->getMeta();
    }

    protected function extractParam($qry)
    {
        $qryArray = explode(" ", $qry);
        $ind = 0;

        while (isset($qryArray[$ind])) {
            if (preg_match("/^:/", $qryArray[$ind])) {
                $this->param[$qryArray[$ind]] = null;
            }

            ++$ind;
        }
    }

    protected function clearParam()
    {
        $ind = 0;

        while(isset($this->param[$ind])) {
            $this->param[$ind] = null;
            ++$ind;
        }
    }
}