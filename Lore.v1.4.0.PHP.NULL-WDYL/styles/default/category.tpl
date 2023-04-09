{*
+----------------------------------------------------------------------
| Template: category.tpl
| 
| This template is used to display a category page, which includes the
| name/description of the category, the listing of subcategories, and
| the listing of articles in the category.
+----------------------------------------------------------------------
*}
{include file="header.tpl" title="`$category.name`"}

<h2>{$category.name}</h2>
{if $category.description}
	{$category.description}
	<br /><br />
{/if}

<div class="lore_content_box">
	{include file="articles.tpl"}
</div>

{if $categories}
	<h3>Subcategories</h3>
	<div class="lore_content_box">
		{include file="categories.tpl"}
	</div>
{/if}

{include file="footer.tpl"}