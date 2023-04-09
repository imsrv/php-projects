{*
+----------------------------------------------------------------------
| Template: comments.tpl
| 
| This template is used to generate the list of comments on an
| article.
+----------------------------------------------------------------------
*}
{foreach item="comment" from=$article.comments}
		<div class="lore_article_comment_header">
			<img src="{$lore_system.base_dir}/{$image_dir}/comment.gif" align="left" alt="Comment" />
			<strong>{$comment.name}</strong>

			{if $comment.email }
			&lt;{mailto extra="class=\"lore_small_link\"" address="`$comment.email`" encode="hex"}&gt;
			{/if}

			<br />
			{$comment.created_time|format_date:"`$lore_system.settings.date_format`"} 
			at
			{$comment.created_time|format_date:"`$lore_system.settings.time_format`"}

			{if $comment.title }
			<br /><br />
			<strong>{$comment.title}</strong>
			{/if}
		</div>
		<div class="lore_article_comment_content">
			{$comment.comment|nl2br}
		</div>
{foreachelse}
	No comments have been posted.
{/foreach}
