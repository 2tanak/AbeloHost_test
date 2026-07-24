<div class="main">
<div class="wrap">
<section id="news__">

<div class="container plr-mobile">
  <div class="news__">
  {foreach $categories as $category}
    {foreach $category['articles'] as $article}
  
    <div class="news__item">
	  <img src="images/news.png" alt="news"/>
	
	<div class="news__content">
	<p class="title">{$article['title']}</p>
	  <div class="news__text">
	     {$article['description']}
	  </div>
	  <a href="#"/>Читать далее</a>
	  
	</div>
	
	<div class='badge__data'>
	{$article['created_at']}
	
	   
	  </div>
	</div>
	 {/foreach}
	{/foreach}
</div>
  <div class='paginate__'>
		   <div class='paginate__left'><a href="">
		     	<svg>
					<use xlink:href="images/sprites/sprite-mono.svg#paginate-left"></use>
				</svg>
		   
		   </a></div>
		    <div><a href="">1</a></div>
		    <div><a href="">2</a></div>
			<div><a href="">3</a></div>
			<div><a href="">4</a></div>
			<div><a href="">5</a></div>
		   <div class='paginate__right'>
		   <a href="">
		   <svg>
					<use xlink:href="images/sprites/sprite-mono.svg#paginate-right"></use>
				</svg>
		   </a>
		   </div>
		</div>
 </div>
  
</section>

	</div>
	</div>

