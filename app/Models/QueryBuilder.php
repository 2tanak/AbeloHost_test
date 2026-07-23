<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class QueryBuilder
{
    protected PDO $db;
    protected string $table;
    protected array $where = [];
    protected array $bindings = [];
    protected string $orderBy = '';
    protected string $limit = '';

    /**
     * Конструктор принимает только имя таблицы от модели
     * и сам выступает фабрикой, подключая Singleton базы данных
     */
    public function __construct(string $table)
    {
        $this->table = $table;
        
        // Фабрика сама забирает единственный коннект из синглтона с поддержкой .env
        $this->db = Database::getInstance();
    }

    public function where(string $column, string $operator, $value): self
    {
        $this->where[] = "{$column} {$operator} :{$column}";
        $this->bindings[$column] = $value;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy = " ORDER BY {$column} {$direction}";
        return $this;
    }

    public function limit(int $value): self
    {
        $this->limit = " LIMIT {$value}";
        return $this;
    }

    /**
     * Финальный метод выполнения собранного SQL-запроса
     */
    public function get(): array
    {
        $sql = "SELECT * FROM {$this->table}";

        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }

        $sql .= $this->orderBy . $this->limit;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($this->bindings);

        return $stmt->fetchAll();
    }
}
