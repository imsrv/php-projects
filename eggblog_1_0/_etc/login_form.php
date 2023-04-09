		<form action="../home/login.php" method="post">
			<p><label for="username">Username</label><br /><input id="username" style="width:124px;" type="text" name="username" onfocus="if(this.value=='Enter a username') { this.value=''; } " onblur="if(this.value=='') { this.value='Enter a username'; } " value="Enter a username" /></p>
			<p><label for="password">Password</label><br /><input name="dummypassword" id="dummypassword" style="width: 124px;" value="Enter a password" onfocus="this.style.display='none'; document.getElementById('password').style.display='inline'; document.getElementById('password').focus();" type="text" /><input name="password" id="password" style="width: 124px; display: none;" onblur="if(this.value==''){ this.style.display='none'; document.getElementById('dummypassword').style.display='inline'; }" type="password" value="" class="input_normal" /></p>
			<p><input type="checkbox" name="cookie" value="1" id="cookie" /><label for="cookie"> tick this box to remain logged in. If you do not tick this box, you will automatically be logged out when you leave the website.</label></p>
			<p><input type="submit" name=submit" value="Log In" class="no" /></p>
			<p><a href="../home/register.php">register</a> | <a href="../home/forgot.php">forgotten your log in details?</a></p>
		</form>
