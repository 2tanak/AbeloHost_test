<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Article;

class HomeController extends BaseController
{
    public function setContent(): void 
    {
		
       $content = Article::getLatestPerCategory(10, 0);
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
