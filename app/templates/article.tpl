<div class="main">
<div class="wrap">
	<section id="stati__">
       <div class="container plr-mobile">
          <div class="stati__">
		  <h1>
		 {if isset($article.title)}
			   {$article.title}
			 {/if}
		</h1>
		    <div class='view'><span>views:</span> {$article.views_count}</div>
			{if isset($article.img)}
		    <div class='stati__img'>
		   
			 <div class='badge__data'>
	          {if isset($article.created_at)}
			   {$article.created_at}
			 {/if}
	         </div>
		      <img src="images/{$article.img}" alt="stati"/>
			</div>
		  {/if}
			<div class='text'>
			<p>
	         {if isset($article.description)}
			   {$article.description}
			 {/if}
			</p>
		</div>
		  </div>
		</div>
</section>

<section id="news__" style="clear:both">
 <div class="container plr-mobile">
  <div class="news__">
   {foreach $related as $article}
     {include file='componets/card.tpl' article=$article}
  {/foreach}
  </div>
 </div>
</section>
</div>