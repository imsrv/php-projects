<form method="post" action="{S_SPLIT_ACTION}">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th><a href="{U_INDEX}" class="thCenter">{L_INDEX}</a> <img src="templates/Avalanche/images/icon_newest_reply.gif" alt="" /> <a href="{U_VIEW_FORUM}" class="thCenter">{FORUM_NAME}</a></th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center">
			<span class="gensmall">{S_TIMEZONE}</span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>

<br clear="all" />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
	<tr> 
	  <td class="cat" colspan="3" nowrap="nowrap">{L_SPLIT_TOPIC}</td>
	</tr>
	<tr> 
	  <td class="row2" colspan="3" align="center"><span class="gensmall">{L_SPLIT_TOPIC_EXPLAIN}</span></td>
	</tr>
	<tr> 
	  <td class="row1" nowrap="nowrap"><span class="gen">{L_SPLIT_SUBJECT}</span></td>
	  <td class="row2" colspan="2"><input class="post" type="text" size="35" style="width: 350px" maxlength="60" name="subject" /></td>
	</tr>
	<tr> 
	  <td class="row1" nowrap="nowrap"><span class="gen">{L_SPLIT_FORUM}</span></td>
	  <td class="row2" colspan="2">{S_FORUM_SELECT}</td>
	</tr>
	<tr> 
	  <td class="catHead" colspan="3" height="28"> 
		<table width="60%" cellspacing="0" cellpadding="0" border="0" align="center">
		  <tr> 
			<td width="50%" align="center"> 
			  <input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" />
			</td>
			<td width="50%" align="center"> 
			  <input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" />
			</td>
		  </tr>
		</table>
	  </td>
	</tr>
</table>
<table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center">
			<span class="gensmall"><a href="#top" class="gensmall">Back To Top</a></span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>

<br />
<br clear="all" />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
	<tr> 
	  <td class="cat">{L_AUTHOR}</td>
	  <td class="cat">{L_MESSAGE}</th>
	  <td class="cat">{L_SELECT}</td>
	</tr>
	<!-- BEGIN postrow -->
	<tr> 
	  <td align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a>{postrow.POSTER_NAME}</span></td>
	  <td width="100%" valign="top" class="{postrow.ROW_CLASS}"> 
		<table width="100%" cellspacing="0" cellpadding="3" border="0">
		  <tr> 
			<td valign="middle"><img src="templates/subSilver/images/icon_minipost.gif" alt="{L_POST}"><span class="postdetails">{L_POSTED}: 
			  {postrow.POST_DATE}&nbsp;&nbsp;&nbsp;&nbsp;{L_POST_SUBJECT}: {postrow.POST_SUBJECT}</span></td>
		  </tr>
		  <tr> 
			<td valign="top"> 
			  <hr size="1" />
			  <span class="postbody">{postrow.MESSAGE}</span></td> 
		  </tr>
		</table>
	  </td>
	  <td width="5%" align="center" class="{postrow.ROW_CLASS}">{postrow.S_SPLIT_CHECKBOX}</td>
	</tr>
	<tr> 
	  <td colspan="3" height="1" class="row3"><img src="templates/subSilver/images/spacer.gif" width="1" height="1" alt="."></td>
	</tr>
	<!-- END postrow -->
	<tr> 
	  <td class="catBottom" colspan="3" height="28"> 
		<table width="60%" cellspacing="0" cellpadding="0" border="0" align="center">
		  <tr> 
			<td width="50%" align="center"> 
			  <input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" />
			</td>
			<td width="50%" align="center"> 
			  <input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" />
			  {S_HIDDEN_FIELDS} </td>
		  </tr>
		</table>
	  </td>
	</tr>
</table>
 <table width="100%" cellspacing="0" border="0" cellpadding="0">
	<tr>
		<td class="left_bottom"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom3"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom2"><span class="gensmall">&nbsp;</span></td>
		<td class="middle_bottom" align="center">
			<span class="gensmall"><a href="#top" class="gensmall">Back To Top</a></span>
		</td>
		<td class="right_bottom"><span class="gensmall">&nbsp;</span></td>
	</tr>
</table>
</form>
