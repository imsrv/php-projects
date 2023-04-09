<?php
echo "		<form action=\"comments.php\" method=\"post\">
			<p><label for=\"comments\">Enter you comments below and click submit:</label><br /><textarea name=\"comments\" rows=\"6\" cols=\"82\"></textarea>
			<p><input type=\"hidden\" name=\"id\" value=\"$_GET[id]\" /><input type=\"submit\" name=submit\" value=\"Submit\" class=\"no\" /></p>
		</form>\n";
?>