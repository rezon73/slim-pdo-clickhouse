<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Rezon73\PDOClickHouse\Statement;

use Rezon73\PDOClickHouse\AbstractStatement;
use Rezon73\PDOClickHouse\Clause;
use Rezon73\PDOClickHouse\PDOClickHouse;
use Rezon73\PDOClickHouse\PDOClickHouseStatement;

/**
 * @method PDOClickHouseStatement execute()
 */
class Call extends AbstractStatement
{
    /** @var Clause\Method $method */
    protected $method;

    /**
     * @param PDOClickHouse         $dbh
     * @param Clause\Method|null $procedure
     */
    public function __construct(PDOClickHouse $dbh, ?Clause\Method $procedure = null)
    {
        parent::__construct($dbh);

        if (isset($procedure)) {
            $this->method($procedure);
        }
    }

    /**
     * @param Clause\Method $procedure
     *
     * @return $this
     */
    public function method(Clause\Method $procedure): self
    {
        $this->method = $procedure;

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function getValues(): array
    {
        return $this->method->getValues();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (!$this->method instanceof Clause\Method) {
            trigger_error('No method set for call statement', E_USER_ERROR);
        }

        return "CALL {$this->method}";
    }
}
