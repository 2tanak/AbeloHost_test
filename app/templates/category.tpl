<div class="main">
 <div class="wrap">
  <div class="category-header container" style="margin-bottom: 30px;">
   <h1>{$category.title}</h1>
   <p>{$category.description}</p>
</div>
<div class="sorting container">
  Сортировать по: 
 <a href="/category?id={$category.id}&sort=date" style="{if $currentSort == 'date'}font-weight: bold; color: #ff0000;{/if}">Дате</a> | 
 <a href="/category?id={$category.id}&sort=views" style="{if $currentSort == 'views'}font-weight: bold; color: #ff0000;{/if}">Просмотрам</a>
</div>
    
 <section id="news__">
  <div class="container plr-mobile">
  {if $totalPages > 1}
   <div class='paginate__'>
   {for $p=1 to $totalPages}
    {if $currentPage == $p}
	 <div><a class="active" href="/category?id={$category.id}&sort={$currentSort}&page={$p}" style="">{$p}</a></div>
	{else}
	 <div>
	  <a href="/category?id={$category.id}&sort={$currentSort}&page={$p}" style="">{$p}</a>
	 </div>
   {/if}
  {/for}
 </div>
{/if}
<div class="news__">
 {if !empty($articles)}
   {foreach $articles as $article}
     {include file='componets/card.tpl' article=$article}
   {/foreach}
 {else}
   <p>В этой категории пока нет статей.</p>
 {/if}
</div>
</div>
</section>
      
	
	  
	 
	  
	  
	  
	  
	  
	  
	  
	  
    </div>
</div>
