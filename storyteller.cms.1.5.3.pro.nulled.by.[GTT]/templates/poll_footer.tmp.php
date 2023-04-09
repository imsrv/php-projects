<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template poll_footer -->

      </table>

		<br />

		<input type="hidden" name="poll" value="$insert[poll_id]">	
		<input type="submit" value="Vote" />

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