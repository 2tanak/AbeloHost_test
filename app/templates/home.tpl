<div class="main">
    <div class="wrap">
        <section id="news__">
            <div class="container plr-mobile">
                <div class="news__">
                    
                   
                    {if isset($categories) && is_array($categories)}
                        
                        {foreach $categories as $category}
                            
                          
                            <div class="category_name">
                                {if isset($category.title)}
								{$category.title}
								<a href="/category?id={$category.id}">all articles</a>
								
								{else}Без названия{/if}
                            </div>
                            
                            
                            {if isset($category.articles) && is_array($category.articles)}
                                
                                {foreach $category.articles as $article}
                                    <div class="news__item">
                                        <img src="images/news.png" alt="news"/>
                                        
                                        <div class="news__content">
                                           
                                            <p class="title">
                                                {if isset($article.title)}{$article.title}{else}Заголовок отсутствует{/if}
                                            </p>
                                            
                                           
                                            <div class="news__text">
                                                {if isset($article.description)}{$article.description}{/if}
                                            </div>
                                          
                                            <a href="#">Читать далее</a>
                                        </div>
                                        
                                       
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
