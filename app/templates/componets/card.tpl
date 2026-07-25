<div class="news__item">
{if isset($article.img)}
 <a href="/article?id={$article.id}">
 <img src="/images/{$article.img}" alt="news"/>
 </a>
{/if}
<div class="news__content">
 <p class="title">
  {if isset($article.title)}
   {$article.title|truncate:70:"..."}
  {else}Заголовок отсутствует
  {/if}
 </p>
 <div class="news__text">
  {if isset($article.description)}
   {$article.description|truncate:200:"..."}
  {/if}
 </div>
 <a href="/article?id={$article.id}">Читать далее</a>
</div>
<div class='badge__data'>
 {if isset($article.created_at)}{$article.created_at|date_format:"%B %e, %Y"}{/if}
</div>
</div>

