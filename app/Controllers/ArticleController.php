<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Helpers\Helper;

class ArticleController extends BaseController
{
    public function setContent(): void
    {
        $id = (int)($_GET['id'] ?? 0);
		
       
		//делаем запрос но джойним с article_category, нам нужен category_id чтобы вытащить три похожие статьи
		$article = Article::query()
            ->select('articles.*', 'article_category.category_id')
            ->innerJoin('article_category', 'articles.id', '=', 'article_category.article_id')
            ->where('articles.id', '=', $id)
            ->one();
		if(isset($article['created_at'])){
		   $article['created_at'] = Helper::formatDate($article['created_at']);
		}
		 //formatDate Helper
		 
		 
		 
		
		//$this->dd($article);exit();
       

        $this->smarty->assign('article', $article);
        $this->content = $this->smarty->fetch('article.tpl');
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
