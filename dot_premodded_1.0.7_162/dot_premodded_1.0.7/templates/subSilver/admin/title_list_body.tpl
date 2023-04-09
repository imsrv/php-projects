
<h1>{ADMIN_TITLE}</h1>

<p>{ADMIN_TITLE_EXPLAIN}</p>
<span class="nav">{PAGINATION}</span>
<form method="post" action="{S_TITLE_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thTop">{HEAD_TITLE}</th>
		<th class="thTop">{HEAD_AUTH}</th>
		<th class="thTop">{HEAD_DATE}</th>
		<th class="thTop">{L_EDIT}</th>
		<th class="thCornerR">{L_DELETE}</th>
	</tr>
	<!-- BEGIN title -->
	<tr>
		<td class="{title.ROW_CLASS}" align="center">{title.TITLE}</td>
		<td class="{title.ROW_CLASS}" align="center">{title.PERMISSIONS}</td>
		<td class="{title.ROW_CLASS}" align="center">{title.DATE_FORMAT}</td>
		<td class="{title.ROW_CLASS}" align="center"><a href="{title.U_TITLE_EDIT}">{L_EDIT}</a></td>
		<td class="{title.ROW_CLASS}" align="center"><a href="{title.U_TITLE_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END title -->			
	<tr>
		<td class="catBottom" align="center" colspan="8"><input type="submit" class="mainoption" name="add" value="{ADD_NEW}" /></td>
	</tr>
</table></form>
<span class="nav">{PAGINATION}</span>
