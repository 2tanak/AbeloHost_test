<?php

declare(strict_types=1);

namespace App\Models;

class Article extends Model
{
    protected static string $table = 'articles';

    public static function byCategory(int $catId): QueryBuilder
    {
        return self::query()
            ->select('articles.*')
            ->innerJoin('article_category', 'articles.id', '=', 'article_category.article_id')
            ->where('article_category.category_id', '=', (string)$catId);
    }
}
