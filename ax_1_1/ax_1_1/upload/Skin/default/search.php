<?

// AnnouncementX 
// Version: 1.1
// Author: Cat (Ivan Cat)
// Created: 10/10/2005
// Updated: 10/12/2005
// Description: handles the
// search system of AX

if (!isset($index)) {

	echo "Hacking attempt!";
	exit;

}


class Search {

	function go_switch($step) {
	
		global $functions, $errors, $title, $username, $password;
		
		switch ($step) {
		
			case "1":
			
				$this->view_search();
				
			break;
			
			case "2":
			
				$this->perform_search();
			
			break;
		
		}
	
	}
	
	function view_search() {
	
		global $functions, $errors, $username, $password, $title;
		
		$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
		mysql_select_db(DATA,$link);
		
		$sql=mysql_query("SELECT `id`,`Name` FROM `categories`") or die ("AnnouncementX Error: " . mysql_error());
		
		mysql_close($link);
		
echo <<<END

			<table align=center class=maintable cellpadding=3>
				<tr>
					<td align=center class=HEADER colspan=2>
					$title - Search
					</td>
				</tr>
				<tr>

END;

				$functions->do_menu($username,$password);
				
echo <<<END

					<td class=MAIN align=left>
						<div id='navstrip'><a href='./index.php?do=&;' title='Home'>$title</a> > <a href='./index.php?do=search&step=1' title='Search'>Search window</a></div>
						<br />
						<form name='usersearch' action='./index.php?do=search&step=2&' method='post'>
						<input type=hidden name=security value=1>
						<input type=hidden name='identifier' value='user'>
						 <fieldset style="padding: 2">
						 	<legend>Username Search:</legend>
							<center><b>With the help of this window you can easily find username you need!</b></center><br /><br />
							A part of a username: <input type=text name='user' value='Enter username here' class=submit onFocus="this.value=''"><br />
							<br />Username: 
							<select name='option' size=1 class=submit>
								<option value="starts">Starts with the enetered phrase</option>
								<option value="ends">Ends with the entered phrase</option>
								<option value="contains">Contains the entered phrase</option>
							</select><br /><br />
						 </fieldset>
						 <div align=right><input type=submit name=submit value='Start search' class=submit> <input type=reset name=reset class=submit></div>
						</form><br /><br />
						<form name='postsearch' action='./index.php?do=search&step=2&' method='post'>
						<input type=hidden name=security value=1>
						<input type=hidden name=identifier value='post'>
						 <fieldset style="padding: 2">
						 	<legend>Post Search:</legend>
							<center><b>With the help of this windown you can easily find post you need!</b></center><br /><br />
							Topic title: <input type=text name='title' value='Enter topic title' class=submit onFocus="this.value=''"><br />
							<br />
						 	Title: 
							<select name='option' size=1 class=submit>
								<option value="starts">Starts with the enetered phrase</option>
								<option value="ends">Ends with the entered phrase</option>
								<option value="contains">Contains the entered phrase</option>
							</select>
							<br /><br />
							Search in category: 
							<select name='cats' size=1 class=submit>
END;
							
							while ($row=mysql_fetch_row($sql)) {
								
								$id=$row[0];
								$name=$row[1];
								
								echo "<option value='$id'>$name</option>";
							
							}
							
echo "							
							</select>
							<br /><br />
							<input type=checkbox name='allcats' value=1 checked> Search in all categories
						 </fieldset>
						 <div align=right><input type=submit name=submit value=\"Start search\" class=submit> <input type=reset name=reset class=submit></div>
						</form><br /><br />
					</td>
				</tr>
			</table>

";
	
	}
	
