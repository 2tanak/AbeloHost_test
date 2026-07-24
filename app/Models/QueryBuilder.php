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


    public function __construct(string $table)
    {
        $this->table = $table;
        $this->db = Database::getInstance();
    }
    public function get(): array
    {

        $stmt = $this->db->prepare((string)$this);
        $stmt->execute($this->bindings);

        return $stmt->fetchAll();
    }
    public function select(string ...$columns): self
    {

        $this->select = "SELECT " . (!empty($columns) ? implode(', ', $columns) : '*');
        return $this;
    }
    public function innerJoin(string $table, string $first, string $operator, string $second): self
    {
        $this->joins[] = " INNER JOIN {$table} ON {$first} {$operator} {$second}";
        return $this;
    }




    public function groupBy(string $column): self
    {
        $this->groupBy = " GROUP BY {$column}";
        return $this;
    }

    /**
     * Отсекает записи, у которых нет связей в промежуточной таблице
     */
    public function has(string $relationTable, string $foreignKey): self
    {
        return $this->innerJoin($relationTable, "{$this->table}.id", '=', "{$relationTable}.{$foreignKey}")
            ->groupBy("{$this->table}.id");
    }

    public function __toString(): string
    {

        $properties = get_object_vars($this);
        $parts = [];
        $sqlSequence = ['select', 'table'];

        foreach ($sqlSequence as $field) {
            if (!empty($properties[$field])) {
                if ($field === 'table') {

                    $parts[] = "FROM {$properties['table']}";
                } elseif ($field === 'joins') {
                    $parts[] = implode('', $properties['joins']);
                } else {
                    $parts[] = $properties[$field];
                }
            }
        }

        return implode(' ', $parts);
    }
}
