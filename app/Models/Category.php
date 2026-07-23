<?php

declare(strict_types=1);

namespace App\Models;

class Category extends Model
{
    /**
     * Переопределяем защищенное статическое свойство родителя.
     * Теперь эта модель жестко знает, что её таблица в MySQL — 'categories'.
     */
    protected static string $table = 'categories';
}
