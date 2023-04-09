<u>Lore Version:</u> <b>{$lore_system.version}</b>
<br /><br />

<table>
<tr>
<td width="50%" valign="top">
	<div class="content_header">
		<div class="content_header_caption" style="width: 150px">
			System Information
		</div>
	</div>

	<b><a href="http://www.php.net" target="_blank">PHP</a> version:</b> 
	{$php_version}
	&nbsp;&nbsp;&nbsp;
	<b><a href="http://www.mysql.com" target="_blank">MySQL</a> version:</b> {$mysql_version}	
	<bt /><br /><br />
	
	<b>Current Time:</b> {$lore_system.time|format_date:$lore_system.settings.date_format} at {$lore_system.time|format_date:$lore_system.settings.time_format}
	<br />
	
	<b>Software Version:</b> {$lore_system.version}
	<br />
	
	<b>Installation Date:</b> {$system_info.install_time|format_date:$lore_system.settings.date_format} at {$system_info.install_time|format_date:$lore_system.settings.time_format}
</td>
<td width="50%" valign="top">
	<div class="content_header">
		<div class="content_header_caption" style="width: 150px">
			Lore Resources
		</div>
	</div>
	
</td>
</tr>
</table>



<div class="content_header">
	<div class="content_header_caption" style="width: 150px">
		Pending Content
	</div>
</div>
<div class="content">
	{if $system_info.unapproved_comments}
		<a href="{$lore_system.scripts.cp_comment}?action=browse&approved=0}">There are ({$system_info.unapproved_comments}) unapproved comments.</a>
	{else}
		There are no unapproved comments.
	{/if}

	<br />
</div>

<table>
<tr>
<td width="25%" valign="top">

	<div class="content_header">
		<div class="content_header_caption" style="width: 150px">
			Database Information
		</div>
	</div>



	<table width="100%">
	<tr><th colspan="2">Articles</th></tr>
	<tr><td>Total</td> <td>{$system_info.articles_total}</td></tr>
	<tr><td>Published</td> <td>{$system_info.articles_published}</td></tr>
	<tr><td>Unpublished</td> <td>{$system_info.articles_unpublished}</td></tr>

	<tr><th colspan="2">Categories</th></tr>
	<tr><td>Total</td> <td>{$system_info.categories_total}</td></tr>
	<tr><td>Published</td> <td>{$system_info.categories_published}</td></tr>
	<tr><td>Unpublished</td> <td>{$system_info.categories_unpublished}</td></tr>

	<tr><th colspan="2">Article Comments</th></tr>
	<tr><td>Total</td> <td>{$system_info.comments_total}</td></tr>
	<tr><td>Approved</td> <td>{$system_info.comments_approved}</td></tr>
	<tr><td>Unapproved</td> <td>{$system_info.comments_unapproved}</td></tr>

	<tr><th colspan="2">Attachments</th></tr>
	<tr><td>Total</td> <td>{$system_info.attachments_total}</td></tr>
	<tr><td>Downloads</td> <td>{$system_info.attachments_downloads}</td></tr>

	<tr><th colspan="2">Article Stats</th></tr>
	<tr><td>Total Views</td> <td>{$system_info.article_stats_views}</td></tr>
	<tr><td>Total Ratings</td> <td>{$system_info.article_stats_ratings}</td></tr>

	<tr><th colspan="2">Glossary Terms</th></tr>
	<tr><td>Total</td> <td>{$system_info.glossary_terms_total}</td></tr>

	<tr><th colspan="2">Users</th></tr>
	<tr><td>Total</td> <td>{$system_info.users_total}</td></tr>

	</table>
</td>

<td width="25%" valign="top">

	<div class="content_header">
		<div class="content_header_caption" style="width: 150px">
			Most Viewed Articles
		</div>
	</div>

	<div class="content">
		{foreach name="articles_most_viewed_loop" item="article" from=$articles_most_viewed}
			<img src="templates/images/article.gif" /> <a href="../{$lore_system.scripts.article}?id={$article.id}" target="_blank">{$article.title}</a>
			<br />
			<small><b>Rating:</b> {$article.rating} <b>Views:</b> {$article.num_views}</small>
			<br /><br />
		{foreachelse}
			(None yet)
		{/foreach}
	</div>
</td>

<td width="25%" valign="top">
	<div class="content_header">
		<div class="content_header_caption" style="width: 150px">
			Highest Rated Articles
		</div>
	</div>
	<div class="content">
		{foreach name="articles_highest_rated_loop" item="article" from=$articles_highest_rated}
			<img src="templates/images/article.gif" /> <a href="../{$lore_system.scripts.article}?id={$article.id}" target="_blank">{$article.title}</a>
			<br />
			<small><b>Rating:</b> {$article.rating} <b>Views:</b> {$article.num_views}</small>
			<br /><br />
		{foreachelse}
			(None yet)
		{/foreach}
	</div>
</td>

<td width="25%" valign="top">
	<div class="content_header">
		<div class="content_header_caption" style="width: 150px">
			Latest Articles
		</div>
	</div>
	<div class="content">
		{foreach name="articles_latest_loop" item="article" from=$articles_latest}
			<img src="templates/images/article.gif" /> <a href="../{$lore_system.scripts.article}?id={$article.id}" target="_blank">{$article.title}</a>
			<br />
			<small><b>Rating:</b> {$article.rating} <b>Views:</b> {$article.num_views}</small>
			<br /><br />
		{foreachelse}
			(None yet)
		{/foreach}
	</div>
</td>
</tr>
</table>
