<? if (eregi("add_banner.php",basename($REQUEST_URI))) {
?>
	<table><tr><td><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="300"></td></tr></table>
    <table valign="bottom" id="bottomtbl" border="0" cellpadding="0" cellspacing="0" width="100%" height="100" bgcolor="#FFFFFF" align="center" style="position:relative; border: 1px solid #000000">
		<tr>
			<td align="center"><div id="bottombanner">Bottom Banner</div></td>
		</tr>
    </table>
	</td>
	<td width="150" valign="top" align="right" height="25%">
	   <table border="0" id="righttbl" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" height="100%" width="100%" style="border: 1px solid #000000">
    	<tr>
    		<td><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" width="1" height="405"></td><td align="center"><div id="rightbanner">Right Banner</div></td>
    	</tr>
       </table>
	</td>
<?}
else {
    echo "</td>";
}?>

						
					</td>
					<td width="5">
						&nbsp;
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

	</td>
</tr>
</table>

</body>

</html>