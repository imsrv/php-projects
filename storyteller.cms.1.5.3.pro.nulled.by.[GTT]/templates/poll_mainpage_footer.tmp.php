<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template poll_mainpage_footer -->

      </table>
      
		<br />

		<input type="hidden" name="poll" value="$insert[poll_id]">	
		<input type="submit" value="Vote" />
		<a href="poll.php?id=$insert[poll_id]">$insert[poll_comments] Comment(s)</a>

		</form>
		</font>
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<br />

TEMPLATE;
?>