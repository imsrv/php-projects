<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

class session
{
	var $session_id;

	var $logged_in = 0;
	var $user_id;
	var $userdata = array();

	var $method;

	var $ip;
	var $hostname;
	var $browser;
	var $page;

	function session()
	{
		if (isset($_GET['cookietest']))
		{
			if (empty($_COOKIE['sessionid']))
			{
				/* cookie not accepted */

				$this->_end();

				global $title, $location, $config;

				$display = new display();

				echo $display->header();

				$title = 'Cookies Disabled';

				$location[] = '<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>';

				echo '<p>Your browser rejected a cookie set by the forums. aterr does not support signing in without accepting cookies, as it is a potential security risk. If you wish to sign in, please enable cookies in your browser.</p>';

				echo $display->footer();
				$display->output();

				die();
			}
			else
			{
				redirect('http://' . substr($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 0, -11));
			}
		}

		if (!empty($_COOKIE['sessionid']))
		{
			$this->method = 'cookie';
		}
		else
		{
			$this->method = 'ip';
		}

		$this->_init();
	}

	function _init()
	{
		global $db;

		$this->browser = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'No USER_AGENT sent.';

		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->hostname = gethostbyname($this->ip);

		$this->page = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		if ($this->method == 'cookie')
		{
			$this->session_id = $_COOKIE['sessionid'];

			$sql = 'SELECT s.*, u.*
				FROM sessions s, users u
				WHERE s.id = "%s"
				AND s.u_id = u.user_id';

			$sql = sprintf($sql, $this->session_id);

			$db->sql_query($sql);
			$db->sql_data($data, true);

			if (empty($data))
			{
				$this->_end();
				$this->_create();
			}

			$this->userdata = $data;

			$this->user_id = $this->userdata['user_id'];
			$this->logged_in = true;

			$this->set_cookie('sessionid', $this->session_id);
		}
		else /* if ($this->method == 'ip') */
		{
			$sql = 'SELECT s.*
				FROM sessions s
				WHERE s.ip = "%s"
				AND s.method = "ip"
				LIMIT 1';

			$sql = sprintf($sql, $this->ip);

			$db->sql_query($sql);
			$db->sql_data($data, true);

			if (empty($data))
			{
				$this->_create();
			}

			$this->session_id = $data['id'];

			$this->userdata = $data;
		}

		$sql = 'UPDATE sessions SET
			time_last = %d,
			page = "%s"
			WHERE id = "%s"';

		$sql = sprintf($sql, time(), $this->page, $this->session_id);

		$db->sql_query($sql);

	}

	function _create()
	{
		global $db;

		$this->_gc();
		$this->_end();

		$this->session_id = md5(uniqid(rand(), 1));
		$time = time();

		$sql = 'INSERT INTO sessions (
			id, ip, method, time_start, time_last, browser, page
			) VALUES (
			"%s", "%s", "%s", %d, %d, "%s", "%s"
			)';

		$sql = sprintf($sql, $this->session_id, $this->ip, $this->method, $time, $time, $this->browser, $this->page);

		$db->sql_query($sql);

		redirect('http://' . $this->page);
	}

	function _end()
	{
		global $db;

		$sql = 'DELETE FROM sessions
			WHERE id = "%s"';

		$sql = sprintf($sql, $this->session_id);

		$db->sql_query($sql);

		$this->delete_cookie('sessionid');
	}

	function _gc()
	{
		/* delete all sessions where a new page has not been requested in the past 2 hours */

		global $db;

		$sql = 'DELETE FROM sessions
			WHERE time_last < %d';

		$sql = sprintf($sql, (time() - 7200));

		$db->sql_query($sql);
	}

	function set_cookie($name, $value, $permanent = false)
	{
		global $config;

		$duration = ($permanent ? time() + 60*60*24*365*10 : 0);

		setcookie($name, $value, $duration, $config['cookie_path'], $config['cookie_domain']);
	}

	function delete_cookie($name)
	{
		$this->set_cookie($name, '');
	}

	function signin($u_id)
	{
		global $db;

		$this->set_cookie('sessionid', $this->session_id);

		$sql = 'UPDATE sessions
			SET method = "cookie",
			u_id = %d
			WHERE id = "%s"';

		$sql = sprintf($sql, $u_id, $this->session_id);

		$db->sql_query($sql);

		$redir_to = 'http://' . $this->page;

		if (strpos($redir_to, '?'))
		{
			$redir_to .= '&';
		}
		else
		{
			$redir_to .= '?';
		}

		redirect($redir_to . 'cookietest');
	}

	function signout()
	{
		$this->_gc();
		$this->_end();
	}
}

?>
