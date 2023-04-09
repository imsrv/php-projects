<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

define('INCLUDE_PATH', 'include/');
include INCLUDE_PATH . 'common.inc.php';

$forums = new forums;

echo $display->header();

$op = (!empty($_GET['op']) ? $_GET['op'] : '');
$sub = (!empty($_GET['sub']) ? $_GET['sub'] : '');

switch ($op)
{
	case 'post':
	case 'edit':

		$location = array(
			'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
			'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
		);

		$forums->forum_location($location);

		$location[] = '<a href="' . $config['install_path'] . $forums->furl('viewforum', $forums->f_id) . '">' . $forums->f_data['title'] . '</a>';

		if (!$session->logged_in)
		{
			$title = 'Sign In';

			echo '<p>You must be signed in to post. You can use the form in the top right to sign in, or
				register if you do not have an account.</p>';

			break;
		}

		/* permission check */

		$access = true;

		$flags = permission::get_flags('forums', $forums->f_id);

		if ($op == 'edit')
		{
			$action = 'edit';

			if (!($flags & F_POST_EDIT))
			{
				$msg = 'You may not edit posts in this forum.';
				$access = false;
			}

			if ($forums->p_data['u_id'] != $session->user_id)
			{
				$msg = 'You may only edit your own posts.';
				$access = false;
			}

			if ($forums->count_replies($forums->p_id))
			{
				$msg = 'You may not edit a post which has been replied to.';
				$access = false;
			}

			if ($flags & F_POST_EDITALL)
			{
				$access = true;
			}
		}
		else
		{
			if ($forums->p_id)
			{
				$action = 'reply';
				$flag = F_POST_REPLY;
			}
			else
			{
				$action = 'new';
				$flag = F_POST_NEW;
			}

			if (!($flags & $flag))
			{
				$msg = 'You may not make posts in this forum.';
				$access = false;
			}

			if ($action == 'reply' && $forums->p_data['is_unapproved'])
			{
				$access = false;
				$msg = 'You may not reply to unapproved posts.';
			}

			if ($action != 'new')
			{
				$fp_data = $forums->post_get_data($forums->first_post($forums->p_id));

				if ($fp_data['is_locked'])
				{
					$access = false;
					$msg = 'This thread is locked.';
				}
			}
		}

		if (!$access)
		{
			$title = 'Access Denied';

			echo '<p>' . $msg . '</p>';

			break;
		}

		$is_unapproved = false;

		if ($flags & F_FORUM_APPROVAL && !($flags & F_POST_APPROVE))
		{
			$is_unapproved = true;

			$prev_approved = ($action == 'edit' && $forums->p_data['is_unapproved'] ? false : true);
		}

		if ($action == 'reply')
		{
			/* replying to a post */
			$title = 'Post Reply';
			$parent = $forums->p_id;
			$default_msg = '';

			$button_submit = 'Post';

			$default_title = $forums->p_data['title'];

			if (substr($default_title, 0, 4) != 'Re: ')
			{
				$default_title = 'Re: ' . $default_title;
			}

			$form_submit_url = $config['install_path'] . $forums->furl('post', 'p', $forums->p_id);

			$location[] = '<a href="' . $config['install_path'] . $forums->furl('view', $forums->first_post($forums->p_id)) . '#post' . $forums->p_id . '">' . $forums->p_data['title'] . '</a>';

			echo '<p style="font-size: 1.1em; margin: 0; padding: 0"><i>Replying To:</i></p>';

			echo $forums->display_single_post(array(
			    'date' => $forums->p_data['date'],
			    'format_type' => $forums->p_data['format_type'],
			    'fromleft' => 0,
			    'id' => $forums->p_id,
			    'first_post' => $forums->first_post($forums->p_id),
			    'no_footer' => true,
			    'parent' => $forums->p_data['parent_id'],
			    'signature' => $forums->get_sig($forums->p_data['u_id']),
			    'text' => $forums->p_data['text'],
			    'title' => $forums->p_data['title'],
			    'u_id' => $forums->p_data['u_id'],
			    'username' => $forums->p_data['username']
			));
		}
		else if ($action == 'new')
		{
			$title = 'Post Message';
			$parent = 0;
			$default_title = $default_msg = '';

			$button_submit = 'Post';

			$form_submit_url = $config['install_path'] . $forums->furl('post', 'f', $forums->f_id);
		}
		else /* $action == 'edit' */
		{
			$title = 'Edit Message';
			$parent = $forums->post_get_parent($forums->p_id);

			$button_submit = 'Edit';

			$location[] = '<a href="' . $config['install_path'] . $forums->furl('view', $forums->first_post($forums->p_id)) . '#post' . $forums->p_id . '">' . $forums->p_data['title'] . '</a>';

			$default_title = $forums->p_data['title'];
			$default_msg = $forums->p_data['text'];

			$form_submit_url = $config['install_path'] . $forums->furl('edit', $forums->p_id);

			echo '<p style="font-size: 1.1em; margin: 0; padding: 0"><i>Editing (Original Version):</i></p>';

			echo $forums->display_single_post(array(
				'date' => $forums->p_data['date'],
				'format_type' => $forums->p_data['format_type'],
				'fromleft' => 0,
				'id' => $forums->p_id,
				'first_post' => $forums->first_post($forums->p_id),
				'no_footer' => true,
				'parent' => $forums->p_data['parent_id'],
				'signature' => $forums->get_sig($forums->p_data['u_id']),
				'text' => $forums->p_data['text'],
				'title' => $forums->p_data['title'],
				'u_id' => $forums->p_data['u_id'],
				'username' => $forums->p_data['username']
			));

			if ($is_unapproved)
			{
				echo '<p>Editing your post will require the post to be approved again by a moderator (it will disappear from the thread).</p>';
			}
		}

		$valid = false;

		$message_title = (!empty($_POST['message_title']) ? $_POST['message_title'] : $default_title);
		$message_body = (!empty($_POST['message_body']) ? $_POST['message_body'] : $default_msg);

		$add_bookmarks = (!empty($_POST['bookmark']) ? true : false);

		$buttons = '';

		if ($action == 'edit' && ($flags & F_POST_EDITALL))
		{
			$buttons .= '<input type="checkbox" name="hideedit" id="hideedit" /><label for="hideedit">Hide Edit</label><br />';
		}

		$buttons .= '<input type="submit" name="preview" value="Preview" />';

		if (isset($_POST['preview']) || isset($_POST['post']))
		{
			if (!$message_title)
			{
				$errors[] = 'No message title entered.';
			}

			if (!$message_body)
			{
				$errors[] = 'No message body entered.';
			}
			else if (count(explode(' ', $message_body)) < 4)
			{
				$errors[] = 'Message is not long enough.';
			}

			if (!empty($errors))
			{
				echo '<ul>';

				foreach($errors as $error)
				{
					echo "<li>$error</li>";
				}

				echo '</ul>';
			}
			else
			{
				$valid = true;
			}
		}

		if ($valid || !$config['force_preview'])
		{
			$buttons .= ' <input type="submit" name="post" value="' . $button_submit . '" />';
		}

		if (isset($_POST['preview']))
		{
			echo '<p style="font-size: 1.1em; margin: 0; padding: 0;"><i>Preview:</i></p>';
			echo $forums->display_single_post(array(
				'title' => stripslashes($message_title),
				'date' => time(),
				'u_id' => $session->user_id,
				'username' => $session->userdata['username'],
				'text' => stripslashes($message_body),
				'format_type' => 'text',
				'signature' => $forums->get_sig($session->user_id)
			));
		}

		if (isset($_POST['post']))
		{
			if ($valid)
			{
				if ($action == 'reply' || $action == 'new')
				{
					$id = $forums->add_data($message_title, $message_body, $session->user_id);

					if ($action == 'new')
					{
						$fp_id = $id;
					}
					else
					{
						$parent_data = $forums->post_get_data($parent);

						$fp_id = $parent_data['fp_id'];
					}

					$sql = 'INSERT INTO posts (
						d_id, forum, parent_id, is_post, fp_id, last_reply, is_unapproved
						) VALUES (
						%d, %d, %d, 1, %d, %d, %d
						)';

					$sql = sprintf($sql, $id, $forums->f_id, $parent, $fp_id, time(), $is_unapproved);

					$db->sql_query($sql);

					if (!$is_unapproved && $action == 'reply')
					{
						$sql = 'SELECT d.title
							FROM data d
							WHERE d.id = %d';

						$sql = sprintf($sql, $fp_id);

						$db->sql_query($sql);
						$db->sql_data($title, true);

						$sql = 'SELECT u.*
							FROM bookmarks b, users u
							WHERE b.email = 1
							AND b.post_id = %d
							AND b.email_sent = 0
							AND b.user_id <> %d
							AND b.user_id = u.user_id';

						$sql = sprintf($sql, $fp_id, $session->user_id);

						$db->sql_query($sql);
						$db->sql_data($data);

						if (!empty($data))
						{
							$message = <<<MESSAGE
Hi %s,

A new reply has been posted to a thread you have bookmarked, titled "%s".

The new post is at:
 --> %s

You will not receive further notification of any new replies to this thread
until you visit the thread. All replies to the thread which you have not
yet read will appear in a different manner to normal posts, for your
convenience.

If you do not wish to be notified by email of any further replies to this
thread, please visit your bookmarks and turn off email notification:
 --> %s

--
%s
MESSAGE;
							foreach ($data as $user)
							{
								$headers = sprintf("From: %s <%s>\r\nContent-type: text/plain; charset=\"iso-8859-1\"\r\n", $config['contact_name'], $config['contact_email']);

								$msg = sprintf($message,
									$user['username'],
									$title['title'],
									'http://' . $config['domain_name'] . $config['install_path'] . forums::furl('view', $fp_id) . '#post' . $id,
									'http://' . $config['domain_name'] . $config['install_path'] . forums::furl('bookmarks'),
									$config['email_signature']
								);

								$msg = str_replace('&amp;', '&', $msg);

								@mail($user['user_email'], '[' . $config['site_name'] . '] Bookmarked thread reply: ' . $title['title'], $msg, $headers);

								$sql = 'UPDATE bookmarks
									SET email_sent = 1
									WHERE post_id = %d
									AND user_id = %d';

								$sql = sprintf($sql, $fp_id, $user['user_id']);

								$db->sql_query($sql);
							}
						}
					}
				}
				else
				{
					$id = $forums->p_id;

					$forums->edit_data($forums->p_id,
						$message_title,
						unixify($message_title),
						$message_body,
						$forums->p_data['u_id'],
						$forums->p_data['date'],
						$forums->p_data['format_type']);

					if (!empty($_POST['hideedit']) && ($flags & F_POST_EDITALL))
					{
						/* do not update the last edited column */

						$forums->change('is_unapproved', $is_unapproved, $forums->p_id);
					}
					else
					{
						$sql = 'UPDATE posts SET
							edited_by = %d,
							edited_time = %d,
							is_unapproved = %d
							WHERE d_id = %d';

						$sql = sprintf($sql, $session->user_id, time(), $is_unapproved, $forums->p_id);

						$db->sql_query($sql);
					}

					$parent = $forums->p_id;
				}

				if (!empty($_POST['reports']) && $forums->p_data['is_reported'] && ($flags & F_POST_EDITALL))
				{
					/* the person has "handled" the report */

					$forums->change('is_reported', 0, $forums->p_id);

					$sql = 'DELETE FROM reports
						WHERE p_id = %d';

					$sql = sprintf($sql, $forums->p_id);

					$db->sql_query($sql);
				}

				if ($action == 'edit' && $is_unapproved && $prev_approved)
				{
					$forums->update_forum_replies($forums->f_id, true);
					$forums->update_post_replies($id, time(), true);
				}
				else if ($action != 'edit' && !$is_unapproved)
				{
					$forums->update_forum_replies($forums->f_id);
					$forums->update_post_replies($id, time());
				}

				$p_id = ($parent ? $parent : $id);

				if ($add_bookmarks)
				{
					$forums->bookmark($forums->first_post($p_id));
				}

				redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('view', forums::first_post($p_id)) . '#post' . $p_id);
			}
		}

		echo '<div class="data">';

		echo '<form action="' . $form_submit_url . '" method="post">';

		echo '<table class="forum">';
		echo '<tr><td>Title:</td><td><input type="text" style="width: 300px;" name="message_title" value="' . stripslashes($message_title) . '" /></td></tr>';

		if ($action == 'reply')
		{
			echo '<tr><td colspan="2"><span style="font-size: 10px; font-style: italic">Consider changing the title to make it more relevant to the content of your post.</td></tr><tr><td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td></tr>';
		}

		echo '<tr><td valign="top">Message:</td><td><textarea style="width:500px; height: 200px" name="message_body">' . stripslashes($message_body) . '</textarea></td></tr>';

		$options = '';

		if ($action == 'new' || !$forums->bookmarked($forums->first_post($forums->p_id)))
		{
			$options .= '<li style="list-style-type: none;"><input type="checkbox" value="bookmark" name="bookmark" id="bookmark"> <label for="bookmark">Bookmark thread</label></li>';
		}

		if ($action != 'new' && ($forums->p_data['is_reported'] && (($flags & F_POST_DELETEALL) || ($flags & F_POST_EDITALL))))
		{
			$options .= '<li style="list-style-type: none;"><input type="checkbox" value="reports" name="reports" id="reports"> <label for="reports">Remove report notices</label></li>';
		}

		if ($options)
		{
			echo '<tr><td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td></tr>';
			echo '<tr><td style="vertical-align: top">Options:</td><td>' . $options . '</td></tr>';
		}

		echo '<tr><td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td></tr>';
		echo '<tr><td colspan="2" align="center">' . $buttons . '</td></tr>';
		echo '</table>';

		echo '</form></div>';
