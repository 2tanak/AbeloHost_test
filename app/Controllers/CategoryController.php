<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Helpers\Helper;

class CategoryController extends BaseController
{
    public function setContent(): void
    {
       
        //$this->smarty->assign('categories', $content);

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
