<?php

namespace Tests\RifatSimoom\QueryLogger;

use Dotenv\Dotenv;
use PDO;
use PHPUnit\Framework\TestCase;
use RifatSimoom\QueryLogger\QueryLogger;
//Use Dotenv to retrieve secret variables from .env files

class QueryLoggerTest extends TestCase
{
    private ?PDO $pdo = null;
    protected function setUp(): void
    {
        $dotenv = Dotenv::create(dirname(__DIR__."/tests", 1));
        $dotenv->load();
        $dbHost = getenv('DB_HOST');
        $dbName = getenv('DB_NAME');
        $dbUser = getenv('DB_USER');
        $dbPass = getenv('DB_PASS');

        $this->pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function testLogQuery()
    {
        $logFile = "test_queries.log";
        $logger = new QueryLogger($this->pdo, $logFile);
        $logger->startLogging();

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute(['test@example.com']);

        $logContent = file_get_contents($logFile);
        $this->assertStringContainsString("SELECT * FROM users WHERE email = 'test@example.com'", $logContent);
    }
}