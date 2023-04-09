{include file="header.tpl"}

Welcome to the Lore Installation Wizard. This program will perform a new installation
of Lore on your server.

<br /><br />

Before beginning installation, please verify that you have uploaded the entire 
software package, and followed the instructions in the included <b>INSTALL.txt</b>
file.

<br /><br />

<div class="buttons">
	<form method="post" action="{$php_self}">
		<input type="hidden" name="step" value="2" />
		<input type="submit" name="submit" value="Start Installation" />
	</form>
</div>

{include file="footer.tpl"}