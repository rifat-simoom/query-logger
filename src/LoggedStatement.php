<?php

namespace RifatSimoom\QueryLogger;


use PDO;
use PDOStatement;

class LoggedStatement extends PDOStatement
{
    private QueryLogger $logger;
    private array $boundParams = [];

    protected function __construct(QueryLogger $logger)
    {
        $this->logger = $logger;
    }

    public function bindValue($param, $value, $type = PDO::PARAM_STR): bool
    {
        $this->boundParams[$param] = $value;
        return parent::bindValue($param, $value, $type);
    }

    public function bindParam($param, &$var, $type = PDO::PARAM_STR, $maxLength = null, $driverOptions = null): bool
    {
        $this->boundParams[$param] = &$var;
        return parent::bindParam($param, $var, $type, $maxLength, $driverOptions);
    }

    public function execute(?array $params = null): bool
    {
        $startTime = microtime(true);
        $result = parent::execute($params);
        $executionTime = (microtime(true) - $startTime);

        $this->logger->logQuery($this->queryString, $params ?? $this->boundParams, $executionTime);
        return $result;
    }
}
