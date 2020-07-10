<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Rezon73\PDOClickHouse;

use PDOException;

abstract class AbstractStatement implements QueryInterface
{
    /** @var PDOClickHouse $dbh */
    protected $dbh;

    /**
     * @param PDOClickHouse $dbh
     */
    public function __construct(PDOClickHouse $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @throws PDOException
     *
     * @return bool|PDOClickHouseStatement
     */
    public function execute()
    {
        $stmt = $this->dbh->prepare($this->__toString());

        try {
            $success = $stmt->execute($this->getValues());
            if (!$success) {
                list($state, $code, $message) = $stmt->errorInfo();

                // We are not in exception mode, raise error.
                trigger_error("SQLSTATE[{$state}] [{$code}] {$message}", E_USER_ERROR);
            }
        } catch (PDOException $e) {
            // We are in exception mode, carry on.
            throw $e;
        }

        return $stmt;
    }
}
