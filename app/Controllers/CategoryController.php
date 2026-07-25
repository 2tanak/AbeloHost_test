<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Article; // Не забудь подключить модель статей

class CategoryController extends BaseController
{
    public function setContent(): void
    {
        // 1. Собираем параметры из GET-запроса
        $catId = (int)($_GET['id'] ?? 0);
        $page = (int)($_GET['page'] ?? 1);
        $sortParam = $_GET['sort'] ?? 'date'; // по умолчанию сортируем по дате

        //вычисления для постраничной навитгации, запрос на реальных проектах кешируется redis
        $perPage = 6;
        $totalArticles = Article::byCategory($catId)->count();
        $totalPages = $totalArticles > 0 ? (int)ceil($totalArticles / $perPage) : 1;




        if ($catId <= 0) {
            header('Location: /');
            exit();
        }

       //запрос чтобы вывести название и описание категории
        $category = Category::query()
            ->select('id', 'title', 'description')
            ->where('id', '=', (string)$catId)
            ->one();

        $sortColumn = 'articles.created_at'; // Дефолт — дата

        if ($sortParam === 'views') {
            $sortColumn = 'articles.views_count'; // По количеству просмотров
        }


        //запрос через промежуточную таблицу, выводим статьи категории
        $articles = Article::byCategory($catId)
            ->orderBy($sortColumn, 'DESC')
            ->paginate($perPage, $page)
            ->get();


        if (empty($articles)) {
            header('Location: /');
            exit();
        }
        $this->smarty->assign('category', $category);
        $this->smarty->assign('articles', $articles);
        $this->smarty->assign('currentSort', $sortParam);
        $this->smarty->assign('currentPage', $page);
        $this->smarty->assign('totalPages', $totalPages);
        // Рендерим шаблон категории
        $this->content = $this->smarty->fetch('category.tpl');
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
