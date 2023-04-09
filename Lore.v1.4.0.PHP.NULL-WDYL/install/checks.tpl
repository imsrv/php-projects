<center>
<table width="75%">
{foreach item=check from=$checks}
	<tr>
	<td class="check_comment" width="100%">
		<strong>{$check.comment}</strong>
	</td>
	<td class="check_result">
		{if $check.result}
			<span class="ok_text">OK</span>
		{else}
			<span class="failed_text">FAILED</span>
		{/if}
	</td>
	</tr>
	{if !$check.result}
		<tr>
		<td class="check_error" colspan="2">
			{$check.error}
		</td>
		</tr>
	{/if}
{/foreach}
</table>
</center>
