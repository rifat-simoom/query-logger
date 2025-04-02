<?php

namespace RifatSimoom\QueryLogger;

use PDO;
use Exception;
use RifatSimoom\QueryLogger\Helpers\Formatter;
use RifatSimoom\QueryLogger\Helpers\Tracer;

class QueryLogger
{
    public int $queryCount = 0;
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
        $this->queryCount = $this->queryCount + 1;

        $formattedQuery = Formatter::formatQuery($params, $query);
        $logEntry = sprintf(
            "[%s]\n%d. %s\nTime: %.5fs\nTrace:\n%s\n\n",
            date('Y-m-d H:i:s'),                      // Date & Time
            $this->queryCount,                            // Query Number
            $formattedQuery,                          // Formatted SQL Query
            $executionTime,                           // Execution Time
            Tracer::getFilteredTrace()                // Trace
        );

        file_put_contents($this->logFile, $logEntry, FILE_APPEND);
    }
}
