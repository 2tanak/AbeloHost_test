<?php

declare(strict_types=1);

namespace App\Models;

class Article extends Model
{
    protected static string $table = 'articles';

    /**
     * здесбь будет запрос категории с привязкой 3 поста
     */
    public static function getLatestPerCategory(int $limit = 10, int $offset = 0): array
    {
		
        $db = Database::getInstance();

        
    }
}
