</table>

{if !$form.readonly}
	<div class="form_buttons">
		{foreach name=button_loop item=button from=$buttons}
			{$button.html} &nbsp;
		{/foreach}
	
		<input class="button" type="reset" value="Reset" />
	</div>
	{/if}

{if !$form.readonly}
	</form>
{/if}