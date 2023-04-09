<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template poll_option -->

<tr>
	<td align="left" width="5%">
	   <input type="radio" name="vote" value="$insert[poll_option]" />		
	</td>
	<td align="left" width="35%">
      $insert[poll_optiontext]        	
	</td>
   <td align="right" width="40%">
      <img src="images/votebar.png" width="$insert[poll_votebar]" height="9">      	
   </td>
   <td align="left" width="20%">       
      $insert[poll_percent]% ($insert[poll_optionvotes] votes) 		
   </td>
</tr>

TEMPLATE;
?>