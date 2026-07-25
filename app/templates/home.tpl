<div class="main">
    <div class="wrap">
        <section id="news__">
            <div class="container plr-mobile">
                <div class="news__">
                    
                    {* 1. Проверяем, существует ли переменная $categories и является ли она массивом *}
                    {if isset($categories) && is_array($categories)}
                        
                        {foreach $categories as $category}
                            
                            {* 2. Проверяем наличие заголовка категории *}
                            <div class="category_name">
                                {if isset($category.title)}
								{$category.title}
								<a href="/category">all articles</a>
								
								{else}Без названия{/if}
                            </div>
                            
                            {* 3. Проверяем, есть ли статьи в этой категории и массив ли это *}
                            {if isset($category.articles) && is_array($category.articles)}
                                
                                {foreach $category.articles as $article}
                                    <div class="news__item">
                                        <img src="images/news.png" alt="news"/>
                                        
                                        <div class="news__content">
                                            {* 4. Безопасный вывод заголовка статьи *}
                                            <p class="title">
                                                {if isset($article.title)}{$article.title}{else}Заголовок отсутствует{/if}
                                            </p>
                                            
                                            {* 5. Безопасный вывод описания статьи *}
                                            <div class="news__text">
                                                {if isset($article.description)}{$article.description}{/if}
                                            </div>
                                            
                                            {* Исправили опечатку в теге ссылки <a>, которая была в оригинале *}
                                            <a href="#">Читать далее</a>
                                        </div>
                                        
                                        {* 6. Безопасный вывод даты создания *}
                                        <div class='badge__data'>
                                            {if isset($article.created_at)}{$article.created_at}{/if}
                                        </div>
                                    </div>
                                {/foreach}
                                
                            {else}
                                <p>В этой категории пока нет статей.</p>
                            {/if}
                            
                        {/foreach}
                        
                    {else}
                        <p>Новости временно недоступны.</p>
                    {/if}

                </div>
            </div>
        </section>
    </div>
</div>
