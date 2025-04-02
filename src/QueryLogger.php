<?php

namespace RifatSimoom\QueryLogger;

use PDO;
use Exception;
use RifatSimoom\QueryLogger\Helpers\Formatter;
use RifatSimoom\QueryLogger\Helpers\Tracer;

class QueryLogger
{
    private PDO $pdo;
    private string $logFile;

    public function __construct(PDO $pdo, string $logFile = "query.log")
    {
        gc_collect_cycles();
        if(file_exists($logFile)) {
            @unlink($logFile);
        }
        $this->pdo = $pdo;
        $this->logFile = $logFile;
    }

    public function startLogging(): void
    {
        try {
            $this->pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS, [LoggedStatement::class, [$this]]);
        } catch (Exception $e) {
            error_log("Query Logger Error: " . $e->getMessage());
        }
    }

    public function logQuery(string $query, array $params, float $executionTime): void
    {
        $formattedQuery = Formatter::formatQuery($params, $query);
        $logEntry = sprintf(
            "[%s] %s\nExecution Time: %.5fs\nTrace:\n%s\n\n",
            date('Y-m-d H:i:s'),
            $formattedQuery,
            $executionTime,
            Tracer::getFilteredTrace()
        );

        file_put_contents($this->logFile, $logEntry, FILE_APPEND);
    }
}
