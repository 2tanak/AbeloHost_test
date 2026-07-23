<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;
use App\Helpers\Helper;

class HomeController extends BaseController
{
    public function setContent(): void 
    {
	   // Fetch categories with three posts each
        $rawContent = Article::getLatestPerCategory(10, 0);
	   
	    // Group the raw database data to nest post sub-arrays inside their respective categories
        $content = Helper::groupArticlesByCategory($rawContent);
	   
	   
	   echo "<pre>";print_r($content);echo "</pre>";
	   exit();
	   
        $this->smarty->assign('categories', $content);
        
        $this->content = $this->smarty->fetch('content.tpl');
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