?>

<ul>
	<li>No HTML is allowed in your posts. To make a word bold, put asterisks around it (e.g. *bold*). To put a word in italics, enclose it in forward slashes (e.g. /italics/). For more formatting tags, please read the <a href="/about/faqs/formatting.html">Formatting FAQ</a>.</li>
	<li>You cannot edit what you have written after you have pressed submit. Please preview your posts to make sure you are saying what you are intending to say.</li>
	<li>Try to keep posts on topic.</li>
	<li>Read other posts to make sure you are not duplicating what has been said elsewhere.</li>
	<li>Do not post offensive, flamebait, illegal or inappropriate content in your messages.</li>
</ul>

<?php
		break;

	case 'report':

		if (!$session->logged_in)
		{
			$title = 'Sign In';

			echo '<p>You must be signed in to report posts. You can use the form in the top right to sign in,
				or register if you do not have an account.</p>';

			break;
		}

		$flags = permission::get_flags('forums', $forums->f_id);

		if ($flags & F_POST_REPORT)
		{
			$sql = 'SELECT r.id, r.report_category, r.description
				FROM reports r
				WHERE r.p_id = %d
				AND r.u_id = %d';

			$sql = sprintf($sql, $forums->p_id, $session->user_id);

			$db->sql_query($sql);
			$db->sql_data($report, true);

			if (!empty($report))
			{
				$f_rep_dd = $report['report_category'];
				$f_description = $report['description'];

				$ar = true;
			}
			else
			{
				$f_rep_dd = 0;
				$f_description = '';

				$ar = false;
			}

			if (!empty($_POST['submit']))
			{
				$f_rep_dd = (!empty($_POST['rep_dd']) ? $_POST['rep_dd'] : $f_rep_dd);
				$f_description = (!empty($_POST['description']) ? $_POST['description'] : $f_description);

				if ($f_rep_dd && $f_description)
				{
					if ($ar)
					{
						$sql = 'UPDATE reports SET
							report_category = %d,
							description = "%s"
							time = %d
							WHERE u_id = %d
							AND p_id = %d';

						$sql = sprintf($sql, $f_rep_dd, $f_description, time(), $session->user_id, $forums->p_id);
					}
					else
					{
						$forums->change('is_reported', 1, $forums->p_id);

						$sql = 'SELECT r.id
							FROM reports r
							ORDER BY r.id DESC
							LIMIT 1';

						$db->sql_query($sql);
						$db->sql_data($id, true);

						$id = @implode($id) + 1;

						$sql = 'INSERT INTO reports (
							id, p_id, u_id, time, report_category, description
							) VALUES (
							%d, %d, %d, %d, %d, "%s"
							)';

						$sql = sprintf($sql, $id, $forums->p_id, $session->user_id, time(), $f_rep_dd, $f_description);
					}

					$db->sql_query($sql);

					$title = 'Post Reported';

					$location = array(
						'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
						'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
					);

					$forums->forum_location($location);

					$location[] = '<a href="' . $config['install_path'] . $forums->furl('viewforum', $forums->f_id) . '">' . $forums->f_data['title'] . '</a>';

					$location[] = '<a href="' . $config['install_path'] . $forums->furl('view', $forums->first_post($forums->p_id)) . '#post' . $forums->p_id . '">' . $forums->p_data['title'] . '</a>';

					if ($ar)
					{
						echo '<p>The report you made has been updated. Thankyou for reporting the post.</p>';
					}
					else
					{
						echo '<p>Thankyou for reporting the post. A moderator may take action based on the content of your report.</p>';
					}

					break;
				}
			}

			$title = 'Report Post';

			$location = array(
				'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
				'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
			);

			$forums->forum_location($location);

			$location[] = '<a href="' . $config['install_path'] . $forums->furl('viewforum', $forums->f_id) . '">' . $forums->f_data['title'] . '</a>';

			$location[] = '<a href="' . $config['install_path'] . $forums->furl('view', $forums->first_post($forums->p_id)) . '#post' . $forums->p_id . '">' . $forums->p_data['title'] . '</a>';

			if ($ar)
			{
				echo '<p>You have already reported this post. If you want to change the information you submitted when reporting the post, please correct it here.</p>';
			}
?>
<form method="post" action="<?php echo $config['install_path'] . forums::furl('report', $forums->p_id); ?>">
	<table class="forum">
		<tr>
			<td>Report category<span class="smaller"><br />Please select the most appropriate category for your report.</span></td>
			<td><select name="rep_dd"><?php echo $forums->report_list($f_rep_dd); ?></select></td>
		</tr>
		<tr>
			<td>Reason<span class="smaller"><br />Please enter a reason for why you are reporting this post.</span></td>
			<td><textarea style="height: 100px; width: 300px;" name="description"><?php echo $f_description; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Report" name="submit" /></td>
		</tr>
	</table>
