{*
+----------------------------------------------------------------------
| Template: search_results.tpl
| 
| This template is used to display the results of a search done
| on the knowledge base, including the categories and articles 
| matched (if any).
+----------------------------------------------------------------------
*}
{include file="header.tpl" action="Search Results"}

<h2>Search Results</h2>

{if !$num_categories && !$num_articles }
	No articles or categories matched "<strong>{$search_query|escape}</strong>".
{else}
	Your search for "<strong>{$search_query|escape}</strong>" matched <strong>{$num_articles}</strong> 
	articles and <strong>{$num_categories}</strong> categories.
{/if}

<br /><br />

{if $articles}
	<h3>Articles</h3>
	<div class="lore_content_box">
		{include file="articles_short.tpl"}
	</div>
{/if}

{if $categories}
	<h3>Categories</h3>
	<div class="lore_content_box">	
		{include file="categories.tpl"}
	</div>
{/if}

{include file="footer.tpl"}