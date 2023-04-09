<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">
  <tr> 
    <th class="thTop" colspan="2" height="25"><b>{L_SPLIT_TOPIC}</b></th>
  </tr>
</table>



<table align="CENTER" class="forumline" border="0" cellpadding="2" cellspacing="1" width="717">
  <tr> 
    <th colspan="1" align="left" height="28" class="nav" nowrap="nowrap">{L_SPLIT_TOPIC}</th>
  </tr>
</table>

  <table align="CENTER" class="forumline" width="717" cellpadding="4" cellspacing="1" border="0">
<form method="post" action="{S_SPLIT_ACTION}">
    <tr align="LEFT" valign="TOP"> 
      <td class="row2" colspan="3"><table align="LEFT" cellspacing="1" cellpadding="5" border="0"><td><span class="gensmall"><br />{L_SPLIT_TOPIC_EXPLAIN}<br /><br /></span></td></table></td>
    </tr>
  <tr> 
    <td class="spaceRow" colspan="3" height="1"><img src="templates/AdInfinitum/images/spacer.gif" alt="" width="1" height="1" /></td>
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
      <td class="row3" colspan="3" height="28"> <table width="60%" cellspacing="0" cellpadding="0" border="0" align="center">
          <tr> 
            <td width="50%" align="center"> <input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" /> 
            </td>
            <td width="50%" align="center"> <input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" /> 
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <th align="LEFT" nowrap="nowrap" class="nav">{L_AUTHOR}</th>
      <th align="LEFT" nowrap="nowrap" class="nav">{L_MESSAGE}</th>
      <th align="LEFT" nowrap="nowrap" class="nav">{L_SELECT}</th>
    </tr>
    <!-- BEGIN postrow -->
    <tr> 
      <td align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a>{postrow.POSTER_NAME}</span></td>
      <td width="100%" valign="top" class="{postrow.ROW_CLASS}"> <table width="100%" cellspacing="0" cellpadding="3" border="0">
          <tr> 
            <td valign="middle"><img src="templates/AdInfinitum/images/icon_minipost.gif" alt="{L_POST}"><span class="postdetails">{L_POSTED}: 
              {postrow.POST_DATE}&nbsp;&nbsp;&nbsp;&nbsp;{L_POST_SUBJECT}: {postrow.POST_SUBJECT}</span></td>
          </tr>
          <tr> 
            <td valign="top"> <hr size="1" /> <span class="postbody">{postrow.MESSAGE}</span></td>
          </tr>
        </table></td>
      <td width="5%" align="center" class="{postrow.ROW_CLASS}">{postrow.S_SPLIT_CHECKBOX}</td>
    </tr>
    <!-- END postrow -->
    <tr> 
      <td class="row3" colspan="3" height="28"> <table width="60%" cellspacing="0" cellpadding="0" border="0" align="center">
          <tr> 
            <td width="50%" align="center"> <input class="liteoption" type="submit" name="split_type_all" value="{L_SPLIT_POSTS}" /> 
            </td>
            <td width="50%" align="center"> <input class="liteoption" type="submit" name="split_type_beyond" value="{L_SPLIT_AFTER}" />
              {S_HIDDEN_FIELDS} </td>
          </tr>
        </table></td>
    </tr>
  </form>
  </table>
  
<table width="717" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
    <td align="left"></td>
    <td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>
<br>
<table align="CENTER" width="717" border="0" cellspacing="0" cellpadding="2">
  <tr> 
    <th colspan="2" class="thTop" height="25" nowrap="nowrap"><table align="LEFT" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="LEFT" valign="TOP"></td>
          <td align="RIGHT" valign="TOP"><span class="gen"></span></td>
        </tr>
        <tr align="LEFT" valign="TOP"> 
          <td colspan="2"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> 
            -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
        </tr>
      </table></th>
  </tr>
</table>
