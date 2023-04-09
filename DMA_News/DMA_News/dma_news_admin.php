<?php

// +------------------------------------+
// |  Config							|
// +------------------------------------+

$db_host = "";
$db_user = "";
$db_password = "";
$db_db_name = "";

// +------------------------------------+
// |  Do not edit anything below here	|
// +------------------------------------+

$link = mysql_connect ("$db_host", "$db_user", "$db_password");

mysql_select_db ("$db_db_name", $link);

if (!$link)
	{
		echo "<font color=\"000000\">DB Connect FAIL</font>";
		exit;
	}

if (!($admin_template = mysql_query ("SELECT admin_template FROM DMA_News_Config", $link)))
	{
		echo "<font color=\"FF0000\" face=\"verdana\" size=\"1\">Database connection failure:</font>";
		echo "<br><br>";
		echo "<font color=\"FF0000\" face=\"verdana\" size=\"1\">Attempting to run the install script, maybe this is the first run ...</font>";
		echo "<br><br><br>";
		$run_test = 1;
		require ("./dma_news_install.php");
		exit;
	}
$admin_template_display = mysql_fetch_row ($admin_template);
$admin_header = eregi_replace ("XXX_CONTENT_XXX(.*)", "", $admin_template_display[0]);
$admin_footer = eregi_replace ("^(.*)XXX_CONTENT_XXX", "", $admin_template_display[0]);

echo $admin_header;

if (!$action)
	{
		table_header ("Main Menu");
		?>
			<form method="POST" name="News Updater" action="./dma_news_admin.php" class="news_form">
				<table width="" cellpadding="5" border="0" cellspacing="0" bgcolor="#ffffff">
					<tr>
						<td class="standard_table_1" align="left">
							<input type="radio" name="action" value="news_add"> Add news
						</td>
					</tr>
					<tr>
						<td class="standard_table_1" align="left">
							<input type="radio" name="action" value="news_edit"> Edit news
						</td>
					</tr>
					<tr>
						<td class="standard_table_1" align="left">
							<input type="radio" name="action" value="configure_templates"> Configure templates
						</td>
					</tr>
					<tr>
						<td class="standard_table_1" align="left">
							<input type="radio" name="action" value="configure_colors"> Configure colors
						</td>
					</tr>
					<tr>
						<td class="standard_table_1" align="left">
							<input type="radio" name="action" value="configure_authors"> Configure authors
						</td>
					</tr>
				</table>
			<br>	
			<input type="submit" name="submit">
			</form>
		<?php
		table_footer ();
	}

if ($action == "news_add")
	{
		$author_db_result = mysql_query ("SELECT * FROM DMA_News_Authors", $link);
		table_header ("Add News Item");
		?>		
			<form method="POST" name="News Adder" action="./dma_news_admin.php">
			<input type="hidden" name="action" value="new_addition">
			<textarea name="new_news" cols="80" rows="20"></textarea>
			<br><br>
			Select author:
			<br><br>
			<select name="author">
				<?php
				while ($author_result = mysql_fetch_array ($author_db_result))
						{
							echo "<option>".$author_result[Author]."</option>";
						}
				?>
			</select>
			<br><br>
			<input type="submit" name="submit">
			</form>
		<?php
		table_footer ();
	}


if ($action == "news_edit")
	{
		if (!$sortorder)
			{
				$the_news = mysql_query ("SELECT * FROM DMA_News ORDER BY id desc", $link);
			}
		else
			{
				$the_news = mysql_query ("SELECT * FROM DMA_News ORDER BY $sortorder desc", $link);
			}
		
		?>
		<center>
		<a href="http://www.digitalmediaart.com"><img src="./dmanews.gif" alt="DMANews" width="220" height="66" border="0" align="middle"></a>
		<br><br>
		<table width="100%" cellpadding="5" border="0" cellspacing="1" bgcolor="#ffffff">
			<tr>
				<td colspan="5" align="center" class="maintitle">
					News Editing Facility
				</td>
			</tr>
			<tr>
				<td nowrap align="center" class="subtitle_table">
					<a href="<?=$PHP_SELF?>?action=news_edit&sortorder=id">News Item ID</a>:
				</td>
				<td nowrap align="center" class="subtitle_table">
					<a href="<?=$PHP_SELF?>?action=news_edit&sortorder=id">Date</a>:
				</td>
				<td nowrap align="center" class="subtitle_table">
					<a href="<?=$PHP_SELF?>?action=news_edit&sortorder=author">Author</a>:
				</td>
				<td nowrap align="center" class="subtitle_table">
					News:
				</td>
				<td nowrap align="center" class="subtitle_table">
					Action:
				</td>
			</tr>
		<?php
		$row_mod = 2;

		while ($result = mysql_fetch_array ($the_news))
			{
				if ($row_mod%2 == 0)
					{
						$alt_class = "standard_table_1";
						$row_mod = $row_mod + 1;
					}
				elseif ($row_mod%2 == 1)
					{
						$alt_class = "standard_table_2";
						$row_mod = $row_mod + 1;
					}
				?>
				<tr>
					<td align="center" class="<?=$alt_class?>">
						<?php
						echo $result['id'];
						?>
					</td>
					<td nowrap align="center" class="<?=$alt_class?>">
						<?php
						echo $result['time'];
						?>
					</td>
					<td nowrap align="center" class="<?=$alt_class?>">
						<?php
						echo $result['author'];
						?>
					</td>
					<td class="<?=$alt_class?>">
						<?php
						echo $result['news'];
						?>
					</td>
					<td align="center" class="<?=$alt_class?>">
							<?php
								echo "&nbsp;&nbsp;&nbsp;&nbsp;";
								echo "<a href=\"./dma_news_admin.php?action=news_fetch_for_edit&id=".$result['id']."\">Edit</a>";
								echo "&nbsp;&nbsp;&nbsp;&nbsp;";
								echo "<a href=\"./dma_news_admin.php?action=news_delete_item&id=".$result['id']."\">Delete</a>";
								echo "&nbsp;&nbsp;&nbsp;&nbsp;";
							?>
					</td>
				</tr>
			<?php
			}
			?>
		</table>
		</center>
	<?php
	}

