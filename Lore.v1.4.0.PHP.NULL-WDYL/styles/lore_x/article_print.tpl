{*
+----------------------------------------------------------------------
| Template: article_print.tpl
| 
| This template is used to display the printer-friendly version
| of an article.
+----------------------------------------------------------------------
*}
<html>
<head>
	<title>{$lore_system.settings.knowledge_base_name|default:"Lore"} .: {$title|default:$lore_system.settings.knowledge_base_description}</title>
	<link rel="stylesheet" type="text/css" href="{$lore_system.base_dir}/{$style_dir}/stylesheets/{$stylesheet}" />
</head>

<body onLoad="window.print();">

From: <strong>{$lore_system.settings.knowledge_base_name}</strong>
<br />
<a href="{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}/">{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}/</a>
<br /><br />

<div class="print_article_header">
	{$article.title}
	<br />
	<a class="lore_small_link" href="{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}/{lore_link type=article article_id="`$article.id`" article_title="`$article.title`" category_id="`$article.category_id`" category_name="`$article.category_name`"}">{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}/{lore_link type=article article_id="`$article.id`" article_title="`$article.title`" category_id="`$article.category_id`" category_name="`$article.category_name`"}</a>
</div>

<div class="print_article_box">
	{$article.content}
</div>

<br />

{if $article.comments }
	<div class="print_article_header">
		Comments
	</div>
	
	{foreach item=comment from=$article.comments}
		<div class="print_article_box">
			<strong>{$comment.name}</strong>
		
			{if $comment.email }
				&lt;{$comment.email}&gt;
			{/if}
		
			<br />
			{$comment.created_time|format_date:"`$lore_system.settings.date_format`"} at {$comment.the_time|format_date:"`$lore_system.settings.time_format`"}
		
			{if $comment.title }
				<br /><br />
				<strong>{$comment.title}</strong>
			{/if}
		
			<br /><br />
			{$comment.comment}
		</div>
	{/foreach}
{/if}

{include file="html_footer.tpl"}
