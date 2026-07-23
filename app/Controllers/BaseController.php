<?php

declare(strict_types=1);

namespace App\Controllers;

use Smarty;

abstract class BaseController 
{
    protected Smarty $smarty;
    
    protected string $header = '';
    protected string $content = '';
    protected string $footer = '';
    protected string $page = '';
    
    public function __construct()
    {
        $this->smarty = new Smarty();
        
        // Настраиваем пути строго по структуре папок
        $this->smarty->setTemplateDir(__DIR__ . '/../templates');
        $this->smarty->setCompileDir(__DIR__ . '/../templates_c');
        $this->smarty->setCacheDir(__DIR__ . '/../cache'); // Поправили слэш здесь
    }

    /**
     * Абстрактный метод для сборки контента конкретной страницы
     */
    abstract public function setContent(): void;
    
    /**
     * Рендеринг шапки сайта
     */
    protected function setHeader(): void 
    {
        $this->header = $this->smarty->fetch('header.tpl');
    }
    
    /**
     * Рендеринг подвала сайта
     */
    protected function setFooter(): void 
    {
        $this->footer = $this->smarty->fetch('footer.tpl');
    }
    
    /**
     * Главный управляющий метод сборки страницы
     */
    public function output(): void
    {
        $this->setHeader();
        $this->setContent(); 
        $this->setFooter();

        // Прокидываем собранные куски в главный лейаут
        $this->smarty->assign([
            'header'  => $this->header,
            'content' => $this->content,
            'footer'  => $this->footer,
        ]);

        // Рендерим финальную страницу в строку
        $this->page = $this->smarty->fetch('layouts/main.tpl');

        // Просто вызываем вывод, без return
        $this->getPage();
    }
    
    /**
     * Финальный вывод скомпилированной страницы в браузер
     */
    public function getPage(): void 
    {
        echo $this->page;
    }
}