if ($action == "new_addition")
	{
		$date = date ("dS F Y");
		
		if (mysql_query ("INSERT INTO DMA_News (news, time, author) values ('$new_news', '$date', '$author')", $link))
			{
				table_header ("News Added");
				?>	
					<a href="./dma_news_admin.php">Back</a>
				<?php
				table_footer ();
			}
		else
			{
				table_header ("News Added");
				?>	
					Unable to add news. <a href="./dma_news_admin.php">Back</a>
				<?php
				table_footer ();
			}
	}
	
if ($action == "news_delete_item")
	{
		table_header ("News Delete: Confirmation Required");
		?>
			<br>
			Really delete news item #<?=$id?> ?
			<br><br>
			<a href="./dma_news_admin.php?action=news_delete_item_confirmed&id=<?=$id?>">Yes</a> | <a href="./dma_news_admin.php?action=news_edit">No</a>
			<br><br>
		<?php
		table_footer ();
	}

if ($action == "news_delete_item_confirmed")
	{
		if (mysql_query ("DELETE FROM DMA_News WHERE id = '$id'", $link))
			{
				table_header ("News Delete:");
				?>
					<br>
					Item deleted.
					<br><br>
					<a href="./dma_news_admin.php">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
		else
			{
				table_header ("News Delete:");
				?>
					<br>
					Error: Unable to delete news item.
					<br><br>
					<a href="./dma_news_admin.php">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
	}

if ($action == "news_fetch_for_edit")
	{
		$fetched_result = mysql_query ("Select id, time, author, news FROM DMA_News WHERE id = '$id'", $link);
		$fetched_array = mysql_fetch_array ($fetched_result);
			table_header ("Edit news item:");
			?>
				<form method="POST" name="News Editor" action="./dma_news_admin.php">
				<input type="hidden" name="action" value="edited_news">
				<input type="hidden" name="id" value="<?= $id ?>">
				<textarea name="new_news" cols="80" rows="20"><?php echo $fetched_array['news']; ?></textarea>
				<br><br>
				<input type="submit" name="submit">
				</form>
			<?php
			table_footer ();
	}

if ($action == "edited_news")
	{
		if (mysql_query ("UPDATE DMA_News SET news = '$new_news' WHERE id = '$id'", $link))
			{
				table_header ("Edit news item:");
				?>
					<br>Item updated.
					<br><br>
					<a href="./dma_news_admin.php">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
		else
			{
				table_header ("Edit news item:");
				?>
					<br>Unable to update news item.
					<br><br>
					<a href="./dma_news_admin.php">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
	}

if ($action == "configure_templates")
	{
		$fetched_result = mysql_query ("Select * FROM DMA_News_Config", $link);
		$fetched_array = mysql_fetch_array ($fetched_result);
		$articles_temp = $fetched_array['news_article_template'];
		$admin_temp = $fetched_array['admin_template'];
		$header_temp = $fetched_array['news_article_header'];
		$footer_temp = $fetched_array['news_article_footer'];
			table_header ("Configure Templates:");
			?>
				<form method="POST" name="new_template_config" action="./dma_news_admin.php">
					<input type="hidden" name="action" value="new_template_config">
					<br>
					News Article Header:
					<br><br>
					<textarea name="new_news_article_header" cols="80" rows="20"><?=$header_temp?></textarea>
					<br><br>
					<br>
					News Article Template:
					<br><br>
					<textarea name="new_news_article_template" cols="80" rows="20"><?=$articles_temp?></textarea>
					<br><br>
					<br>
					News Article Footer:
					<br><br>
					<textarea name="new_news_article_footer" cols="80" rows="20"><?=$footer_temp?></textarea>
					<br><br>
					<br>
					Admin Template:
					<br><br>
					<textarea name="new_admin_template" cols="80" rows="20"><?=$admin_temp?></textarea>
					<br><br>
					<input type="submit" name="submit">
				</form>	
			<?php
			table_footer ();
	}

if ($action == "configure_colors")
	{
		$fetched_result = mysql_query ("Select * FROM DMA_News_Config", $link);
		$fetched_array = mysql_fetch_array ($fetched_result);
		$alt_color_1 = $fetched_array['alt_color_1'];
		$alt_color_2 = $fetched_array['alt_color_2'];
			table_header ("Configure colors:");
			?>
				<form method="POST" name="new_color_config" action="./dma_news_admin.php">
					<input type="hidden" name="action" value="new_color_config">
						<table width="" cellpadding="7" border="0" cellspacing="7">
							<tr>
								<td class="standard_table_1" align="left">
									Alternating color 1 
								</td>
								<td bgcolor="<?=$alt_color_1?>">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td class="standard_table_1">
									New color: <input name="new_alt_color_1" type="text" size="12" value="<?=$alt_color_1?>">
								</td>
							</tr>
							<tr>
								<td class="standard_table_1" align="left">
									Alternating color 2 
								</td>
								<td bgcolor="<?=$alt_color_2?>">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td class="standard_table_1">
									New color: <input name="new_alt_color_2" type="text" size="12" value="<?=$alt_color_2?>">
								</td>
							</tr>
						</table>
					<br>	
					<input type="submit" name="submit">
				</form>
			<?php
			table_footer ();
	}

if ($action == "new_template_config")
	{
		if (mysql_query ("UPDATE DMA_News_Config SET news_article_header = '$new_news_article_header', 
		news_article_template = '$new_news_article_template', 
		news_article_footer = '$new_news_article_footer', 
		admin_template = '$new_admin_template' WHERE id = 'config1'", $link))
			{
				table_header ("Config Change:");
				?>
					<br>Templates updated.
					<br><br>
					<a href="./dma_news_admin.php">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
		else
			{
				table_header ("Config Change:");
				?>
					<br>Unable to update templates.
					<br><br>
					<a href="./dma_news_admin.php">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
	}

if ($action == "new_color_config")
	{
		if (mysql_query ("UPDATE DMA_News_Config SET alt_color_1 = '$new_alt_color_1', alt_color_2 = '$new_alt_color_2' WHERE id = 'config1'", $link))
			{
				table_header ("Config Change:");
				?>
					<br>Colors updated.
					<br><br>
					<a href="./dma_news_admin.php">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
		else
			{
				table_header ("Config Change:");
				?>
					<br>Unable to update colors.
					<br><br>
					<a href="./dma_news_admin.php">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
	}

if ($action == "configure_authors")
	{	
		$author_db_result = mysql_query ("SELECT * FROM DMA_News_Authors", $link);
			table_header ("Configure Authors:");
			?>
				<form method="POST" name="Authors" action="./dma_news_admin.php" class="news_form">
					<table width="" cellpadding="10" border="0" cellspacing="0" bgcolor="#ffffff">
						<tr>
							<td class="standard_table_1" align="left">
								<b>ID</b>
							</td>
							<td class="standard_table_1" align="left">
								<b>Author Name</b>
							</td>
							<td class="standard_table_1" align="center" colspan="2">
								<b>Options</b>
							</td>
						</tr>
						<?php
						while ($author_result = mysql_fetch_array ($author_db_result))
							{
								$current_author_id = $author_result[id];
								$current_author_name = $author_result[Author];
								$url_encoded_author_name = urlencode ($current_author_name);
								?>
								<tr>
									<td class="standard_table_1" align="left">
										<?=$current_author_id?>
									</td>
									<td class="standard_table_1" align="left">
										<?=$current_author_name?>
									</td>
									<td class="standard_table_1" align="left">
										<a href="./dma_news_admin.php?action=edit_author&id=<?=$current_author_id?>">Edit</a>
									</td>
									<td class="standard_table_1" align="left">
										<a href="./dma_news_admin.php?action=delete_author&id=<?=$current_author_id?>&name=<?=$url_encoded_author_name?>">Delete</a>
									</td>
								</tr>
							<?php
							}
							?>
					</table>
				</form>
				<form method="POST" name="Authors" action="./dma_news_admin.php" class="news_form">
				<input type="hidden" name="action" value="add_author">
					<table width="" cellpadding="10" border="0" cellspacing="0" bgcolor="#ffffff">
						<tr>
							<td class="standard_table_1" align="center">
								<b>Add Author</b>
							</td>
						</tr>
						<tr>
							<td class="standard_table_1" align="center">
								<input name="new_author_name" type="text" size="20" value="">
							</td>
						</tr>
						<tr>
							<td class="standard_table_1" align="center">
								<input name="submit" type="submit" value="submit">
							</td>
						</tr>
					</table>
				</form>
			<?php
			table_footer ();
	}

if ($action == "edit_author")
	{	
		$author_db_result = mysql_query ("SELECT * FROM DMA_News_Authors where id = '$id'", $link);
			table_header ("Edit Author:");
			?>
				<form method="POST" name="News Updater" action="./dma_news_admin.php" class="news_form">
					<input type="hidden" name="action" value="edited_author">
					<input type="hidden" name="id" value="<?=$id?>">
					<table width="" cellpadding="5" border="0" cellspacing="0" bgcolor="#ffffff">
						<?php
						$author_result = mysql_fetch_row ($author_db_result);
						$current_author_id = $author_result[0];
						$current_author_name = $author_result[1];
						?>
						<tr>
							<td class="standard_table_1" align="left">
								<b>ID</b>
							</td>
							<td class="standard_table_1" align="left">
								<b>Author Name</b>
							</td>
						</tr>
						<tr>
							<td class="standard_table_1" align="left">
								<?=$current_author_id?>
							</td>
							<td class="standard_table_1" align="left">
								<input name="new_author_name" type="text" size="20" value="<?=$current_author_name?>">
							</td>
						</tr>
					</table>
				<br>	
				<input type="submit" name="submit">
				</form>
			<?php
			table_footer ();
	}

if ($action == "edited_author")
	{
		if (mysql_query ("UPDATE DMA_News_Authors SET Author = '$new_author_name' WHERE id = '$id'", $link))
			{
				table_header ("Edit Author:");
				?>
					<br>Author updated.
					<br><br>
					<a href="./dma_news_admin.php?action=configure_authors">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
		else
			{
				table_header ("Edit Author:");
				?>
					<br>Unable to update author.
					<br><br>
					<a href="./dma_news_admin.php?action=configure_authors">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
	}

if ($action == "delete_author")
	{
		table_header ("Delete Author:");
		$author_name = urldecode ($name);
		?>
			<br>Really delete author <?=$author_name?>?
			<br><br>
			<a href="./dma_news_admin.php?action=delete_author_confirmed&id=<?=$id?>">Yes</a> | <a href="./dma_news_admin.php?action=configure_authors">No</a>
			<br><br>
		<?php
		table_footer ();
	}

if ($action == "delete_author_confirmed")
	{
		if (mysql_query ("DELETE from DMA_News_Authors WHERE id = '$id'", $link))
			{
				table_header ("Delete Author:");
				?>
					<br>Author deleted.
					<br><br>
					<a href="./dma_news_admin.php?action=configure_authors">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
		else
			{
				table_header ("Delete Author:");
				?>
					<br>Unable to delete author.
					<br><br>
					<a href="./dma_news_admin.php?action=configure_authors">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
	}

if ($action == "add_author")
	{
		if (mysql_query ("INSERT into DMA_News_Authors (Author) values ('$new_author_name')", $link))
			{
				table_header ("Add Author:");
				?>
					<br>Author added.
					<br><br>
					<a href="./dma_news_admin.php?action=configure_authors">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
		else
			{
				table_header ("Add Author:");
				?>
					<br>Unable to add author.
					<br><br>
					<a href="./dma_news_admin.php?action=configure_authors">Back</a>
					<br><br>
				<?php
				table_footer ();
			}
	}


if ($action)
	{
		return_to_menu ();
	}

echo "<br>";
echo "<center>";
echo "<span class=\"dma_credits\">";
echo "<b>Dma News v0.501</b>";
echo "</span>";
echo "</center>";

echo $admin_footer;

function return_to_menu ()
	{
		?>
		<br>
		<center>| <a href="./dma_news_admin.php">Return to main menu</a> |</center>
		<br>
		<?php	
	}

function table_header ($main_title)
	{
		?>
		<center>
		<a href="http://www.digitalmediaart.com"><img src="./dmanews.gif" alt="DMANews" width="220" height="66" border="0" align="middle"></a>
		<br><br>
		<table width="100%" cellpadding="10" border="0" cellspacing="1" bgcolor="#ffffff">
					<tr>
						<td align="center" class="maintitle">
							<?=$main_title?>
						</td>
					</tr>
					<tr>
						<td align="center" class="standard_table_1">
		<?php
	}

function table_footer ()
	{
		?>
				</td>
			</tr>
		</table>
		</center>
		<?php
	}
?>