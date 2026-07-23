<?php

declare(strict_types=1);

namespace App\Helpers;

class Helper
{
    /**
     * Группирует плоский массив из UNION ALL запроса в структуру: Категория -> 3 Статьи
     */
    public static function groupArticlesByCategory(array $flatArticles): array
    {
        $grouped = [];

        foreach ($flatArticles as $row) {
            $catId = (int)$row['category_id'];

            if (!isset($grouped[$catId])) {
                $grouped[$catId] = [
                    'id' => $catId,
                    'title' => $row['category_name'],
                    'articles' => []
                ];
            }

            if (!empty($row['id'])) {
                $grouped[$catId]['articles'][] = [
                    'id' => (int)$row['id'],
                    'title' => $row['title'],
                    'content' => $row['content'] ?? null,
                    'thumbnail' => $row['thumbnail'] ?? null,
                    'created_at' => $row['created_at'] ?? null,
                ];
            }
        }

        return array_values($grouped);
    }
}
