<?php

declare(strict_types=1);

namespace App\Helpers;

class Helper
{

    /**
     * Вспомогательный метод для обрезки текста по словам
     */
    private static function truncateText(string $text, int $limit = 120): string
    {
        // Очищаем от лишних пробелов и переносов
        $text = trim(preg_replace('/\s+/', ' ', $text));

        if (mb_strlen($text) <= $limit) {
            return $text;
        }

        // Обрезаем строку до лимита символов
        $truncated = mb_substr($text, 0, $limit);

        // Чтобы не обрезать слово на середине, режем до последнего пробела
        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }

        return $truncated . '...';
    }



    /**
     * Вспомогательный приватный метод для форматирования даты
     */
    public static function formatDate(string $dateString): string
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
                    'img' => $row['img'],
                    'title' => !empty($row['title']) ? self::truncateText($row['title'], 60) : null,
                    'description' => !empty($row['description']) ? self::truncateText($row['description'], 130) : null,

                    'thumbnail' => $row['thumbnail'] ?? null,
                    // Вызываем приватный метод класса через self::
                    'created_at' => !empty($row['created_at']) ? $row['created_at'] : null,
                ];
            }
        }

        return array_values($grouped);
    }
}
