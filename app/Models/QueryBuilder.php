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



    public function __toString(): string
    {

        $properties = get_object_vars($this);
        $parts = [];
        $sqlSequence = ['select', 'table'];

        foreach ($sqlSequence as $field) {
            if (!empty($properties[$field])) {
                if ($field === 'table') {
                    $parts[] = "FROM {$properties['table']}";
                } else {
                    $parts[] = $properties[$field];
                }
            }
        }

        return implode(' ', $parts);
    }
}
