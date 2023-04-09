{*
+----------------------------------------------------------------------
| Template: article.tpl
| 
| This template is used when displaying an article.
+----------------------------------------------------------------------
*}
{include file="header.tpl" title="`$article.title`"}

<!-- overLIB Code -->
<script type="text/javascript" src="{$lore_system.base_dir}/third_party/overlib/overlib.js"><!-- overLIB (c) Erik Bosrup --></script>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<!-- End overLIB Code -->

{if $article.display_edit_link }
	<div style="text-align: center;">
		<div class="lore_article_admin_options" style="width: 450px;">
			Administrative Options: &nbsp; [ <a class="lore_normal_link" href="{$lore_system.base_dir}/cp/index.php?goto={$lore_system.scripts.cp_article}%3Fid={$article.id}%26action=edit">Edit Article</a> ]
		</div>
	</div>
{/if}
<br />

<h2>{$article.title}</h2>

<table width="100%">
<tr>
<td width="*" valign="top">
	<div class="lore_article_content">
		{$article.content}
	</div>
</td>

{if $lore_system.settings.show_article_info OR $article.attachments }
<td width="130" valign="top">

	{if $lore_system.settings.show_article_info }
		<table class="lore_article_info_box" width="100%">
		<tr>
		<td class="lore_article_info_box_label">
			Article
		</td>
		<td class="lore_article_info_box_data">
			{$article.id}
		</td>
		</tr>

		<tr>
		<td class="lore_article_info_box_label">
			Created
		</td>
		<td class="lore_article_info_box_data">
			{$article.created_time|format_date:"`$lore_system.settings.date_format`"} 
		</td>
		</tr>

		{if $article.modified_time}
		<tr>
		<td class="lore_article_info_box_label">
			Modified
		</td>
		<td class="lore_article_info_box_data">
			{$article.modified_time|format_date:"`$lore_system.settings.date_format`"}
		</td>
		</tr>
		{/if}

		<tr>
		<td class="lore_article_info_box_label">
			Author
		</td>
		<td class="lore_article_info_box_data">
			{mailto extra="class=\"lore_small_link\"" address="`$article.email`" text="`$article.username`" encode="hex"}
		</td>
		</tr>

		{if $lore_system.settings.show_article_ratings}
		<tr>
		<td class="lore_article_info_box_label">
			Rating
		</td>
		<td class="lore_article_info_box_data">
			{if $article.num_ratings }
				{if floor($article.rating) == 5 }
					<img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" />
				{elseif $article.rating > 4.25}
					<img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_half.gif" />
				{elseif floor($article.rating) == 4 }
					<img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" />
				{elseif $article.rating > 3.25}
					<img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_half.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" />
				{elseif floor($article.rating) == 3 }
					<img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" />
				{elseif $article.rating > 2.25}
					<img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_half.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" />
				{elseif floor($article.rating) == 2 }
					<img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" />
				{elseif $article.rating > 1.25}
					<img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_half.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" />
				{elseif floor($article.rating) == 1 }
					<img src="{$lore_system.base_dir}/{$image_dir}/star.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" /><img src="{$lore_system.base_dir}/{$image_dir}/star_grey.gif" />
				{/if}
			{else}
				(None)
			{/if}
		</td>
		</tr>
		{/if}
		
		</table>
	{/if}

	{if $article.attachments}
		<div class="lore_article_info_box">
			<img src="{$lore_system.base_dir}/{$image_dir}/article.gif" /> <strong>Attachments</strong>
			<br />
			{foreach item="attachment" from=$article.attachments}
				<br />
				<a class="lore_small_link" href="{$lore_system.base_dir}/{$lore_system.scripts.attachment}?id={$attachment.id}">{$attachment.filename|slice:20:'...'}</a>
				<span class="lore_article_info_font">
				<br />
				{$attachment.filesize|fsize_format:KB:1}
				<br />
				Downloaded {$attachment.num_downloads} time(s)
				</span>
				<br />
			{/foreach} 
		</div>
	{/if}

</td>
{/if}
</tr>
</table>


<div style="text-align:center;margin-top:25px;">
	
	<a class="lore_dark_link" href="{$lore_system.base_dir}/{$lore_system.scripts.email_article}?article_id={$article.id}"><img src="{$lore_system.base_dir}/{$image_dir}/email.gif" alt="" border="0" align="middle"/>  Email</a>
	&nbsp;&nbsp;
	<a class="lore_dark_link" href="#" onclick="window.open('{$lore_system.base_dir}/{$lore_system.scripts.article}?id={$article.id}&action=print','print','statusbar=no,menubar=no,toolbar=no,scrollbars=yes,resizable=yes,width=800,height=600'); return false;"><img src="{$lore_system.base_dir}/{$image_dir}/print.gif" alt="" align="middle" border="0" /> Print</a>

	{if $lore_system.settings.show_comments && $article.allow_comments }
		&nbsp;&nbsp;
		<a class="lore_dark_link" href="{$lore_system.base_dir}/{$lore_system.scripts.comment}?article_id={$article.id}&action=new"><img src="{$lore_system.base_dir}/{$image_dir}/add_comment.gif" alt="" border="0" align="middle" /> Add Comment</a>
	{/if}
</div>


{if $lore_system.settings.allow_article_ratings}
	<br />
	<div style="text-align: center;">
	<a name="rate"></a>
	<form method="post" action="{$lore_system.base_dir}/{$lore_system.scripts.rate}">
			<small><i>How helpful was this article to you?</i></small>
			<select class="lore_input" name="rating">
				<option value="" selected="selected"></option>
				<option value="5">5 - Very Helpful</option>
				<option value="4">4</option>
				<option value="3">3 - Somewhat Helpful</option>
				<option value="2">2</option>
				<option value="1">1 - Not Helpful</option>
			</select>
			<input type="hidden" name="article_id" value="{$article.id}" />
			<input class="lore_button" type="submit" name="submit" value="Rate" />
	</form>
	</div>
{/if}


<div style="margin: 30px">
	{if $lore_system.settings.show_related_articles AND $article.related_articles }
		<h3>Related Articles</h3>
		<div class="lore_content_box">
			{include file="articles.tpl" articles=$article.related_articles}	
		</div>
	{/if}
	
	<a name="comments"></a>
	{if $lore_system.settings.show_comments }
		<h3>User Comments</h3>
		<div class="lore_content_box">
			{if $article.allow_comments }
				<a class="lore_dark_link" href="{$lore_system.base_dir}/{$lore_system.scripts.comment}?article_id={$article.id}&action=new"><img src="{$lore_system.base_dir}/{$image_dir}/add_comment.gif" alt="" border="0" align="middle" /> Add Comment</a>
			{/if}

			<div class="lore_article_comments">
				{include file="comments.tpl"}
			</div>
		</div>
	{/if}
</div>

{include file="footer.tpl"}
