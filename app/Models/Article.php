<?php

declare(strict_types=1);

namespace App\Models;

class Article extends Model
{
    protected static string $table = 'articles';

    /**
     * Вытаскивает строго по 3 свежих поста для категорий через UNION ALL (оптимизировано под частые INSERT)
     */
    public static function getLatestPerCategory(int $limit = 10, int $offset = 0): array
    {
		
        $db = Database::getInstance();

        // 1. Сначала берем только ID и имена нужных 10 категорий для текущей страницы
        $catSql = "SELECT id, title FROM categories LIMIT :limit OFFSET :offset";
        $catStmt = $db->prepare($catSql);
        $catStmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $catStmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $catStmt->execute();
        $categories = $catStmt->fetchAll();

        // Если категорий в базе вообще нет, возвращаем пустой массив
        if (empty($categories)) {
            return [];
        }

        // 2. Динамически собираем UNION ALL запрос для выбранных категорий
        $unionParts = [];
		
        foreach ($categories as $category) {
            $catId = (int)$category['id'];
            // Экранируем имя категории, чтобы безопасно прокинуть его в результат
            $catName = $db->quote($category['title']);
            
            $unionParts[] = "(SELECT 
                                $catId AS category_id, 
                                $catName AS category_name, 
                                art.* 
                              FROM articles art 
                              JOIN article_category ac ON art.id = ac.article_id 
                              WHERE ac.category_id = $catId 
                              ORDER BY art.id DESC 
                              LIMIT 3)";
        }

        // Склеиваем все кусочки в один монолитный запрос
        $fullSql = implode(" UNION ALL ", $unionParts);

        $stmt = $db->query($fullSql);
        return $stmt->fetchAll();
    }
}
