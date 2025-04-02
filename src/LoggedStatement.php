<?php

namespace RifatSimoom\QueryLogger;


use PDOStatement;

class LoggedStatement extends PDOStatement
{
    private QueryLogger $logger;

    protected function __construct(QueryLogger $logger)
    {
        $this->logger = $logger;
    }

    public function execute(?array $params = null): bool
    {
        $startTime = microtime(true);
        $result = parent::execute($params);
        $executionTime = (microtime(true) - $startTime);

        $this->logger->logQuery($this->queryString, $params ?? [], $executionTime);
        return $result;
    }
}
