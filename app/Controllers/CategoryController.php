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


        if ($catId <= 0) {
            header('Location: /');
            exit();
        }


        $articles = Article::byCategory($catId)
            ->orderBy($sortColumn, 'DESC')
            ->paginate(4, $page)
            ->get();

        /*   
echo "<pre>";
        print_r($category);
        echo "</pre>";
        exit();
	*/
        if (empty($articles)) {
            header('Location: /');
            exit();
        }

        $this->smarty->assign('articles', $articles);

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
