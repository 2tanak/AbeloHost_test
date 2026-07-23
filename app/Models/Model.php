<?php

declare(strict_types=1);

namespace App\Models;

abstract class Model
{
    /**
     * Каждая дочерняя модель (Category, Article) обязательно переопределит это свойство
     * и запишет туда имя своей таблицы (например: 'categories')
     */
    protected static string $table;

    /**
     * Единственное место, где создается фабрика запросов QueryBuilder
     * и куда передается имя таблицы
     */
    public static function query(): QueryBuilder
    {
        return new QueryBuilder(static::$table);
    }

    /**
     * Метод для быстрого получения всех записей из таблицы (Аналог Category::all() в Laravel)
     */
    public static function all(): array
    {
        return static::query()->get();
    }

    /**
     * Магия : любые другие статические вызовы (например, Category::where())
     * автоматически пробрасываются в единственный экземпляр билдера
     */
    public static function __callStatic(string $method, array $arguments)
    {
        return static::query()->$method(...$arguments);
    }
}
