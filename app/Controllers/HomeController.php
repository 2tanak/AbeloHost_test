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
        $rawContent = Category::query()->select('categories.id', 'categories.title')->has('article_category', 'category_id')->with('articles')->get();

        



        //grouping: place an array with a post in each category
        $content = Helper::groupArticlesByCategory($rawContent);
		
echo "<pre>";
        print_r($content);
        echo "</pre>";
        exit();

        //echo "<pre>";print_r($rawContent);echo "</pre>";exit();
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
