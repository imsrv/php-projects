{*
+----------------------------------------------------------------------
| Template: index.tpl
| 
| This template is used to display the front page of the knowledge
| base.
+----------------------------------------------------------------------
*}
{include file="header.tpl"}

<h2>
	{$lore_system.settings.knowledge_base_name}
</h2>

{if $articles}
	<div class="lore_content_box">
		{include file="articles.tpl"}
	</div>
{/if}

{if $categories}
	<h3>Categories</h3>
	<div class="lore_content_box">
		{include file="categories.tpl"}
	</div>
{/if}

<table width="100%">
{if $lore_system.settings.show_latest_articles }
	<tr>
	<td valign="top" colspan="2" width="100%">
		<h3>Latest Articles</h3>
		<div class="lore_content">
			{include file="articles_short.tpl" articles=$articles_latest}
		</div>
	</td>
	</tr>
{/if}
<tr>

{if $lore_system.settings.show_most_viewed_articles }
	<td valign="top" width="50%">
		<h3>Most Popular Articles</h3>
		<div class="lore_content">
			{include file="articles_short.tpl" articles=$articles_most_viewed}
		</div>
	</td>
{/if}

{if $lore_system.settings.show_highest_rated_articles }
	<td valign="top" width="50%">
		<h3>Highest Rated Articles</h3>
		<div class="lore_content">
			{include file="articles_short.tpl" articles=$articles_highest_rated}
		</div>
	</td>
{/if}

</tr>
</table>

{include file="footer.tpl"}
