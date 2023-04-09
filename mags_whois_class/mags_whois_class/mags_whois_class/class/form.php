<?php
class Build Extends Whois
{
	function Build()
	{
		$this->MakeForm();	
	}
		
	function MakeForm()
	{
		$menu = $this->BuildMenu();
		echo <<<END
	
	<!-- start editing here -->	
	
	<form name="form1" action="{$_SERVER["PHP_SELF"]}" method="post">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td valign="bottom" align="center">
					<b>www.</b>
				</td>
				
				<td valign="top" align="right">
					<input type="text" name="domain">
				</td>
				
				<td valign="bottom" align="center">
					<b>.</b>
				</td>
				
				<td valign="top" align="left">
					<select name="extensions">
						$menu
					</select>
				</td>
				
				<td valign="bottom" align="center" width="10">
					&nbsp;
				</td>
				
				<td valign="top" align="right">
					<input type="submit" value="Submit">
				</td>
				
			</tr>
		</table>
	</form>
	
	<!-- end edit here -->
END;
	}	
}
?>