</form>
<?php
		}

		break;

	case 'reports':

		$can_view = false;

		$flags = permission::get_flags('forums', $forums->f_id);

		if (($flags & F_POST_DELETEALL) || ($flags & F_POST_EDITALL))
		{
			$can_view = true;
		}

		if (!$can_view)
		{
			if (!$session->logged_in)
			{
				$title = 'Sign In';

				echo '<p>You must be signed in to view reports. You can use the form in the top right to sign in,
					or register if you do not have an account.</p>';

				break;
			}

			$title = 'Permission Denied';
			$location = array(
			        '<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
				'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
			);

			$forums->forum_location($location);

			$location[] = '<a href="' . $config['install_path'] . $forums->furl('viewforum', $forums->f_id) . '">' . $forums->f_data['title'] . '</a>';
			$location[] = '<a href="' . $config['install_path'] . $forums->furl('view', $forums->first_post($forums->p_id)) . '#post' . $forums->p_id . '">' . $forums->p_data['title'] . '</a>';

			echo '<p>You may not view the report reasons for posts in this forum.</p>';
		}
		else
		{
			$title = 'View Reports';

			$location = array(
				'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
				'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
			);

			$forums->forum_location($location);

			$location[] = '<a href="' . $config['install_path'] . $forums->furl('viewforum', $forums->f_id) . '">' . $forums->f_data['title'] . '</a>';
			$location[] = '<a href="' . $config['install_path'] . $forums->furl('view', $forums->first_post($forums->p_id)) . '#post' . $forums->p_id . '">' . $forums->p_data['title'] . '</a>';

			if (!$forums->p_data['is_reported'])
			{
				echo '<p>This post has not been reported.</p>';

				break;
			}

			if (!empty($_POST['remove']))
			{
				$to_rm = array();

				foreach ($_POST['report'] as $key => $value)
				{
					$to_rm[] = $key;
				}

				if (!empty($to_rm))
				{
					$to_rm = implode(', ', $to_rm);

					$sql = 'DELETE FROM reports
						WHERE id IN (%s)';

					$sql = sprintf($sql, $to_rm);

					$db->sql_query($sql);

					$sql = 'SELECT count(*) AS count
						FROM reports
						WHERE p_id = %d';

					$sql = sprintf($sql, $forums->p_id);

					$db->sql_query($sql);
					$db->sql_data($count, true);

					if (!$count['count'])
					{
						$forums->change('is_reported', 0, $forums->p_id);
					}
				}

				redirect($config['install_path'] . forums::furl('reports', $forums->p_id));
			}

			$sql = 'SELECT r.description, r.id, r.time, r.u_id, u.username, rc.title
				FROM reports r, report_categories rc, users u
				WHERE r.p_id = %d
				AND r.u_id = u.user_id
				AND rc.id = r.report_category
				ORDER BY r.time ASC';

			$sql = sprintf($sql, $forums->p_id);

			$db->sql_query($sql);
			$db->sql_data($data);

			echo '<form method="post" action="' . $config['install_path'] . forums::furl('reports', $forums->p_id) . '"><table class="forum" cellspacing="0" cellpadding="0" width="100%"><tr class="forum-top"><th>Reporter</th><th>Date Reported</th><th>Category</th><th>Description</th><th>&nbsp;</th></tr>';

			foreach ($data as $key => $report)
			{
				echo '<tr><td class="smaller ' . ($key % 2 ? 'even' : 'odd') . '" style="text-align: center"><a href="' . $config['install_path'] . accounts::aurl('viewprofile', $report['u_id']) . '">' . $report['username'] . '</a></td>';
				echo '<td class="smaller ' . ($key % 2 ? 'even' : 'odd') . '" style="text-align: center">' . date('d M Y, H:i:s', $report['time']) . '</td>';
				echo '<td class="smaller ' . ($key % 2 ? 'even' : 'odd') . '" style="text-align: center">' . $report['title'] . '</td>';
				echo '<td class="smaller ' . ($key % 2 ? 'even' : 'odd') . '">' . format_text($report['description']) . '</td>';
				echo '<td class="smaller ' . ($key % 2 ? 'even' : 'odd') . '" style="text-align: center"><input type="checkbox" name="report[' . $report['id'] . ']" /></td></tr>';
			}

			echo '</table>';

			echo '<p style="text-align:right; font-size: smaller;">For the selected reports: <br /><input style="font-size: smaller;" type="submit" name="remove" value="Remove Report" /></p></form>';
		}

		break;

	case 'delete':

		$can_delete = false;

		$flags = permission::get_flags('forums', $forums->f_id);

		if ($flags & F_POST_DELETEALL)
		{
			$can_delete = true;
		}
		else if (($flags & F_POST_DELETE) && $forums->p_data['u_id'] == $session->user_id && !$forums->p_data['replies'])
		{
			$can_delete = true;
		}

		if (!$can_delete)
		{
			if (!$session->logged_in)
			{
				$title = 'Sign In';

				echo '<p>You must be signed in to delete posts. You can use the form in the top right to
					sign in, or register if you do not have an account.</p>';

				break;
			}

			$title = 'Permission Denied';
			$location = array(
				'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
				'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
			);

			$forums->forum_location($location);

			$location[] = '<a href="' . $config['install_path'] . $forums->furl('viewforum', $forums->f_id) . '">' . $forums->f_data['title'] . '</a>';
			$location[] = '<a href="' . $config['install_path'] . $forums->furl('view', $forums->first_post($forums->p_id)) . '#post' . $forums->p_id . '">' . $forums->p_data['title'] . '</a>';

			echo '<p>You may not delete this post.</p>';
		}
		else
		{
			if (!empty($_POST['confirm']))
			{
				$forums->delete_post($forums->p_id);

				redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('viewforum', $forums->f_id));
			}
			else
			{
				$title = 'Delete Post';

				$location = array(
					'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
					'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
				);

				$forums->forum_location($location);

				$location[] = '<a href="' . $config['install_path'] . $forums->furl('viewforum', $forums->f_id) . '">' . $forums->f_data['title'] . '</a>';
				$location[] = '<a href="' . $config['install_path'] . $forums->furl('view', $forums->first_post($forums->p_id)) . '#post' . $forums->p_id . '">' . $forums->p_data['title'] . '</a>';
?>
<p>Deleting this post<?php echo ($forums->p_data['replies'] ? ' (and all of its replies)' : ''); ?> will permanently remove <?php echo ($forums->p_data['replies'] ? 'them' : 'it'); ?> from the database. Please confirm that you wish to do this.</p>

<form method="post" action="<?php echo $config['install_path'] . $forums->furl('delete', $forums->p_id); ?>">
	<input type="submit" name="confirm" value="Confirm Deletion">
</form>
<?php
			}
		}

		break;

	case 'move':

		if (permission::has_flag('forums', F_FORUM_MOD, $forums->f_id))
		{
			/*
				steps:
				  - choose the target:
				     - another post in this forum
				     - another post in another forum
				     - a new thread in this forum
				     - a new thread in another forum
				  - update in 'posts' for the moved posts:
				     - forum (may not change)
				     - fp_id
				     - parent_id (just for the selected post)
				  - update in 'posts' for any parent posts (only if the target is another post):
				     - last_reply (if later than the last reply of any parent posts)
				  - update in 'forums' (only if post(s) is/are moved to another forum):
				     - posts

				TODO: if a post is split off, redo the last post time for any parent posts of both the
				thread it was moved from and the thread it was moved to.
			*/

			if (isset($_POST['mt_merge']))
			{
			}
			else if (isset($_POST['mt_split']))
			{
				/* no further user choices required */

				$sql = 'UPDATE posts
					SET parent_id = 0
					WHERE d_id = %d';

				$sql = sprintf($sql, $forums->p_id);

				$db->sql_query($sql);

				/* iterate through all child posts and update their fp_id and forum */

				$num_updated = $forums->update_posts($forums->p_id, sprintf('forum = %d, fp_id = %d', $_POST['mt_split_forum'], $forums->p_id));

				$forums->resync_forum_post_count($forums->f_id);
				$forums->resync_forum_post_count($_POST['mt_split_forum']);

				redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('view', $forums->p_id));
			}
			else
			{
				$title = 'Move/Merge Post';
				$location = array(
					'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
					'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
				);

				$forums->forum_location($location);

				$location[] = '<a href="' . $config['install_path'] . forums::furl('viewforum', $forums->f_id) . '">' . $forums->f_data['title'] . '</a>';
				$location[] = '<a href="' . $config['install_path'] . forums::furl('view', $forums->p_id) . '">' . $forums->p_data['title'] . '</a>';
?>
<p>Select a destination for this post, and all of its replies:</p>
<form method="post" action="<?php echo $config['install_path'] . forums::furl('move', $forums->p_id) ?>">
    <p>Create as new thread<br /><span style="font-size: 90%">Split this post (and all replies) into a new thread, in the selected forum (the current forum is pre-selected). The post selected will become the 'first post' in the thread.</span></p>
    <p>Destination forum: <select name="mt_split_forum"><?php echo $forums->forum_dropdown($forums->f_id); ?></select></p>
    <input type="submit" name="mt_split" value="Split" />

    <!-- <p>Merge into another thread<br /><span style="font-size: 90%">Move this post (and all replies) into another thread, with the selected post becoming a reply to the destination post (under development).</span></p>
    <p>Destination forum: <select name="mt_merge_forum"><?php echo $forums->forum_dropdown($forums->f_id); ?></select></p>
    <input type="submit" name="mt_merge" value="Merge" /> -->
</form>
<?php
			}
		}

		break;

	case 'view':

		if (!permission::has_flag('forums', F_POST_READ, $forums->f_id))
		{
			if (!$session->logged_in)
			{
				$title = 'Sign In';

				$location = array(
					'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
					'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
				);

				echo '<p>You must be signed in to view this post. You can use the form in the top right to
					sign in, or register if you do not have an account.</p>';

				break;
			}

			if (permission::has_flag('forums', F_FORUM_VIEW, $forums->f_id))
			{
				/*
					some sick and twisted admin has allowed people to see the
					forum exists but not allowed them to read topics posted to it.
				*/

				$title = 'Permission Denied';
				$location = array(
					'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
					'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
				);

				$forums->forum_location($location);

				echo '<p>You are not allowed to read posts in this forum. If you feel this is in error, you should
					contact the <a href="mailto:' . $config['contact_email'] . '">board administrator</a>.</p>';
			}
			else
			{
				/* the user is messing around with the query string probably */
				redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl());
			}

			break;
		}

		$title = $forums->p_data['title'];

		$location = array(
			'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
			'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
		);

		$forums->forum_location($location);

		$flags = permission::get_flags('forums', $forums->f_id);

		$fp_data = $forums->post_get_data($forums->first_post($forums->p_id));

		if ($fp_data['is_locked'])
		{
			$flags &= ~(F_POST_REPLY | F_POST_EDIT);
		}

		$location[] = '<a href="' . $config['install_path'] . $forums->furl('viewforum', $forums->f_id) . '">' . $forums->f_data['title'] . '</a>';

		$count_unapproved = 0;

		if ($flags & F_POST_APPROVE)
		{
			echo '<form method="post" action="' . $config['install_path'] . $forums->furl('approve', $forums->f_id) . '" />';
		}

		if ($session->logged_in)
		{
			$read = ($forums->p_data['post_read'] == null ? false : true);
		}
		else
		{
			/* isset() returns false for null values */
			$read = null;
		}

		echo $forums->display_single_post(array(
		    'id' => $forums->p_id,
		    'title' => $forums->p_data['title'],
		    'date' => $forums->p_data['date'],
		    'u_id' => $forums->p_data['u_id'],
		    'username' => $forums->p_data['username'],
		    'signature' => $forums->get_sig($forums->p_data['u_id']),
		    'text' => $forums->p_data['text'],
		    'replies' => $forums->p_data['replies'],
		    'first_post' => $forums->p_id,
		    'parent' => $forums->p_data['parent_id'],
		    'read' => $read,
		    'format_type' => $forums->p_data['format_type'],
		    'is_unapproved' => $forums->p_data['is_unapproved'],
		    'is_reported' => $forums->p_data['is_reported'],
		    'flags' => $flags,
		    'edited' => (!empty($forums->p_data['edited_by']) ? array('uid' => $forums->p_data['edited_by'], 'date' => $forums->p_data['edited_time'], 'username' => $forums->p_data['edited_username']) : false)
		));

		$forums->display_sub_posts($forums->p_id, $forums->p_id, 1, $flags);

		if ($config['track_read'] == 'database' && $session->logged_in)
		{
			if (!empty($forums->p_data['reply_ids']))
			{
				$reply_ids = explode(',', $forums->p_data['reply_ids']);
			}
			else
			{
				$reply_ids = array();
			}

			$reply_ids = array_merge(array($forums->p_id), $reply_ids);

			$db->ignore_errors = true;

			foreach ($reply_ids as $reply_id)
			{
				$sql = 'INSERT INTO post_read (d_id, u_id) VALUES (%d, %d)';
				$sql = sprintf($sql, $reply_id, $session->user_id);

				$db->sql_query($sql);
			}

			$db->ignore_errors = false;
		}

		$opts = array();

		if ($session->logged_in)
		{
			$fp = forums::first_post($forums->p_id);

			$b_data = $forums->bookmarked($fp);

			if ($b_data)
			{
				if ($b_data['email_sent'])
				{
					$sql = 'UPDATE bookmarks
						SET email_sent = 0
						WHERE user_id = %d
						AND post_id = %d
						AND email = 1';

					$sql = sprintf($sql, $session->user_id, $fp);

					$db->sql_query($sql);
				}

				$opts[] = array('Remove From Bookmarks', $config['install_path'] . forums::furl('unbookmark', $fp));
			}
			else
			{
				$opts[] = array('Bookmark Thread', $config['install_path'] . forums::furl('bookmark', $fp));
			}

			if ($flags & F_FORUM_MOD)
			{
				if ($forums->p_data['is_locked'])
				{
					$opts[] = array('Unlock Thread', $config['install_path'] . forums::furl('unlock', $fp));
				}
				else
				{
					$opts[] = array('Lock Thread', $config['install_path'] . forums::furl('lock', $fp));
				}

				if ($forums->p_data['is_sticky'])
				{
					$opts[] = array('Unstick Thread', $config['install_path'] . forums::furl('unstick', $fp));
				}
				else
				{
					$opts[] = array('Stick Thread', $config['install_path'] . forums::furl('stick', $fp));
				}
			}
		}

		if (!empty($opts))
		{
			echo '<p class="center smaller">';

			$count_opts = count($opts);

			for ($i = 0; $i < $count_opts; $i++)
			{
				echo '<a href="'  . $opts[$i][1] . '">' . $opts[$i][0] . '</a>';

				if (!empty($opts[$i+1]))
				{
					echo ' | ';
				}
			}
			echo '</p>';
		}

		if ($count_unapproved && $flags & F_POST_APPROVE)
		{
			echo '<input type="submit" value="Moderate posts" />';
			echo '</form>';
		}

		break;

	case 'resync':

		/* this is database-intensive - it should not be run often */

		$forums->resync_post_count();

		if (!empty($_GET['from']))
		{
			$from = 'http://' . urldecode($_GET['from']);
		}
		else
		{
			$from = 'http://' . $config['domain_name'] . $config['install_path'] . forums::furl();
		}

		$from = str_replace('&amp;', '&', $from);

		redirect($from);

		break;

	case 'bookmark':
	case 'unbookmark':

		$forums->$op($forums->p_id);

		redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('view', $forums->p_id));

		break;

	case 'stick':
	case 'unstick':
	case 'lock':
	case 'unlock':

		if (permission::has_flag('forums', F_FORUM_MOD, $forums->f_id))
		{
			$forums->$op($forums->p_id);

			redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('view', $forums->p_id));
		}
		else
		{
			$title = 'Access Denied';

			echo 'You do not have the required access.';
		}

		break;

	case 'approve':

		$flags = permission::get_flags('forums', $forums->f_id);

		if ($flags & F_POST_APPROVE)
		{
			foreach ($_POST['approve'] as $key => $value)
			{
				if ($value == 'approve')
				{
					/*
						approve the post, update the last reply times, and update the
						bookmarks (not for the poster and the person who approves it)
					*/

					$sql = 'SELECT d.date, d.u_id, p.is_unapproved
						FROM data d, posts p
						WHERE d.id = p.d_id
						AND d.id = %d
						AND p.forum = %d';

					$sql = sprintf($sql, $key, $forums->f_id);

					$db->sql_query($sql);
					$db->sql_data($data, true);

					if (!$data['is_unapproved'])
					{
						/* this post is already approved, do nothing */
						continue;
					}

					$forums->change('is_unapproved', 0, $key);

					$forums->update_post_replies($key, $data['date']);
					$forums->update_forum_replies($forums->f_id);
				}
				else if ($value == 'delete')
				{
					if ($flags & F_POST_DELETEALL)
					{
					}
				}
			}
		}

		redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('viewforum', $forums->f_id));

		break;

	case 'bookmarks':

		if (!$session->logged_in)
		{
			echo '<p>You mist be signed in to view your bookmarks. Bookmarking threads is a feature for registered users only.</p>';

			break;
		}

		if (!empty($_POST))
		{
			if (!empty($_POST['thread']))
			{
				foreach ($_POST['thread'] as $key => $value)
				{
					if (!empty($_POST['delete']))
					{
						$forums->unbookmark($key);
					}

					if (!empty($_POST['email']))
					{
						$sql = 'UPDATE bookmarks
							SET email = (1 - email)
							WHERE user_id = %d
							AND post_id = %d';

						$sql = sprintf($sql, $session->user_id, $key);

						$db->sql_query($sql);
					}
				}
			}

			redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('bookmarks'));

			return;
		}

		$title = 'Bookmarks';
		$location = array(
			'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
			'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
		);

		echo '<p>This is a list of your bookmarked threads. The ability to bookmark threads gives you an easy way to track new posts to threads you are interested in.
			If email notification for the topic is active, whenever a new post is made to the thread, you will receive an email notifying you of new posts.</p>';

		echo '<form method="post" action="' . $config['install_path'] . forums::furl('bookmarks') . '">';

		echo '<table cellspacing="0" cellpadding="0" class="forum" width="100%">';
		echo '<tr class="forum-top"><th>Thread Subject</th><th>Forum</th><th>Poster</th><th>Date</th><th>Replies</th><th>&nbsp;</th></tr>';

		$bookmarks = $forums->select_bookmarks();

		$i = 0;

		foreach ($bookmarks as $post)
		{
			$i++;

			$post['text'] = preg_replace('/<(.*)>/U', '', $post['text']);

			$a_text = explode(' ', $post['text']);

			if (count($a_text) > 16)
			{
				$a_text = array_splice($a_text, 0, 16);
				$sample = implode(' ', $a_text) . ' ...';
			}
			else
			{
				$sample = implode(' ', $a_text);
			}

			$sample = preg_replace('/(\s+)/', ' ', $sample);

			$replies = $forums->count_replies($post['d_id']);

			$new_replies = 0;
			$new = '';

			if ($config['track_read'] == 'database')
			{
				if (!empty($post['reply_ids']))
				{
					$reply_ids = explode(',', $post['reply_ids']);
				}
				else
				{
					$reply_ids = array();
				}

				$reply_ids = array_merge(array($post['d_id']), $reply_ids);

				$sql = 'SELECT COUNT(*) as count
					FROM post_read r
					WHERE r.d_id IN (%s)
					AND r.u_id = %d';

				$sql = sprintf($sql, implode(',', $reply_ids), $session->user_id);

				$db->sql_query($sql);
				$db->sql_data($nr, true);

				if ($nr['count'] < $replies+1)
				{
					$new_replies = ($replies+1 - $nr['count']);
				}
			}

			$forum_data = $forums->forum_get_data($post['forum']);

			if ($new_replies-1>0)
			{
				$new = '<span style="font-size: 90%;"><br /> (<b>' . ($new_replies-1) . '</b> new)</span>';
			}

			echo "\n<tr>";

			echo '<td class="title ' . ($i % 2 ? 'even' : 'odd') . '"><p class="topic-title">' . ($post['email'] ? '<b>(E)</b> ' : '') . ($new_replies ? '<b>(N)</b> ' : '') . '<a href="' . $config['install_path'] . $forums->furl('view', $post['d_id']) . '">' . $post['title'] . '</a></p><p class="topic-description">' . $sample . '</p></td>';
			echo '<td class="bookmark-forum ' . ($i % 2 ? 'even' : 'odd') . '"><a href="' . $config['install_path'] . $forums->furl('viewforum', $post['forum']) . '">' . $forum_data['title'] . '</a></td>';
			echo '<td class="poster ' . ($i % 2 ? 'even' : 'odd') . '"><a href="' . $config['install_path'] . accounts::aurl('viewprofile', $post['u_id']) . '">' . id_to_username($post['u_id']) . '</a></td>';
			echo '<td class="date ' . ($i % 2 ? 'even' : 'odd') . '">' . date('Y/m/d H:i', $post['date']) . '</td>';
			echo '<td class="replies ' . ($i % 2 ? 'even' : 'odd') . '">' . $replies . $new . '</td>';
			echo '<td class="options ' . ($i % 2 ? 'even' : 'odd') . '"><input type="checkbox" name="thread[' . $post['d_id'] . ']" /></td>';

			echo '</tr>';
		}

		if (!$i)
		{
			echo '<tr><td class="odd" colspan="6"><p style="text-align: center; font-size: 11px;">You do not currently have any bookmarked threads.</p></td></tr>';
		}

		echo '</table>';

		if ($i)
		{
			echo '<p style="text-align:right; font-size: smaller;">For the selected threads: <br />';
			echo '<input style="font-size: smaller;" type="submit" name="email" value="Toggle Email Notification" /> ';
			echo '<input style="font-size: smaller;" type="submit" name="delete" value="Remove Bookmark" /></p>';
		}

		echo '</form>';

		break;

	case 'markread':

		if ($session->logged_in && $config['track_read'] == 'database')
		{
			if (empty($forums->f_id))
			{
				$redir = forums::furl();

				$sql = 'SELECT f.id, p.default_flags, up.flags
					FROM forums f
					LEFT JOIN permissions p ON p.sub_id = f.id
					LEFT JOIN user_permission up ON (
						up.sub_id = p.sub_id
						AND (
							up.u_id = NULL
							OR up.u_id = %d
						)
					)
					AND p.name = "forums"';

				$sql = sprintf($sql, $session->user_id);

				$db->sql_query($sql);
				$db->sql_data($data);

				$forums = array();

				foreach ($data as $forum)
				{
					if ($forum['flags'] == '')
					{
						if ($forum['default_flags'] & F_FORUM_VIEW)
						{
							$forums[] = $forum['id'];
						}
					}
					else if ($forum['flags'] & F_FORUM_VIEW)
					{
						$forums[] = $forum['id'];
					}
				}

				$sql = 'SELECT p.d_id
					FROM posts p
					WHERE p.forum IN (%s)
					AND p.is_unapproved = 0';

				$sql = sprintf($sql, implode(',', $forums));
			}
			else
			{
				$redir = forums::furl('viewforum', $forums->f_id);

				$sql = 'SELECT p.d_id
					FROM posts p
					WHERE p.forum = %d
					AND p.is_unapproved = 0';

				$sql = sprintf($sql, $forums->f_id);
			}

			$db->sql_query($sql);
			$db->sql_data($data);

			$db->ignore_errors = true;

			$sql_i = 'INSERT INTO post_read (d_id, u_id) VALUES (%d, %d)';

			foreach ($data as $value)
			{
				$sql = sprintf($sql_i, $value['d_id'], $session->user_id);

				$db->sql_query($sql);
			}

			$db->ignore_errors = false;
		}

		redirect('http://' . $config['domain_name'] . $config['install_path'] . $redir);

		break;

	case 'viewforum':

		if (!permission::has_flag('forums', F_FORUM_VIEW, $forums->f_id))
		{
			if (!$session->logged_in)
			{
				$title = 'Sign In';

				echo '<p>You must be signed in to view this forum. You can use the form in the top right to
					sign in, or register if you do not have an account.</p>';

				break;
			}

			redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl());
		}

		$title = $forums->f_data['title'];
		$location = array(
			'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
			'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
		);

		$forums->forum_location($location);

		$default_flags = permission::get_default_flags('forums', $forums->f_id);

		if ($default_flags & (F_FORUM_VIEW | F_POST_READ))
		{
			$head[] = sprintf('<link rel="alternate" type="application/rss+xml" title="All Forums Feed (RSS 2.0)" href="http://%s" />',
				$config['domain_name'] . $config['install_path'] . 'rss.php'
			);

			$head[] = sprintf('<link rel="alternate" type="application/rss+xml" title="%s Feed (RSS 2.0)" href="http://%s" />',
				$forums->f_data['title'],
				$config['domain_name'] . $config['install_path'] . 'rss.php?f=' . $forums->f_id
			);
		}

		echo '<p class="description"><i>Description</i>: ' . unhtmlspecialchars($forums->f_data['description']) . '</p>';

		if (false !== ($s_subforums = $forums->display_forums($forums->f_id)))
		{
			echo '<h3>Subforums</h3>';

			echo $s_subforums;
		}

		if (permission::has_flag('forums', F_POST_NEW, $forums->f_id))
		{
			echo '<p><a href="' . $config['install_path'] . $forums->furl('post', 'f', $forums->f_id) . '">New Topic</a></p>';
		}

		if (false !== ($posts = $forums->select_forum_posts($forums->f_id)))
		{
			echo '<table cellspacing="0" cellpadding="0" class="forum" width="100%">';

			echo '<tr class="forum-top"><th>Thread Subject</th><th>Poster</th><th>Date</th><th>Replies</th></tr>';

			$i = 0;

			foreach($posts as $post)
			{
				$i++;

				$new_replies = false;

				$post['text'] = preg_replace('/<(.*)>/U', '', $post['text']);

				$a_text = explode(' ', $post['text']);

				if (count($a_text) > 16)
				{
					$a_text = array_splice($a_text, 0, 16);
					$sample = implode(' ', $a_text) . ' ...';
				}
				else
				{
					$sample = implode(' ', $a_text);
				}

				$sample = htmlspecialchars(preg_replace('/(\s+)/', ' ', $sample));
				$post_title = htmlspecialchars($post['title']);

				$replies = $post['replies'];

				if ($session->logged_in && $config['track_read'] == 'database')
				{
					if (!empty($post['reply_ids']))
					{
						$reply_ids = explode(',', $post['reply_ids']);
					}
					else
					{
						$reply_ids = array();
					}

					$reply_ids = array_merge(array($post['d_id']), $reply_ids);

					$sql = 'SELECT COUNT(*) as count
						FROM post_read r
						WHERE r.d_id IN (%s)
						AND r.u_id = %d';

					$sql = sprintf($sql, implode(', ', $reply_ids), $session->user_id);

					$db->sql_query($sql);
					$db->sql_data($nr, true);

					if ($nr['count'] < $replies+1)
					{
						$new_replies = ($replies+1 - $nr['count']);
					}
				}

				echo "\n<tr>";

				echo '<td class="title ' . ($i % 2 ? 'even' : 'odd') . '"><p class="topic-title">' . ($post['is_locked'] ? '<b>(L)</b> ' : '') . ($new_replies ? '<b>(N)</b> ' : '') . ($post['is_sticky']  ? '<b>Sticky:</b> ' : '') . '<a href="' . $config['install_path'] . $forums->furl('view', $post['d_id']) . '">' . $post_title . '</a></p><p class="topic-description">' . $sample . '</p></td>';
				echo '<td class="poster ' . ($i % 2 ? 'even' : 'odd') . '"><a href="' . $config['install_path'] . accounts::aurl('viewprofile', $post['u_id']) . '">' . $post['username'] . '</a></td>';
				echo '<td class="date ' . ($i % 2 ? 'even' : 'odd') . '">' . date('Y/m/d H:i', $post['date']) . '</td>';
				echo '<td class="replies ' . ($i % 2 ? 'even' : 'odd') . '">' . $replies . ($new_replies-1>0 ? '<span style="font-size: 90%"><br />(<b>' . ($new_replies-1) . '&nbsp;new</b>)</span>' : '') . '</td>';


				echo '</tr>';
			}

			echo '</table>';

			$opts = array();

			if ($session->logged_in)
			{
				if ($config['track_read'] == 'database')
				{
					$opts[] = array('Mark All Posts Read', $config['install_path'] . forums::furl('markread', $forums->f_id));
				}
			}

			$opts[] = array('Search Forum', $config['install_path'] . 'search.php?f=' . $forums->f_id);

			$flags = permission::get_default_flags('forums', $forums->f_id);

			if ($flags & (F_FORUM_VIEW | F_POST_READ))
			{
				$opts[] = array('RSS Feed', $config['install_path'] . 'rss.php?f=' . $forums->f_id);
			}

			if (!empty($opts))
			{
				echo '<p class="center smaller">';

				$count_opts = count($opts);

				for ($i = 0; $i < $count_opts; $i++)
				{
					echo '<a href="'  . $opts[$i][1] . '">' . $opts[$i][0] . '</a>';

					if (!empty($opts[$i+1]))
					{
						echo ' | ';
					}
				}

				echo '</p>';
			}
		}
		else
		{
			if (permission::has_flag('forums', F_POST_NEW))
			{
				echo '<table cellspacing="0" cellpadding="0" class="forum" width="100%"><tr><td class="title even" style="border-top: 1px #ddb solid; text-align: center">There are no posts in this forum.</td></tr></table>';
			}
		}

		/* dropdown box */

		echo '<form method="post" action="' . forums::furl('redirview') . '"><select name="f">';

		echo $forums->forum_dropdown();

		echo '</select><input type="submit" value ="Go" /></form>';

		break;

	case 'redirview':

		redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('viewforum', $_POST['f']));

	case 'admin':

		if (!empty($sub))
		{
			switch ($sub)
			{
				case 'userpermissions':

					if (!permission::has_flag('forums', F_FORUM_EDIT))
					{
						redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin'));
					}

					if (!empty($_POST['advanced']))
					{
						$new_perm = 0;

						foreach ($_POST['adv'] as $perm)
						{
							$new_perm += $perm;
						}

						if (permission::get_default_flags('forums', $_GET['f'], $_GET['u_id']) & F_FORUM_APPROVAL)
						{
							/* ensure the F_FORUM_APPROVAL permission is carried into user permissions */
							$new_perm += F_FORUM_APPROVAL;
						}

						$permission = new permission('forums', $_GET['f'], $_GET['u_id']);
						$permission->update($new_perm);

						redirect(str_replace('&amp;', '&', 'http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin', 'userpermissions', $_GET['f'], 'view', $_GET['u_id'])));

					}

					if (!empty($_GET['u_id']) && !empty($_GET['f']))
					{
						$u = $_GET['u_id'];
						$f = $_GET['f'];

						$fdata = forums::forum_get_data($f);

						$sql = 'SELECT p.*
							FROM permissions p
							WHERE p.name = "%s"
							AND p.sub_id = %d
							LIMIT 1';

						$sql = sprintf($sql, 'forums', $f);

						$db->sql_query($sql);
						$db->sql_data($data, true);

						if (!empty($data))
						{
							$defflags = $data['default_flags'];
						}
						else
						{
							$defflags = 0;
						}

						$location = array(
							'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
							'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
							'<a href="' . $config['install_path'] . forums::furl('admin') . '">Administration Panel</a>',
							'<a href="' . $config['install_path'] . forums::furl('admin', 'permissions') . '">Permissions</a>',
							'<a href="' . $config['install_path'] . forums::furl('admin', 'permissions', $f) . '">\'' . $fdata['title'] . '\' Permissions</a>'
						);

						$title = 'User Permissions: ' . id_to_username($u);

						$userflags = permission::get_flags('forums', $f, $u);

						echo '<p>You are editing the permissions of <a href="' . $config['install_path'] . accounts::aurl('viewprofile', $u) . '">' . id_to_username($u) . '</a>, in the
							forum <a href="' . $config['install_path'] . forums::furl('viewforum', $fdata['id']) . '">' . $fdata['title'] . '</a>.</p>';

						echo '<form method="post" action="' . $config['install_path'] . forums::furl('admin', 'userpermissions', $f, 'edit', $u) . '">';

						$cb = array(
							'view' => array('View Forum', 'user can view this forum in the forums index.', F_FORUM_VIEW),
							'read' => array('Read Posts', 'user can read all posts made to this forum.', F_POST_READ),
							'new' => array('Post New Thread', 'user can start a new thread to the forum.', F_POST_NEW),
							'reply' => array('Post Reply', 'user can reply to posts made in this forum.', F_POST_REPLY),
							'edit' => array('Edit Post', 'user can edit posts they have made after posting (but not after a reply has been made).', F_POST_EDIT),
							'delete' => array('Delete Post', 'user can delete posts they have made after posting (but not after a reply has been made).', F_POST_DELETE),
							'report' => array('Report Post', 'user can report posts to moderators for review.', F_POST_REPORT),
							'editall' => array('Edit All', 'user can edit any post, by any user.', F_POST_EDITALL),
							'deleteall' => array('Delete All', 'user can delete any post, by any user.', F_POST_DELETEALL),
							'mod' => array('Moderate', 'user can lock topics, create stickies and other moderator functions.', F_FORUM_MOD),
							'approve' => array('Approve', 'user can approve posts to be viewed by regular users.', F_POST_APPROVE)
						);

						foreach ($cb as $checkbox)
						{
							$checked = '';

							if ($userflags & $checkbox[2])
							{
								$checked = ' checked="checked"';
							}

							echo '<p><input' . $checked . ' type="checkbox" name="adv[]" value="' . $checkbox[2] . '" id="adv_' . $checkbox[2] . '" /><label for="adv_' . $checkbox[2] . '">' . $checkbox[0] . '</label><br /><span style="font-size: smaller;">' . $checkbox[1] . '<br />default: <b>' . ($defflags & $checkbox[2] ? '<span style="color: #4c4">on</span>' : '<span style="color: #c44">off</span>') . '</b></span></p>';
						}

						echo '<input type="submit" value="Submit" name="advanced" /></form>';
					}
					else if (!empty($_GET['f']))
					{

						$f = $_GET['f'];
						$fdata = forums::forum_get_data($f);

						$title = 'User Permissions';

						echo '<p>To edit a user\'s permissions, enter the appropriate username. You may use a wildcard asterisk (*) and a dropdown list will be generated showing all usernames which match the list (for example, entering <i>A*</i> will list all usernames which begin with the letter <i>A</i> - it is case-insensitive).</p>';

						$location = array(
							'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
							'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
							'<a href="' . $config['install_path'] . forums::furl('admin') . '">Administration Panel</a>',
							'<a href="' . $config['install_path'] . forums::furl('admin', 'permissions') . '">Permissions</a>',
							'<a href="' . $config['install_path'] . forums::furl('admin', 'permissions', $f) . '">\'' . $fdata['title'] . '\' Permissions</a>'
						);

						echo '<form method="post" action="' . $config['install_path'] . forums::furl('admin', 'userpermissions', $f) . '">';

						$username = '';

						if (!empty($_POST['dropdown_username']) && $_POST['dropdown_username'] != -1)
						{
							redirect(str_replace('&amp;', '&', 'http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin', 'userpermissions', $f, 'edit', $_POST['dropdown_username'])));
						}

						if (!empty($_POST['username']))
						{
							$username = $_POST['username'];
							$users = select_users($username);

							if (count($users) == 1 && !strpos($username, '*'))
							{
								redirect(str_replace('&amp;', '&', 'http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin', 'userpermissions', $f, 'edit', $users[0]['user_id'])));
							}

							echo '<select name="dropdown_username">';
							echo '<option value="-1">Select Name:</option>';

							foreach ($users as $user)
							{
								echo '<option value="' . $user['user_id'] . '">' . $user['username'] . '</option>';
							}

							echo '</select>';
						}

						echo '<input type="text" name="username" value="' . $username . '" />';
						echo '<input type="submit" value="Submit" />';

						echo '</form>';
					}

					break;

				case 'permissions':

					if (!permission::has_flag('forums', F_FORUM_EDIT))
					{
						redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin'));
					}

					$title = 'Permissions';
					$location = array(
						'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
						'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
						'<a href="' . $config['install_path'] . forums::furl('admin') . '">Administration Panel</a>'
					);

					if (!empty($_GET['f']))
					{
						$f = $_GET['f'];

						$fdata = forums::forum_get_data($f);

						$title = 'Permissions: ' . $fdata['title'];
						$location[] = '<a href="' . $config['install_path'] . forums::furl('admin', 'permissions') . '">Permissions</a>';

						if (isset($_POST['advanced']))
						{
							$newperm = 0;

							foreach ($_POST['adv'] as $key => $value)
							{
								$newperm = $newperm + $value;
							}

							$permissions = new permission('forums', $f);

							$permissions->updatedef('forums', $f, $fdata['title'] . ' Permissions', $newperm);

							$to = str_replace('&amp;', '&', 'http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin', 'permissions', $f));

							redirect($to);
						}

						if (isset($_POST['quick']))
						{
							$permissions = new permission('forums', $f);

							$permissions->updatedef('forums', $f, $fdata['title'] . ' Permissions', $_POST['newperm']);

							$to = str_replace('&amp;', '&', 'http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin', 'permissions', $f));

							redirect($to);
						}

						$sql = 'SELECT p.*
							FROM permissions p
							WHERE p.name = "%s"
							AND p.sub_id = %d
							LIMIT 1';

						$sql = sprintf($sql, 'forums', $f);

						$db->sql_query($sql);
						$db->sql_data($data, true);

						if (!empty($data))
						{
							$defflags = $data['default_flags'];
						}
						else
						{
							$defflags = 0;
						}

						$action = 'quick';

						if (!empty($_GET['action']))
						{
							if ($_GET['action'] == 'adv')
							{
								$action = 'advanced';
							}
						}

						if ($action == 'quick')
						{
							$types = array(
								'normal' => array('Read, write and edit', 'All users can read posts made to this forum, start new threads, reply to existing posts, and edit and delete their posts, and may report posts to moderators.', (F_FORUM_VIEW | F_POST_READ | F_POST_NEW | F_POST_REPLY | F_POST_EDIT | F_POST_DELETE | F_POST_REPORT)),
								'noedit' => array('Read and write', 'All users can read posts made to the forum, start new threads and reply to existing posts, but may not edit or delete their posts after making them, but may report posts to moderators.', (F_FORUM_VIEW | F_POST_READ | F_POST_NEW | F_POST_REPLY | F_POST_REPORT)),
								'readonly' => array('Read only', 'Normal users cannot post to this forum.', (F_FORUM_VIEW | F_POST_READ)),
								'hidden' => array('Hidden', 'Normal users cannot see this forum.', 0)
							);

							$dv = 0;
?>
<h2>Quick Permissions</h2>

<p>These permissions are useful for fast creation of forums. You may wish to customise permissions further; e.g. to allow or deny specific users access to the forum. This can be done on the <a href="<?php echo $config['install_path'] . forums::furl('admin', 'userpermissions', $f); ?>">user permissions page</a>.</p>

<form method="post" action="<?php echo $config['install_path'] . forums::furl('admin', 'permissions', $f); ?>">
	<table class="forum" style="width: 500px">
		<tr>
			<td>&nbsp;</td><td><p class="topic-title">Description</p></td>
		</tr>
		<tr>
			<td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td>
		</tr>
<?php
							foreach ($types as $key => $value)
							{
								if ($defflags == $value[2])
								{
									$dv++;
									echo '<tr><td><input type="radio" checked="checked" id="np_' . $value[2] . '" name="newperm" value="' . $value[2] . '" /></td>';
									echo '<td><label for="np_' . $value[2] . '"><strong>' . $value[0] . '</strong></label><br /><span class="smaller">' . $value[1] . '</span></td></tr>';
								}
								else
								{
									echo '<tr><td><input type="radio" name="newperm" id="np_' . $value[2] . '" value="' . $value[2] . '" /></td>';
									echo '<td><label for="np_' . $value[2] . '">' . $value[0] . '</label><br /><span class="smaller">' . $value[1] . '</span></td></tr>';
								}
							}

							if (!$dv)
							{
								echo '<tr><td><input type="radio" checked="checked" id="np_' . $defflags . '" name="newperm" value="' . $defflags . '" /></td>';
								echo '<td><label for="np_' . $defflags  . '"><strong>Custom</strong></label><br /><span class="smaller">The permissions for this forum have been fine-tuned using the <a href="' . $config['install_path'] . forums::furl('admin', 'permissions', $f, 'adv') . '">advanced view</a>.</span></td></tr>';
							}
?>
		<tr>
			<td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td>
		</tr>
		<tr>
			<td colspan="2" style="font-size: 11px;"><p style="padding: 0; margin: 3px;">After updating, the new permissions will take effect immediately. Users who have already had their permissions modified for this forum will not be changed.</p><p style="padding: 0; margin: 3px;">To fine-tune the permissions for this forum, enable the <a href="<?php echo $config['install_path'] . forums::furl('admin', 'permissions', $f, 'adv'); ?>">advanced view</a>.</p></td>
		</tr>
		<tr>
			<td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;"><input type="submit" name="quick" value="Update" /></td>
		</tr>
	</table>
</form>
<?php
						}
						else
						{
							$title .= ' (Advanced View)';

							echo '<h2>Advanced Permissions</h2>';
							echo '<p>Here you can customise the options available to all users. To allow or deny some of these options
								to specific users, visit the <a href="' . $config['install_path'] . forums::furl('admin', 'userpermissions', $f) . '">user permissions
								page</a>.</p>';

							echo '<p>You may wish to return to the <a href="' .  $config['install_path'] . forums::furl('admin', 'permissions', $f) . '">simple view</a>.</p>';

							echo '<form method="post" action="' . $config['install_path'] . forums::furl('admin', 'permissions', $f) . '">';

							$cb = array(
								'view' => array('View forum', 'users can view this forum in the forums index.', F_FORUM_VIEW),
								'read' => array('Read posts', 'users can read all posts made to this forum.', F_POST_READ),
								'new' => array('Post new thread', 'users can start a new thread to the forum.', F_POST_NEW),
								'reply' => array('Post reply', 'users can reply to posts made in this forum.', F_POST_REPLY),
								'edit' => array('Edit post', 'users can edit posts they have made after posting (but not after a reply has been made).', F_POST_EDIT),
								'delete' => array('Delete post', 'users can delete posts they have made after posting (but not after a reply has been made).', F_POST_DELETE),
								'approval' => array('Approval required', 'all posts require approval before they can be viewed.', F_FORUM_APPROVAL),
								'report' => array('Post reporting', 'posts may reported to moderators for review.', F_POST_REPORT)
							);

							foreach ($cb as $checkbox)
							{
								$checked = '';

								if ($defflags & $checkbox[2])
								{
									$checked = ' checked="checked"';
								}

								echo '<p><input' . $checked . ' type="checkbox" name="adv[]" value="' . $checkbox[2] . '" />' . $checkbox[0] . '<br /><span style="font-size: smaller;">' . $checkbox[1] . '</span></p>';
							}

							echo '<input type="submit" value="Submit" name="advanced" /></form>';
						}
					}
					else
					{
						echo '<p>Please select a forum from the dropdown list below.</p>';

						echo '<form method="get" action="' . $config['install_path'] . forums::furl('admin', 'permissions') . '">';
						echo '<select name="f">' . forums::forum_dropdown() . '</select>&nbsp;<input type="submit" value="Submit" />';

						if (!REWRITE)
						{
							echo '<input type="hidden" name="op" value="admin" /><input type="hidden" name="sub" value="permissions" />';
						}

						echo '</form>';
					}

					break;

				case 'manage':

					if (!permission::has_flag('forums', F_FORUM_EDIT))
					{
						redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin'));
					}

					if (!empty($_GET['f']) && (!empty($_GET['action'])))
					{
						$f = $_GET['f'];

						$fdata = forums::forum_get_data($f);

						$action = $_GET['action'];

						switch ($action)
						{
							case 'up':
							case 'down':

								$sql = 'SELECT f.id
									FROM forums f
									WHERE f.position = %d
									AND parent_id = %d';

								if ($action == 'up')
								{
									$sql = sprintf($sql, ($fdata['position']-1), $fdata['parent_id']);
								}
								else
								{
									$sql = sprintf($sql, ($fdata['position']+1), $fdata['parent_id']);
								}

								$db->sql_query($sql);
								$db->sql_data($data, true);

								if (!empty($data))
								{
									/* there is a forum above or below (as appropriate) this one, we can swap them around */

									$sql = 'UPDATE forums SET
										position = %d
										WHERE id = %d';

									$sql_1 = sprintf($sql, $fdata['position'], $data['id']);

									if ($action == 'up')
									{
										$sql_2 = sprintf($sql, $fdata['position']-1, $f);
									}
									else
									{
										$sql_2 = sprintf($sql, $fdata['position']+1, $f);
									}

									$db->sql_query($sql_1);
									$db->sql_query($sql_2);
								}

								redirect('http://' . $config['domain_name'] . $config['install_path'] . str_replace('&amp;', '&', forums::furl('admin', 'manage', $fdata['parent_id'])));

								break;

							case 'sync':

								$forums->resync_forum_post_count($f);

								redirect('http://' . $config['domain_name'] . $config['install_path'] . str_replace('&amp;', '&', forums::furl('admin', 'manage', $fdata['parent_id'])));

								break;
						}

						return;
					}

					$location = array(
						'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
						'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
						'<a href="' . $config['install_path'] . forums::furl('admin') . '">Administration Panel</a>',
						'<a href="' . $config['install_path'] . forums::furl('admin', 'manage') . '">Manage Forums</a>'
					);

					echo '<p>Here you can reorder forums, edit forum titles and/or descriptions, and synchronise
						post counts if they are incorrect.</p>';

					$parent = 0;

					if (!empty($_GET['f']))
					{
						$parent = $_GET['f'];
					}

					if ($parent)
					{
						$parentdata = $forums->forum_get_data($parent);

						$title = 'Manage: ' . $parentdata['title'];
					}
					else
					{
						$title = 'Manage Forum Index';
					}

					$a_forum = $forums->get_forum_list($parent);

					echo '<table cellspacing="0" cellpadding="0" class="forum" width="100%">';
					echo '<tr><th width="50%">Forum Title</th><th>Post Count</th><th colspan="4">Options</th></tr>';

					foreach ($a_forum as $forum)
					{
						$children = $forums->get_forum_list($forum['id']);

						if (!empty($children))
						{
							$forumtitle = '<b>' . $forum['title'] . '</b><span style="font-size: smaller;"> (<a href="' . $config['install_path'] . forums::furl('admin', 'manage', $forum['id']) . '">view child forums</a>)</span>';
						}
						else
						{
							$forumtitle = '<b>' . $forum['title'] . '</b>';
						}

						printf('<tr><td>%s<br /><span class="smaller">%s</span></td><td class="center smaller">%d</td><td class="center smaller"><a href="%s">Edit</a></td><td class="center smaller"><a href="%s">Delete</a></td><td class="center smaller"><a href="%s">Move Up</a><br /><a href="%s">Move Down</a></td><td class="center smaller"><a href="%s">Sync</a></td></tr>',
							$forumtitle,
							$forum['description'],
							$forum['posts'],
							$config['install_path'] . forums::furl('admin', 'edit', $forum['id']),
							$config['install_path'] . forums::furl('admin', 'delete', $forum['id']),
							$config['install_path'] . forums::furl('admin', 'manage', $forum['id'], 'up'),
							$config['install_path'] . forums::furl('admin', 'manage', $forum['id'], 'down'),
							$config['install_path'] . forums::furl('admin', 'manage', $forum['id'], 'sync')
						);
					}

					echo '</table>';

					break;

				case 'create':
				case 'edit':

					if ($sub == 'create')
					{
						$title = 'Create Forum';
						$flag = F_FORUM_CREATE;

						$cat_name = $description = $unix_name = '';
						$parent = 0;
						$button = 'Create';
					}
					else
					{
						$flag = F_FORUM_EDIT;

						$f = $_GET['f'];

						$fdata = forums::forum_get_data($f);

						$title = 'Edit Forum: ' . $fdata['title'];

						$cat_name = $fdata['title'];
						$description = $fdata['description'];
						$unix_name = unixify($fdata['unix_title']);
						$parent = $fdata['parent_id'];
						$button = 'Edit';
					}

					if (!permission::has_flag('forums', $flag))
					{
						redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin'));
					}

					$location = array(
						'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
						'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
						'<a href="' . $config['install_path'] . forums::furl('admin') . '">Administration Panel</a>'
					);

					$cat_name = (!empty($_POST['cat_name']) ? $_POST['cat_name'] : $cat_name);
					$description = (!empty($_POST['description']) ? $_POST['description'] : $description);
					$unix_name = (!empty($_POST['unix_title']) ? unixify($_POST['unix_title']) : ($unix_name ? $unix_name : unixify($cat_name)));
					$parent = (!empty($_POST['parent']) ? $_POST['parent'] : $parent);

					if (isset($_POST['submit']))
					{
						if ($sub == 'create')
						{
							$f = $forums->add_category($cat_name, $description, $unix_name);
							$forums->create_as_forum($f, $parent);

							$permissions = new permission('forums', $f);
							$permissions->updatedef('forums', $f, $cat_name . ' Permissions', 0);

							$word = 'created';
						}
						else
						{
							$forums->edit_category($f, $cat_name, $description, $unix_name);

							if ($fdata['parent_id'] != $parent)
							{
								$sql = 'UPDATE forums SET
									position = position - 1
									WHERE position > %d
									AND parent_id = %d';

								$sql = sprintf($sql, $fdata['position'], $fdata['parent_id']);

								$db->sql_query($sql);

								$sql = 'SELECT f.position
									FROM forums f
									WHERE f.parent_id = %d
									ORDER BY f.position DESC
									LIMIT 1';

								$sql = sprintf($sql, $parent);

								$db->sql_query($sql);
								$db->sql_data($data, true);

								if (!empty($data))
								{
									$newpos = $data['position'] + 1;
								}
								else
								{
									$newpos = 1;
								}
							}
							else
							{
								$newpos = $fdata['position'];
							}

							$sql = 'UPDATE forums SET
								parent_id = %d,
								position = %d
								WHERE id = %d';

							$sql = sprintf($sql, $parent, $newpos, $f);

							$db->sql_query($sql);

							$word = 'edited';
							$id = $f;
						}

						echo '<p>The forum <a href="' . $config['install_path'] . forums::furl('viewforum', $f) . '">' . $cat_name . '</a> was ' . $word . ' successfully. You may want to <a href="' . $config['install_path'] . forums::furl('admin', 'permissions', $f) . '">edit the forum\'s permissions</a>.</p>';
					}
					else
					{
?>
<form action="<?php echo $config['install_path'] . ($sub == 'create' ? forums::furl('admin', 'create') : forums::furl('admin', 'edit', $f)); ?>" method="post">
	<table class="forum">
	<tr>
		<td align="right" valign="top">Forum Name:<br /><span class="smaller">the name of the forum.</span></td>
		<td valign="top"><input style="width:200px" type="text" name="cat_name" value="<?php echo $cat_name; ?>" /></td>
	</tr>
	<tr>
		<td align="right" valign="top">Description:<br /><span class="smaller">a short description of the forum.</span></td>
		<td valign="top"><textarea name="description" style="width:300px; height: 70px;"><?php echo $description; ?></textarea></td>
	</tr>
	<tr>
		<td align="right" valign="top">Parent:<br /><span class="smaller">the forum this will appear under.</span></td>
		<td valign="top"><select name="parent"><option value="0">No Parent</option><?php echo $forums->forum_dropdown($parent); ?></select></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $button; ?>" /></td>
	</tr>
	</table>
</form>
<?php
					}

					break;

				case 'report_categories':

					if (!permission::has_flag('forums', F_GLOBAL_CONFIG))
					{
					        redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin'));
					}

					if (!empty($_GET['action']))
					{
						$action = $_GET['action'];

						switch ($action)
						{
							case 'add':

								if (!empty($_POST['cat_title']))
								{
									$sql = 'SELECT rc.id
										FROM report_categories rc
										ORDER BY rc.id DESC
										LIMIT 1';

									$db->sql_query($sql);
									$db->sql_data($data, true);

									$id = @implode($data) + 1;

									$sql = 'INSERT INTO report_categories (
										id, title
										) VALUES (
										%d, "%s"
										)';

									$sql = sprintf($sql, $id, $_POST['cat_title']);

									$db->sql_query($sql);
								}

								redirect($config['install_path'] . forums::furl('admin', 'report_categories'));

								break;

							case 'edit':

								if (!empty($_GET['rc']))
								{
									$rc = $_GET['rc'];
								}
								else
								{
									redirect($config['install_path'] . forums::furl('admin', 'report_categories'));
								}

								if (!empty($_POST['cat_title']))
								{
									$sql = 'UPDATE report_categories
										SET title = "%s"
										WHERE id = %d';

									$sql = sprintf($sql, $_POST['cat_title'], $rc);

									$db->sql_query($sql);

									redirect($config['install_path'] . forums::furl('admin', 'report_categories'));
								}

								$location = array(
									'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
									'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
									'<a href="' . $config['install_path'] . forums::furl('admin') . '">Administration Panel</a>',
									'<a href="' . $config['install_path'] . forums::furl('admin', 'report_categories') . '">Manage Report Categories</a>'
								);

								$sql = 'SELECT title
									FROM report_categories
									WHERE id = %d';

								$sql = sprintf($sql, $rc);

								$db->sql_query($sql);
								$db->sql_data($data, true);

								$title = 'Edit Report Category: ' . $data['title'];

								echo '<p>Enter the new title for this report category.</p>';

								echo '<form method="post" action="' . $config['install_path'] .  forums::furl('admin', 'report_categories', 'edit', $rc) . '"><input type="text" name="cat_title" style="width: 300px" value="' . $data['title'] . '"/><input type="submit" value="Edit" /></form>';

								break;

							case 'del':

								if (!empty($_GET['rc']))
								{
									$rc = $_GET['rc'];
								}
								else
								{
									redirect($config['install_path'] . forums::furl('admin', 'report_categories'));
								}

								$sql = 'SELECT r.id, r.title
									FROM report_categories r
									WHERE id <> %d';

								$sql = sprintf($sql, $rc);

								$db->sql_query($sql);
								$db->sql_data($othercats);

								if (!count($othercats))
								{
									/* cannot delete the last category */

									redirect($config['install_path'] . forums::furl('admin', 'report_categories'));
								}

								if (!empty($_POST['del']))
								{
									$sql = 'DELETE FROM report_categories
										WHERE id = %d';

									$sql = sprintf($sql, $rc);

									$db->sql_query($sql);

									$sql = 'UPDATE reports
										SET report_category = %d
										WHERE report_category = %d';

									$sql = sprintf($sql, $_POST['new_cat'], $rc);

									$db->sql_query($sql);

									redirect($config['install_path'] . forums::furl('admin', 'report_categories'));
								}

								$location = array(
									'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
									'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
									'<a href="' . $config['install_path'] . forums::furl('admin') . '">Administration Panel</a>',
									'<a href="' . $config['install_path'] . forums::furl('admin', 'report_categories') . '">Manage Report Categories</a>'
								);

								$sql = 'SELECT title
									FROM report_categories
									WHERE id = %d';

								$sql = sprintf($sql, $rc);

								$db->sql_query($sql);
								$db->sql_data($data, true);

								$title = 'Delete Report Category: ' . $data['title'];

								echo '<p>Please select another category you wish to move any reports in this category into; and confirm your decision.</p>';

								echo '<form method="post" action="' . $config['install_path'] . forums::furl('admin', 'report_categories', 'del', $rc) . '"><select name="new_cat">';

								foreach ($othercats as $rc)
								{
									printf('<option value="%d">%s</option>', $rc['id'], $rc['title']);
								}

								echo '</select><input type="submit" name="del" value="Delete" /></form>';

								break;

							default:

								redirect($config['install_path'] . forums::furl('admin', 'report_categories'));

								break;
						}
					}
					else
					{
						$title = 'Manage Report Categories';
						$location = array(
							'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
							'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
							'<a href="' . $config['install_path'] . forums::furl('admin') . '">Administration Panel</a>'
						);

						$sql = 'SELECT rc.id, rc.title
							FROM report_categories rc
							ORDER BY rc.title ASC';

						$db->sql_query($sql);
						$db->sql_data($data);

						echo '<p>Categories are listed alphabetically. To make a category always appear at the top of the listing, insert a space before the text.</p>';

						echo '<table class="forum" width="100%" cellspacing="0" cellpadding="0">';
						echo '<tr><th width="80%">Title</th><th colspan="2">Options</th></tr>';

						foreach ($data as $key => $value)
						{
							printf('<tr><td class="smaller %s">%s</td><td style="text-align: center" class="smaller %s"><a href="%s">Edit</a></td><td style="text-align: center" class="smaller %s">%s</td></tr>',
								($key % 2 ? 'even' : 'odd'),
								$value['title'],
								($key % 2 ? 'even' : 'odd'),
								$config['install_path'] . forums::furl('admin', 'report_categories', 'edit', $value['id']),
								($key % 2 ? 'even' : 'odd'),
								(count($data)-1) ? '<a href="' . $config['install_path'] . forums::furl('admin', 'report_categories', 'del', $value['id']) . '">Delete</a>' : '<span style="color: #777;">Cannot delete</span>'
							);
						}

						echo '</table>';

						echo '<form method="post" action="' . $config['install_path'] . forums::furl('admin', 'report_categories', 'add') .'"><input type="text" style="width: 300px" name="cat_title"> <input type="submit" name="add" value="Add new category" /></form>';
					}

					break;

				case 'config':

					if (!permission::has_flag('forums', F_GLOBAL_CONFIG))
					{
						redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin'));
					}

					$title = 'General Configuration';
					$location = array(
						'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
						'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>',
						'<a href="' . $config['install_path'] . forums::furl('admin') . '">Administration Panel</a>'
					);

					if (!empty($_POST))
					{
						$sf = $_POST['stats_forums'];

						$str_sf = implode(',', $sf);

						if (!$str_sf)
						{
							$str_sf = '0';
						}

						update_config(array(
							array('site_name',		$_POST['site_name']),
							array('site_desc',		$_POST['site_desc']),
							array('contact_name',		$_POST['contact_name']),
							array('domain_name',		$_POST['domain_name']),
							array('cookie_domain',		$_POST['cookie_domain']),
							array('install_path',		$_POST['install_path']),
							array('contact_email',		$_POST['contact_email']),
							array('cookie_path',		$_POST['cookie_path']),
							array('guest_sessions',		(!empty($_POST['guest_sessions']) ? '1' : '0')),
							array('email_signature',	$_POST['email_signature']),
							array('site_img',		$_POST['site_img']),
							array('force_preview',		(!empty($_POST['force_preview']) ? '1' : '0')),
							array('stats_forums',		$str_sf)
							));

						redirect('http://' . $_POST['domain_name'] . $_POST['install_path'] . forums::furl('admin', 'config'));
					}
					else
					{
						foreach ($config as $name => $value)
						{
							$uconfig[$name] = htmlentities($value);
						}

						$sf = explode(',', $config['stats_forums']);

						$rec_install_path = explode('/', $_SERVER['REQUEST_URI']);

						if (REWRITE)
						{
							$rec_install_path = array_splice($rec_install_path, 0, -2);
						}
						else
						{
							$rec_install_path = array_splice($rec_install_path, 0, -1);
						}

						$rec_install_path = implode('/', $rec_install_path) . '/';

						?>
	<form method="post" action="<?php echo $config['install_path'] . forums::furl('admin', 'config'); ?>">
		<table class="forum">
		<tr>
			<td align="right" valign="top">Site Name:</td>
			<td valign="top"><input style="width: 300px;" type="text" name="site_name" value="<?php echo $uconfig['site_name']; ?>" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Site Description:</td>
			<td valign="top"><input style="width: 300px;" type="text" name="site_desc" value="<?php echo $uconfig['site_desc']; ?>" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Site Image:</td>
			<td valign="top"><input style="width: 300px;" type="text" name="site_img" value="<?php echo $uconfig['site_img']; ?>" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Contact Name:</td>
			<td valign="top"><input style="width: 300px;" type="text" name="contact_name" value="<?php echo $uconfig['contact_name']; ?>" /></td>
		</tr>
		<tr>
		        <td align="right" valign="top">Contact Email:</td>
			<td valign="top"><input style="width: 300px;" type="text" name="contact_email" value="<?php echo $uconfig['contact_email']; ?>" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Email Signature:</td>
			<td valign="top"><textarea name="email_signature" style="width:300px; height: 60px;"><?php echo $uconfig['email_signature']; ?></textarea></td>
		</tr>
		<tr>
		        <td align="right" valign="top">Domain Name:<br /><span class="smaller">Recommmended Value: <code><?php echo $_SERVER['HTTP_HOST']; ?></code></span></td>
			<td valign="top"><input style="width: 300px;" type="text" name="domain_name" value="<?php echo $uconfig['domain_name']; ?>" /></td>
		</tr>
		<tr>
		        <td align="right" valign="top">Install Path:<br /><span class="smaller">Recommmended Value: <code><?php echo $rec_install_path; ?></code></span></td>
			<td valign="top"><input style="width: 300px;" type="text" name="install_path" value="<?php echo $uconfig['install_path']; ?>" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Cookie Domain:</td>
			<td valign="top"><input style="width: 300px;" type="text" name="cookie_domain" value="<?php echo $uconfig['cookie_domain']; ?>" /></td>
		</tr>
		<tr>
		        <td align="right" valign="top">Cookie Path:</td>
			<td valign="top"><input style="width: 300px;" type="text" name="cookie_path" value="<?php echo $uconfig['cookie_path']; ?>" /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Guest Sessions:</td>
			<td valign="top"><input type="checkbox" name="guest_sessions" <?php echo ($uconfig['guest_sessions'] ? 'checked="checked"' : ''); ?> /></td>
		</tr>
		<tr>
			<td align="right" valign="top">Require Preview:<span class="smaller"><br />If this checkbox is enabled, people must preview their posts before submitting.</span></td>
			<td valign="top"><input type="checkbox" name="force_preview" <?php echo ($uconfig['force_preview'] ? 'checked="checked"' : ''); ?> /></td>
		</tr>
		<tr>
			<td align="right" valign="top">RSS/Statistics:<span class="smaller"><br />The forums used to generate the global RSS feed and the latest posts listing.</span></td>
			<td valign="top"><select name="stats_forums[]" multiple="multiple" size="6"><?php echo $forums->forum_dropdown(explode(',', $uconfig['stats_forums'])); ?></select></td>
		</tr>
		<tr>
			<td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td>
		</tr>
		<tr>
			<td colspan="2"><p class="smaller">Submitting your changes will update the database immediately. If you have changed the cookie settings, you may be automatically signed out. If you have set these incorrectly, you will not be able to sign in again until you correct them manually in the database.</p></td>
		</tr>
		<tr>
		        <td colspan="2" style="background-color: #ddb; padding: 0; margin: 0"><p style="font-size: 1px;">&nbsp;</p></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="Submit" /></td>
		</tr>
		</table>
	</form>
<?php
					}

					break;

				default:

					redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl('admin'));
			}

			break;
		}


		$title = 'Administration Panel';
		$location = array(
			'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
			'<a href="' . $config['install_path'] . forums::furl() . '">Forums</a>'
		);

		$flags = permission::get_flags('forums');

		$av = 0;
		$as = '';

		if ($flags & F_FORUM_CREATE)
		{
			$as .= '<li><a href="' . $config['install_path'] . forums::furl('admin', 'create') . '">Create Forum</a></li>';
			$av++;
		}

		if ($flags & F_FORUM_EDIT)
		{
			$as .= '<li><a href="' . $config['install_path'] . forums::furl('admin', 'manage') . '">Manage Forums</a></li>';
			$av++;

			$as .= '<li><a href="' . $config['install_path'] . forums::furl('admin', 'permissions') . '">Forum Permissions</a></li>';
			$av++;
		}

		if ($flags & F_GLOBAL_CONFIG)
		{
			$as .= '<li><a href="' . $config['install_path'] . forums::furl('admin', 'config') . '">General Configuration</a></li>';
			$av++;

			$as .= '<li><a href="' . $config['install_path'] . forums::furl('admin', 'report_categories') . '">Manage Report Categories</a></li>';
			$av++;
		}

		if ($av)
		{
			echo '<ul>';
			echo $as;
			echo '</ul>';
		}
		else
		{
			redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl());
		}

		break;

	default:

		$title = 'Forums';
		$location = array(
			'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>'
		);

		$head[] = sprintf('<link rel="alternate" type="application/rss+xml" title="All Forums Feed (RSS 2.0)" href="http://%s" />',
			$config['domain_name'] . $config['install_path'] . 'rss.php'
		);

		if (false === ($forum_str = $forums->display_forums()))
		{
			echo '<table width="100%" class="forum" cellspacing="0" cellpadding="0"><tr class="forum-top"><td>No forums exist.</td></tr></table>';
		}
		else
		{
			echo $forum_str;
		}

		$opts = array();

		if ($session->logged_in)
		{
			$opts[] = array('Mark All Forums Read', $config['install_path'] . forums::furl('markread'));
		}

		$opts[] = array('Search Forums', $config['install_path'] . 'search.php');
		$opts[] = array('RSS Feed', $config['install_path'] . 'rss.php');

		$flags = permission::get_flags('forums');

		if (($flags & F_FORUM_CREATE) || ($flags & F_FORUM_EDIT) || ($flags & F_FORUM_DELETE) || ($flags & F_GLOBAL_CONFIG))
		{
			$opts[] = array('Administration Panel', $config['install_path'] . forums::furl('admin'));
		}

		if (!empty($opts))
		{
			echo '<p style="font-size: smaller; text-align: center; padding: 10px;">';

			$count_opts = count($opts);

			for ($i = 0; $i < $count_opts; $i++)
			{
				echo '<a href="'  . $opts[$i][1] . '">' . $opts[$i][0] . '</a>';

				if (!empty($opts[$i+1]))
				{
					echo ' | ';
				}
			}

			echo '</p>';
		}

		break;
}

echo $display->footer();
$display->output();

?>
