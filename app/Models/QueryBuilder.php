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
    protected string $ofset = '';
    protected array $withRelations = [];
    protected string $modelClass;
    protected string $unionSql = '';
    protected array $joins = [];
    protected string $groupBy = '';
	protected string $offset = '';


    public function __construct(string $table, string $ModelClass)
    {
        $this->table = $table;
        $this->modelClass = $ModelClass;
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


    public function limit(int $value): self
    {
        $this->limit = " LIMIT {$value}";
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

    public function where(string $column, string $operator, $value): self
    {

        $this->where[] = "{$column} {$operator} '{$value}'";

        return $this;
    }
    /**
     * Цепочка для регистрации жадной загрузки связей
     */
    public function with(string $relation): self
    {
        // 1. Получаем категории

        $categories = $this->get();

        if (empty($categories)) {
            return $this;
        }


        $modelInstance = new $this->modelClass();

        $unionParts = [];

        foreach ($categories as $category) {
            $catId = (int)$category['id'];
            $title = $category['title'];

            //из модели категории тянем связь
            $subQuery = $modelInstance->{$relation}();

            $subQuery->select("{$catId} AS category_id", "'{$title}' AS category_name", "articles.*")
                ->where('article_category.category_id', '=', (string)$catId)
                ->orderBy('articles.created_at', 'DESC')
                ->limit(3);

            $unionParts[] = "({$subQuery})";
        }

        // 3. Записываем монолитный UNION ALL в свойства объекта
        $this->unionSql = implode(" UNION ALL ", $unionParts);

        $this->bindings = [];
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy = " ORDER BY {$column} {$direction}";
        return $this;
    }

    /**
     * Подсчитать общее количество записей, подходящих под условия запроса
     */
    public function count(): int
    {
        // Запоминаем оригинальный селект, чтобы не сломать объект
        $originalSelect = $this->select;

        // Насильно ставим подсчет строк для MySQL
        $this->select = "SELECT COUNT(*)";

        // Лимиты и сортировка для COUNT(*) не нужны, временно убираем
        $originalLimit = $this->limit;
        $originalOffset = $this->offset;
        $originalOrderBy = $this->orderBy;
        
        $this->limit = '';
        $this->offset = '';
        $this->orderBy = '';

        // Генерируем SQL и выполняем
        $stmt = $this->db->prepare((string)$this);
        $stmt->execute($this->bindings);
        $count = (int)$stmt->fetchColumn();

        // Возвращаем билдеру его исходное состояние
        $this->select = $originalSelect;
        $this->limit = $originalLimit;
        $this->offset = $originalOffset;
        $this->orderBy = $originalOrderBy;

        return $count;
    }

    public function paginate(int $perPage, int $page = 1): self
    {
        // На всякий случай защищаем логику от отрицательных страниц
        if ($page < 1) {
            $page = 1;
        }

        // Вычисляем смещение по формуле
        $offsetValue = ($page - 1) * $perPage;

        // Переиспользуем уже созданные методы билдера
        return $this->limit($perPage)->offset($offsetValue);
    }

    public function offset(int $value): self
    {
        $this->offset = " OFFSET {$value}";
        return $this;
    }
    /**
     * Получить строго одну строку из базы данных
     */
    public function one(): ?array
    {
        // Принудительно ставим лимит в 1 строку для оптимизации
        $this->limit(1);

        $stmt = $this->db->prepare((string)$this);
        $stmt->execute($this->bindings);

        $result = $stmt->fetch();

        // Если база ничего не нашла, возвращаем null, иначе — чистый плоский массив
        return $result ?: null;
    }

    // Магическое приведение к строке SQL (универсальное)
    public function __toString(): string
    {

        // ЕСЛИ ЕСТЬ ГОТОВЫЙ UNION ALL — СРАЗУ ОТДАЕМ ЕГО В GET()
        if (!empty($this->unionSql)) {
            return $this->unionSql;
        }

        $properties = get_object_vars($this);
        $parts = [];
        $sqlSequence = ['select', 'table', 'joins', 'where', 'groupBy', 'orderBy', 'limit', 'offset'];

        foreach ($sqlSequence as $field) {
            if (!empty($properties[$field])) {
                if ($field === 'table') {

                    $parts[] = "FROM {$properties['table']}";
                } elseif ($field === 'joins') {
                    $parts[] = implode('', $properties['joins']);
                } elseif ($field === 'where') {
                    $whereSql = is_array($properties['where']) ? implode(' AND ', $properties['where']) : $properties['where'];
                    $parts[] = "WHERE " . ltrim($whereSql, 'WHERE ');
                } else {
                    $parts[] = $properties[$field];
                }
            }
        }

        return implode(' ', $parts);
    }
}
