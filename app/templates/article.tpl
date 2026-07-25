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
		    <div class='stati__img'>
			
			 <div class='badge__data'>
	          {if isset($article.created_at)}
			   {$article.created_at}
			 {/if}
	         </div>
		      <img src="images/stati.png" alt="stati"/>
			</div>
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