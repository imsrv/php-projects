{*
+----------------------------------------------------------------------
| Template: articles.tpl
| 
| This template is used to generate the list of articles shown
| on the front page and in each category. It differs from the template
| articles_short.tpl in that featured articles are displayed at the
| top of the list.
+----------------------------------------------------------------------
*}
<!-- FEATURED ARTICLES -->
{foreach item="article" from=$articles}
	{if $article.featured}
	<div class="lore_article_featured">
		<table width="100%">
		<tr>
		<td valign="top">
			<img src="{$lore_system.base_dir}/{$image_dir}/article_featured.gif" alt="article" />
		</td>
		<td valign="middle" width="100%">
			<a class="lore_normal_link" href="{$lore_system.base_dir}/{lore_link type=article category_id="`$category.id`" category_name="`$category.name`" article_title="`$article.title`" article_id="`$article.id`"}">{$article.title}</a>

			{if $lore_system.settings.show_article_previews }
				<span class="lore_article_preview_font">
					<br />
					{$article.preview|strip_tags:false|truncate:"`$lore_system.settings.article_short_preview_length`":"..."}
				</span>
			{/if}
			<br />
	
			{if $lore_system.settings.show_article_details }
				<span class="lore_article_details_font">
				{if $article.num_ratings }
					{if floor($article.rating) == 5 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" />
					{elseif $article.rating > 4.25}
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_half.gif" alt="" />
					{elseif floor($article.rating) == 4 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif $article.rating > 3.25}
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_half.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif floor($article.rating) == 3 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif $article.rating > 2.25}
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_half.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif floor($article.rating) == 2 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif $article.rating > 1.25}
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_half.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif floor($article.rating) == 1 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{/if}
					&nbsp;
				{else}
					(No rating)&nbsp;
				{/if}
	
					{$article.created_time|format_date:"`$lore_system.settings.date_format`"}
					&nbsp;&nbsp;
					Views: {$article.num_views}
					&nbsp;&nbsp;
	
					{if $lore_system.settings.enable_comments }
						Comments: {$article.num_comments}
					{/if}
				</span>
			{/if}
		</td>
		</tr>
		</table>

	</div>
	{/if}
{/foreach}

<!-- REGULAR ARTICLES -->
{foreach item="article" from=$articles}
	{if !$article.featured}
	<div class="lore_article">

		<table width="100%">
		<tr>
		<td valign="top">
			<img src="{$lore_system.base_dir}/{$image_dir}/article.gif" alt="article" />
		</td>
		<td valign="middle" width="100%">
			<a class="lore_normal_link" href="{$lore_system.base_dir}/{lore_link type=article category_id="`$category.id`" category_name="`$category.name`" article_title="`$article.title`" article_id="`$article.id`"}">{$article.title}</a>
	
			{if $lore_system.settings.show_article_previews }
				<span class="lore_article_preview_font">
					<br />
					{$article.preview|strip_tags:false|truncate:"`$lore_system.settings.article_short_preview_length`":"..."}
				</span>
			{/if}
			<br />
	
			{if $lore_system.settings.show_article_details }
				<span class="lore_article_details_font">
				{if $article.num_ratings }
					{if floor($article.rating) == 5 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" />
					{elseif $article.rating > 4.25}
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_half.gif" alt="" />
					{elseif floor($article.rating) == 4 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif $article.rating > 3.25}
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_half.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif floor($article.rating) == 3 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif $article.rating > 2.25}
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_half.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif floor($article.rating) == 2 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif $article.rating > 1.25}
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_half.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{elseif floor($article.rating) == 1 }
						<img src="{$lore_system.base_dir}/{$image_dir}/star_small.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" /><img src="{$lore_system.base_dir}/{$image_dir}/star_small_grey.gif" alt="" />
					{/if}
					&nbsp;
				{else}
					(No rating)&nbsp;
				{/if}
	
					{$article.created_time|format_date:"`$lore_system.settings.date_format`"}
					&nbsp;&nbsp;
					Views: {$article.num_views}
					&nbsp;&nbsp;
	
					{if $lore_system.settings.enable_comments }
						Comments: {$article.num_comments}
					{/if}
				</span>
			{/if}

		</td>
		</tr>
		</table>
	</div>
	{/if}
{foreachelse}
	No articles found.
{/foreach}
