<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Helpers\Helper;

class HomeController extends BaseController
{
    public function setContent(): void
    {
        // Fetch categories with three posts each

        /**
         * Под капотом эта ORM-цепочка генерирует и выполняет два последовательных запроса:
         * 
         * 1) ШАГ 1: Получение списка непустых категорий с пагинацией (внутри метода with)
         * SELECT categories.id, categories.title 
         * FROM categories 
         * INNER JOIN article_category ON categories.id = article_category.category_id 
         * LIMIT 10 OFFSET 0;
         * 
         * 2) ШАГ 2: Финальный монолитный UNION ALL (магия __toString подставляет его в get())
         * (SELECT 1 AS category_id, 'спорт' AS category_name, articles.* 
         *  FROM articles 
         *  INNER JOIN article_category ON articles.id = article_category.article_id 
         *  WHERE article_category.category_id = '1' 
         *  ORDER BY articles.created_at DESC LIMIT 3)
         * UNION ALL
         * (SELECT 2 AS category_id, 'Политика' AS category_name, articles.* 
         *  FROM articles 
         *  INNER JOIN article_category ON articles.id = article_category.article_id 
         *  WHERE article_category.category_id = '2' 
         *  ORDER BY articles.created_at DESC LIMIT 3)
         * UNION ALL
         * (SELECT 3 AS category_id, 'музыка' AS category_name, articles.* 
         *  FROM articles 
         *  INNER JOIN article_category ON articles.id = article_category.article_id 
         *  WHERE article_category.category_id = '3' 
         *  ORDER BY articles.created_at DESC LIMIT 3);
         */

        $rawContent = Category::query()->select('categories.id', 'categories.title')->has('article_category', 'category_id')->with('articles')->get();

        //grouping: place an array with a post in each category
        $content = Helper::groupArticlesByCategory($rawContent);

        $this->smarty->assign('categories', $content);

        $this->content = $this->smarty->fetch('home.tpl');
    }

    /**
     * Точка входа для роутера
     */
    public function index(): void
    {
        $this->setContent();
        $this->output();
    }
}
