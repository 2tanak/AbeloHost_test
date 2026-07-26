<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Helpers\Helper;
use \App\Models\Database;

class ArticleController extends BaseController
{
    public function setContent(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        
        //делаем запрос но джойним с article_category, нам нужен category_id чтобы вытащить три похожие статьи
        /**
         * Метод one() компилирует запрос с INNER JOIN для получения полей статьи 
         * и ID её категории из промежуточной таблицы связей в один заход:
         * 
         * SELECT articles.*, article_category.category_id 
         * FROM articles 
         * INNER JOIN article_category ON articles.id = article_category.article_id 
         * WHERE articles.id = '5' 
         * LIMIT 1;
         */


        $article = Article::query()
            ->select('articles.*', 'article_category.category_id')
            ->innerJoin('article_category', 'articles.id', '=', 'article_category.article_id')
            ->where('articles.id', '=', $id)
            ->one();

        if (!isset($article['id'])) {
            header('Location: /');
            exit();
        }

        $catId = (int)$article['category_id'];

        // 2. СЫРОЙ И БЫСТРЫЙ ЗАПРОС НА УВЕЛИЧЕНИЕ ПРОСМОТРОВ НА +1
        // Используем наш синглтон базы данных и метод query()


        Database::getInstance()->query(
            "UPDATE articles SET views_count = views_count + 1 WHERE id = {$id}"
        );



        //потому как в базе уже обновилось, чтоб не выводить старую цифру
        $article['views_count'] = (int)$article['views_count'] + 1;


        // 3. Вытаскиваем 3 похожих статьи 
        /**
         * Метод get() компилирует запрос для поиска 3 свежих похожих статей 
         * из той же категории, отсекая текущую статью по её ID:
         * 
         * SELECT articles.* 
         * FROM articles 
         * INNER JOIN article_category ON articles.id = article_category.article_id 
         * WHERE article_category.category_id = '1' 
         *   AND articles.id != '5' 
         * LIMIT 3;
         */
        $catId = (int)$article['category_id'];
        $relatedArticles = Article::query()
            ->select('articles.*')
            ->innerJoin('article_category', 'articles.id', '=', 'article_category.article_id')
            ->where('article_category.category_id', '=', (string)$catId)
            ->where('articles.id', '!=', (string)$id)
            ->limit(3)
            ->get();

        $catId = (int)$article['category_id'];
        $relatedArticles = Article::query()
            ->select('articles.*')
            ->innerJoin('article_category', 'articles.id', '=', 'article_category.article_id')
            ->where('article_category.category_id', '=', (string)$catId)
            ->where('articles.id', '!=', (string)$id)
            ->limit(3)
            ->get();
        //$this->dd($relatedArticles);

        $this->smarty->assign('related', $relatedArticles);
        $this->smarty->assign('article', $article);
        $this->content = $this->smarty->fetch('article.tpl');
    }

    /**
     * Точка входа для роутера
     */
    public function index(): void
    {
        $this->output();
    }
}
