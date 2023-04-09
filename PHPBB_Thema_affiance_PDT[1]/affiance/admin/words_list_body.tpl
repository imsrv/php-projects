
<h1>{L_WORDS_TITLE}</h1>

<P>{L_WORDS_TEXT}</p>

<form method="post" action="{S_WORDS_ACTION}"><table cellspacing="0" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_WORD}</th>
		<th class="thTop">{L_REPLACEMENT}</th>
		<th colspan="2" class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN words -->
	<tr>
		<td class="row1" align="center"><span class="gen">{words.WORD}</span></td>
		<td class="row1" align="center"><span class="gen">{words.REPLACEMENT}</span></td>
		<td class="row1"><a href="{words.U_WORD_EDIT}"><span class="gen">{L_EDIT}</a></span></td>
		<td class="row1"><a href="{words.U_WORD_DELETE}"><span class="gen">{L_DELETE}</a></span></td>
	</tr>
	<!-- END words -->
	<tr>
		<td colspan="5" align="center" class="catBottom">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_ADD_WORD}" class="mainoption" /></td>
	</tr>
</table></form>
