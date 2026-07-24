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

 
    public static function query(): QueryBuilder
    {
        return new QueryBuilder(static::$table);
    }

  
}
