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
         {include file='componets/card.tpl' article=$article}             
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
