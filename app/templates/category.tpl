<div class="main">
    <div class="wrap">

 <section id="news__">
            <div class="container plr-mobile">
                <div class="news__">
                    <!-- 1. ЦИКЛ ВЫВОДА СТАТЕЙ -->
                    {if !empty($articles)}
                        {foreach $articles as $article}
                            <div class="news__item" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eee;">
							<img src="images/news.png" alt="news"/>
                                <h3><a href="/article?id={$article.id}">{$article.title}</a></h3>
                                <p>{$article.description|truncate:200:"..."}</p>
                                 <a href="#">Читать далее</a>
                            </div>
                        {/foreach}
                    {else}
                        <p>В этой категории пока нет статей.</p>
                    {/if}
                </div>
            </div>
        </section>
      
    </div>
</div>
