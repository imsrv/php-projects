<br />
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th class="thLeft"><img src="templates/Avalanche/images/thLeft.gif" width="30"/></th>
		<th width="100%">&nbsp;</th>
		<th class="thRight"><img src="templates/Avalanche/images/thRight.gif" width="30"/></th>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
	<tr>
		<td colspan="4" class="cat" align="center"><b>{POLL_QUESTION}</b></td>
	  </tr>
	  <tr> 
		<td align="center" class="row1"> 
		  <table cellspacing="0" cellpadding="2" border="0">
			<!-- BEGIN poll_option -->
			<tr> 
			  <td><span class="gen">{poll_option.POLL_OPTION_CAPTION}</span></td>
			  <td> 
				<table cellspacing="0" cellpadding="0" border="0">
				  <tr> 
					<td><img src="templates/subSilver/images/vote_lcap.gif" width="4" alt="" height="12" /></td>
					<td><img src="{poll_option.POLL_OPTION_IMG}" width="{poll_option.POLL_OPTION_IMG_WIDTH}" height="12" alt="{poll_option.POLL_OPTION_PERCENT}" /></td>
					<td><img src="templates/subSilver/images/vote_rcap.gif" width="4" alt="" height="12" /></td>
				  </tr>
				</table>
			  </td>
			  <td align="center"><b><span class="gen">&nbsp;{poll_option.POLL_OPTION_PERCENT}&nbsp;</span></b></td>
			  <td align="center"><span class="gen">[ {poll_option.POLL_OPTION_RESULT} ]</span></td>
			</tr>
			<!-- END poll_option -->
		  </table>
		</td>
	  </tr>
	  <tr> 
		<td colspan="4" class="row1" align="center"><span class="gen"><b>{L_TOTAL_VOTES} : {TOTAL_VOTES}</b></span></td>
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