	function perform_search() {
	
		global $functions, $errors, $username, $password, $title;
		
		$security=$_POST['security'];
		
		if (isset($security)) {
		
			$ident=$_POST['identifier'];
			
			switch ($ident) {
			
				case "user":
				
					$user=$_POST['user'];
					$opt=$_POST['option'];
					
					if ($user == '' || $opt == '') {
					
						$errors->error_fill_in_all_fields();
					
					} else {
					
						switch ($opt) {
						
							case "starts":
							
								$query="SELECT * FROM `members` WHERE `Name` LIKE '%$user'";	
							
							break;
							
							case "ends":
							
								$query="SELECT * FROM `members` WHERE `Name` LIKE '$user%'";
							
							break;
							
							case "contains":
							
								$query="SELECT * FROM `members` WHERE `Name` LIKE '%$user%'";
							
							break;
						
						}
						
						$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
						mysql_select_db(DATA,$link);
						
						$sql=mysql_query($query) or die ("AnnouncementX Error: " . mysql_error());
						
						mysql_close($link);
						
echo <<<END

						<table align=center class=maintable cellpadding=3>
							<tr>
								<td align=center class=HEADER colspan=2>
									$title - Search Results
								</td>
							</tr>
							<tr>
			
END;

								$functions->do_menu($username,$password);

echo <<<END
	
								<td align=left class=MAIN>
									<div id='navstrip'><a href='./index.php?do=&' title='Home'>$title</a> > <a href='./index.php?do=search&step=1' title='Back to the search window'>Search Results</a></div><br /><br />
									<strong>Here are the results perfermed by your request (usernames):</strong><br /><br />
									<center>
END;

									while ($row=mysql_fetch_row($sql)) {
									
										echo "<a href='./index.php?do=profile&step=view&who=".$row[1]."&' title='View profile'>".$row[1]."</a>\n";
									
									}

echo <<<END
									<br /><br />
									<input type=button name=back value='< Back' onClick="javascript:history.go(-1)" class=submit>
									</center>
								</td>
							</tr>
						</table>
					
END;
					
					}
				
				break;
				
				case "post":
				
					$topic=$_POST['title'];
					$opt=$_POST['option'];
					
					$allcats=$_POST['allcats'];
					$cat=$_POST['cats'];
					
					switch ($opt) {
					
						case "starts":
						
							$query="SELECT * FROM `posts` WHERE `Title` LIKE '$topic%'";
						
						break;
						
						case "ends":
						
							$query="SELECT * FROM `posts` WHERE `Title` LIKE '%$topic'";
						
						break;
						
						case "contains":
						
							$query="SELECT * FROM `posts` WHERE `Title` LIKE '%$topic%'";
						
						break;
					
					}
					
					if (!isset($allcats)) {
					
						switch ($opt) {
						
							case "starts":
							
								$query="SELECT * FROM `posts` WHERE `Category`='$cat' AND `Title` LIKE '$topic%'";
							
							break;
							
							case "ends":
							
								$query="SELECT * FROM `posts` WHERE `Category`='$cat' AND `Title` LIKE '%$topic'";
							
							break;
							
							case "contains":
							
								$query="SELECT * FROM `posts` WHERE `Category`='$cat' AND `Title` LIKE '%$topic%'";
							
							break;
						
						}
					
					}
					
					$link=mysql_connect(HOST,USER,PASS) or die ("AnnouncementX Error: " . mysql_error());
					mysql_select_db(DATA,$link);

					$sql=mysql_query($query) or die ("AnnouncementX Error: " . mysql_error());
					
					$rows=mysql_num_rows($sql);
					
echo <<<END

					<table align=center class=maintable cellpadding=3>
						<tr>
							<td align=center class=HEADER colspan=2>
							$title - Search Results
							</td>
						</tr>
						<tr>
						
END;

						$functions->do_menu($username,$password);

echo <<<END
							
							<td align=left class=MAIN>
								<div id='navstrip'><a href='./index.php?do=&' title='Home'>$title</a> > <a href='./index.php?do=search&step=1&' title='Back to the search window'>Search results</a></div>
								<br /><br />
								<center><b>Search results:</b></center><br /><br />
									<table align=center cellpadding=3 width=80%>
										<tr>
											<td align=center class=MAIN>
											<b>Title:</b>
											</td>
											<td align=center class=MAIN>
											<b>Poster:</b>
											</td>
											<td align=center class=MAIN>
											<b>Category:</b>
											</td>
											<td align=center class=MAIN>
											<b>Replies:</b>
											</td>
										</tr>
END;
										
										for ($i=0;$i<$rows;$i++) {
										
											$id=mysql_result($sql,$i,'id');
											$category=mysql_result($sql,$i,'Category');
											$poster=mysql_result($sql,$i,'Poster');
											$name=mysql_result($sql,$i,'Title');
											
											$catnm_qr=mysql_query("SELECT * FROM `categories` WHERE `id`='$category'") or die ("AnnouncementX Error: " . mysql_error());
											$replies_qr=mysql_query("SELECT * FROM `replies` WHERE `Post_title`='$id'") or die ("AnnouncementX Error: " . mysql_error());
											
											$catnm=mysql_fetch_row($catnm_qr);
											$replies=mysql_num_rows($replies_qr);
											
											echo "<tr>
												<td align=center class=MAIN>
													<a href='./index.php?do=replies&step=view&category=$category&post=$id&' title='View $name'>$name</a>
												</td>
												<td align=center class=MAIN>
													$poster
												</td>
												<td align=center class=MAIN>
													$catnm[1]
												</td>
												<td align=center class=MAIN>
													$replies
												</td>
											</tr>
											";
										
										}
										
echo <<<END
										<tr>
											<td colspan=4 align=center class=MAIN>
											<b>Total found:</b> $rows
											</td>
										</tr>
									</table>
								<br /><br />
								<center><a href='javascript:history.go(-1)' title='Back'>&lt; Back</a><br /></center>
							</td>
						</tr>
					</table>

END;

					mysql_close($link);	
				
				break;
				
				default:
				
					echo "Unknow indentifier!";
					exit;
				
				break;
			
			}
		
		} else {
		
			echo "Hacking attempt!";
			exit;
		
		}
	
	}

}

?>