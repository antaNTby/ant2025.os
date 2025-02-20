<?php
class MySQLMultiQuery
{
    private $mysqli;
    private $executedQueriesCount = 0;
    private $executionTime        = 0;
    private $insertedIds          = [];
    private $updatedRows          = [];

    public function __construct($host, $username, $password, $database)
    {
        $this->mysqli = new mysqli($host, $username, $password, $database);

        if ($this->mysqli->connect_error) {
            die('Ошибка подключения: ' . $this->mysqli->connect_error);
        }
    }

    public function executeQueries($sql)
    {
        $startTime = microtime(true);

        if ($this->mysqli->multi_query($sql)) {
            do {
                if ($result = $this->mysqli->store_result()) {
                    $result->free();
                } elseif ($this->mysqli->insert_id) {
                    $this->insertedIds[] = $this->mysqli->insert_id;
                } elseif ($this->mysqli->affected_rows > 0) {
                    $this->updatedRows[] = $this->mysqli->affected_rows;
                }
                $this->executedQueriesCount++;
            } while ($this->mysqli->more_results() && $this->mysqli->next_result());
        } else {
            echo "Ошибка выполнения multi-query: " . $this->mysqli->error;
        }

        $endTime             = microtime(true);
        $this->executionTime = $endTime - $startTime;
    }

    public function getExecutedQueriesCount()
    {
        return $this->executedQueriesCount;
    }

    public function getExecutionTime()
    {
        return $this->executionTime;
    }

    public function getInsertedIds()
    {
        return $this->insertedIds;
    }

    public function getUpdatedRows()
    {
        return $this->updatedRows;
    }

    public function close()
    {
        $this->mysqli->close();
    }
}

// Пример использования класса
$host     = 'localhost';
$username = 'username';
$password = 'password';
$database = 'database';

$sql = "
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'John Doe', '192.168.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Jane Smith', '192.168.31.255');
    UPDATE `ant_ippost` SET ip = '192.168.1.111' WHERE title = 'John Doe';
";

$mysqlMultiQuery = new MySQLMultiQuery($host, $username, $password, $database);
$mysqlMultiQuery->executeQueries($sql);
echo "Количество выполненных запросов: " . $mysqlMultiQuery->getExecutedQueriesCount() . "\n";
echo "Время выполнения запросов: " . $mysqlMultiQuery->getExecutionTime() . " секунд\n";
echo "Вставленные ID: " . implode(', ', $mysqlMultiQuery->getInsertedIds()) . "\n";
echo "Обновленные записи: " . implode(', ', $mysqlMultiQuery->getUpdatedRows()) . "\n";
$mysqlMultiQuery->close();
