<?php

declare(strict_types=1);

namespace App\Helpers;

class Helper
{
    /**
     * Вспомогательный приватный метод для форматирования даты
     */
    private static function formatDate(string $dateString): string
    {
        $timestamp = strtotime($dateString);
        if (!$timestamp) {
            return $dateString;
        }

        // Формат 'F j, Y' преобразует в "July 22, 2026"
        // strtolower делает месяц с маленькой буквы: "july 22, 2026"
        return strtolower(date('F j, Y', $timestamp));
    }

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
                    'description' => $row['description'] ?? null,
                    'thumbnail' => $row['thumbnail'] ?? null,
                    // Вызываем приватный метод класса через self::
                    'created_at' => !empty($row['created_at']) ? self::formatDate($row['created_at']) : null,
                ];
            }
        }

        return array_values($grouped);
    }
}
