<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

class permission
{
	var $id;
	var $sub_id;
	var $u_id;
	var $name;

	var $data;

	function permission($id = 0, $sub_id = 0, $u_id = 0)
	{
		$this->__construct($id, $sub_id, $u_id);
	}

	function __construct($id = 0, $sub_id = 0, $u_id = 0)
	{
		if (!is_numeric($id))
		{
			$this->name = $id;
			$this->id = false;
		}
		else
		{
			$this->id = $id;
		}

		global $session;

		$this->sub_id = $sub_id;
		$this->u_id = ($u_id ? $u_id : $session->user_id);

		if ($id)
		{
			$this->load();
		}
	}

	function load()
	{
		global $db;

		if ($this->id)
		{
			$id_sql = sprintf('p.id = %d', $this->id);
		}
		else
		{
			$id_sql = sprintf('p.name = "%s"', $this->name);
		}

		$sql = 'SELECT p.*
			FROM permissions p
			WHERE %s
			AND p.sub_id = %d
			LIMIT 1';

		$sql = sprintf($sql, $id_sql, $this->sub_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			$sql = 'SELECT p.*
				FROM permissions p
				WHERE %s
				AND p.sub_id = 0
				LIMIT 1';

			$sql = sprintf($sql, $id_sql);

			$db->sql_query($sql);
			$db->sql_data($data, true);
		}

		$this->data = $data;
		$this->id = $data['id'];

		$sql = 'SELECT up.flags
			FROM user_permission up
			WHERE up.p_id = %d
			AND up.sub_id = %d
			AND up.u_id = %d';

		$sql = sprintf($sql, $this->id, $this->sub_id, $this->u_id);

		$db->sql_query($sql);
		$db->sql_data($up, true);

		if (!empty($up))
		{
			$this->data['flags'] = $up['flags'];
		}
		else
		{
			$this->data['flags'] = $this->data['default_flags'];
		}
	}

	function update($new_flags = false)
	{
		if (false === $new_flags)
		{
			$new_flags = $this->data['flags'];
		}

		global $db;

		$sql = 'SELECT 1
			FROM user_permission up
			WHERE up.p_id = %d
			AND sub_id = %d
			AND u_id = %d';

		$sql = sprintf($sql, $this->id, $this->sub_id, $this->u_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (!empty($data))
		{
			$sql = 'UPDATE user_permission
				SET flags = %d
				WHERE p_id = %d
				AND sub_id = %d
				AND u_id = %d';

			$sql = sprintf($sql, $new_flags, $this->id, $this->sub_id, $this->u_id);

			$db->sql_query($sql);
		}
		else
		{
			$this->insert($new_flags);
		}
	}

	function insert($new_flags = false)
	{
		if (false === $new_flags)
		{
			$new_flags = $this->data['flags'];
		}

		global $db;

		$sql = 'INSERT INTO user_permission (
			p_id, sub_id, u_id, flags
			) VALUES (
			%d, %d, %d, %d
			)';

		$sql = sprintf($sql, $this->id, $this->sub_id, $this->u_id, $new_flags);

		$db->sql_query($sql);
	}

	function delete()
	{
		global $db;

		$sql = 'DELETE FROM user_permission
			WHERE p_id = %d
			AND sub_id = %d
			AND u_id = %d';

		$sql = sprintf($sql, $this->id, $this->sub_id, $this->u_id);

		$db->sql_query($sql);
	}

	function insertdef($name, $sub_id, $description, $flags)
	{
		global $db;

		$sql = 'INSERT INTO permissions (
			id, name, sub_id, description, default_flags
			) VALUES (
			%d, "%s", %d, "%s", %d
			)';

		$sql = sprintf($sql, $this->_id($name), $name, $sub_id, $description, $flags);

		$db->sql_query($sql);
	}

	function updatedef($name, $sub_id, $description, $flags)
	{
		global $db;

		$sql = 'SELECT p.*
			FROM permissions p
			WHERE p.id = %d
			AND p.sub_id = %d
			LIMIT 1';

		$sql = sprintf($sql, $this->_id($name), $sub_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			$this->insertdef($name, $sub_id, $description, $flags);
			return;
		}

		$sql = 'UPDATE permissions SET
			description = "%s",
			default_flags = %s
			WHERE name = "%s"
			AND sub_id = %d';

		$sql = sprintf($sql, $description, $flags, $name, $sub_id);

		$db->sql_query($sql);
	}

	function has_flag($name, $flag, $sub_id = 0, $u_id = 0)
	{
		$permission = new permission($name, $sub_id, $u_id);

		return ($permission->data['flags'] & $flag);
	}

	function get_flags($name, $sub_id = 0, $u_id = 0)
	{
		$permission = new permission($name, $sub_id, $u_id);

		return $permission->data['flags'];
	}

	function get_default_flags($name, $sub_id = 0, $u_id = 0)
	{
		$permission = new permission($name, $sub_id, $u_id);

		return $permission->data['default_flags'];
	}

	function _id($name)
	{
		global $db;

		$sql = 'SELECT p.id
			FROM permissions p
			WHERE p.name = "%s"
			AND p.sub_id = 0';

		$sql = sprintf($sql, $name);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			return false;
		}

		return $data['id'];
	}
}

?>
