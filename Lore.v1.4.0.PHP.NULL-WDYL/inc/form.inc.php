<?php
/*
+-------------------------------------------------------------------------
| Lore
| (c)2003-2004 Pineapple Technologies
| http://www.pineappletechnologies.com
| ------------------------------------------------------------------------
| This code is the proprietary product of Pineapple Technologies and is
| protected by international copyright and intellectual property laws.
| ------------------------------------------------------------------------
| Your usage of this software is bound by the agreement set forth in the
| software license that was packaged with this software as LICENSE.txt.
| A copy of this license agreement can be located at
| http://www.pineappletechnologies.com/products/lore/license.php
| By installing and/or using this software you agree to the terms
| stated in the license.
| ------------------------------------------------------------------------
| You may modify the code below at your own risk. However, the software
| cannot be redistributed, whether altered or not altered, in whole or in
| part, in any way, shape, or form.
+-------------------------------------------------------------------------
| Software Version: 1.4.0
+-------------------------------------------------------------------------
*/

class form_smarty extends form
{
	/**
	* Reference to Smarty template objecs
	* @var object reference
	*/
	var $te;
	
	/**
	* Template to use to display form
	* @var string
	*/
	var $template;

	function display()
	{
		$this->te->assign( $this->get_form_definition() );
		$this->te->display_nocache( $this->template );
	}
	
	function display_as_readonly()
	{
		$this->readonly = true;
		$this->display();
		$this->readonly = false;
	}
}
	
//////////////////////////////////////////////////////////////
/**
 * Form handler class handles common forms
 */
//////////////////////////////////////////////////////////////

class form_handler extends form_smarty
{
	var $form_new_name;		// form name when adding new row
	var $form_edit_name;		// form name when editing existing row

	var $database_table;		// database table we're working with

	var $row_name;			// human-readable name of database row
					// (i.e. table my_widgets with
					// $row_name = 'widget')

	var $unique_field	= 'name';

	var $db;
}

//////////////////////////////////////////////////////////////
/**
 * Basic single database table form handler
 * @package form
 */
//////////////////////////////////////////////////////////////
class form_db_single_table extends form_handler
{

	//////////////////////////////////////////////////////////////
	/**
	* Handles adding a new row to the database via a form
	*/
	//////////////////////////////////////////////////////////////
	function handle_new()
	{
		$this->set_property('name', $this->form_new_name);

		if( $this->submitted() )
		{
			$this->validate();
			if( $this->unique_field !== false )
			{
				if( $this->db->value_exists( $this->get_field_value($this->unique_field), $this->unique_field, $this->database_table) )
				{
					$this->trigger_field_error($this->unique_field, "That $this->unique_field is already in use, please choose another.");
				}
			}

			if( $this->has_errors() )
			{
				$this->display();
			}
			else
			{
				$this->db->insert_from_array($this->get_field_values(), $this->database_table);

				$this->te->assign('message', "Created $this->row_name");
				$this->te->display('cp_message.tpl');
				$this->display_as_readonly();
			}
		} // end if
		else
		{
			$this->display();
		}

	}

	//////////////////////////////////////////////////////////////
	/**
	* Handles editing of existing database row
	*/
	//////////////////////////////////////////////////////////////
	function handle_edit()
	{
		$this->set_property('name', $this->form_edit_name);
		$id = $this->get_field_value('id');

		if( !$this->db->id_exists($id, $this->database_table) )
		{
			$this->te->assign('message', "Invalid $this->row_name specified.");
			$this->te->display('cp_message.tpl');
		}
		else
		{
			if( $this->submitted() )
			{
				$this->validate();
				if( $this->unique_field !== false )
				{
					if( $this->db->query_one_result("SELECT COUNT(*) FROM $this->database_table WHERE $this->unique_field = '" . $this->get_field_value($this->unique_field) . "' AND id != '" . $this->get_field_value('id') . "'") )
					{
						$this->trigger_field_error($this->unique_field, "That $this->unique_field is already in use, please choose another.");
					}
				}
				if( $this->has_errors() )
				{
					$this->display();
				} 
				else 
				{
					$this->db->update_from_array($this->get_field_values(), $this->database_table, $id);
					$this->te->assign('message', "Modified $this->row_name");
					$this->te->display('cp_message.tpl');
					$this->display_as_readonly();
				}
			}
			else
			{			
				$this->set_field_properties('id', array('current_value' => $id));
				$this->populate_from_array($this->db->query_one_row("SELECT * FROM $this->database_table WHERE id = '$id'"));
				$this->display();
			}

		} // end else

	} // end function

} // end class

//////////////////////////////////////////////////////////////////////////////
/**
 * Multiple table form handler
 * @package form
 */
//////////////////////////////////////////////////////////////////////////////

class form_db_multi_table extends form_handler
{
	/**
	* List of fields where each value is inserted
	* into a table which has a foreign key to the main
	* table this form is handling
	* @var array
	*/
	var $fk_fields = array();

	//////////////////////////////////////////////////////////////
	/**
	* Handles adding a new row to the database via a form
	*/
	//////////////////////////////////////////////////////////////
	function handle_new()
	{
		$this->set_property('name', $this->form_new_name);

		if( $this->submitted() )
		{
			$this->validate();
			if( $this->unique_field !== false )
			{
				if( $this->db->value_exists( $this->get_field_value($this->unique_field), $this->unique_field, $this->database_table) )
				{
					$this->trigger_field_error($this->unique_field, "That $this->unique_field is already in use, please choose another.");
				}
			}
			if( $this->has_errors() )
			{
				$this->display();
			}
			else
			{
				$id = $this->db->insert_from_array($this->get_field_values(), $this->database_table);
				$this->set_field_properties('id', array('current_value' => $id));
				$this->_update_fk_fields();
				$this->te->assign('status_message', "Created $this->row_name");
				$this->te->display('cp_status_message.tpl');
				$this->display_as_readonly();
			}
		} // end if
		else
		{
			$this->display();
		}

	}

	//////////////////////////////////////////////////////////////
	/**
	* Handles editing of existing database row
	*/
	//////////////////////////////////////////////////////////////
	function handle_edit()
	{
		$this->set_property('name', $this->form_edit_name);
		$id = $this->get_field_value('id');

		if( !$this->db->id_exists($id, $this->database_table) )
		{
			$this->te->assign('status_message', "Invalid $this->row_name specified.");
			$this->te->display('status_message.tpl');
		}
		else
		{
			if( $this->submitted() )
			{
				$this->validate();
				if( $this->unique_field !== false )
				{
					if( $this->db->query_one_result("SELECT COUNT(*) FROM $this->database_table WHERE $this->unique_field = '" . $this->get_field_value($this->unique_field) . "' AND id != '" . $this->get_field_value('id') . "'") )
					{
						$this->trigger_field_error($this->unique_field, "That $this->unique_field is already in use, please choose another.");
					}
				}
				if( $this->has_errors() )
				{
					$this->display();
				} 
				else 
				{
					$this->db->update_from_array($this->get_field_values(), $this->database_table, $id);
					$this->_update_fk_fields();
					$this->te->assign('status_message', "Modified $this->row_name");
					$this->te->display('status_message.tpl');
					$this->display_as_readonly();
				}
			}
			else
			{			
				$this->set_field_properties('id', array('current_value' => $id));
				$this->populate_from_array($this->db->query_one_row("SELECT * FROM $this->database_table WHERE id = '$id'"));
				$this->display();
			}

		} // end else

	} // end function

	//////////////////////////////////////////////////////////////
	/**
	* Set a field in the form as having its data related to
	* multiple rows in another foreign keyed table.
	* @var string $field_id Form field id
	* @var string $fk_field_name Database field name that is a foreign key to the 'id' field in the main table.
	* @var array $other_field_values Constant field values for rows in the foreign keyed table	
	*/
	//////////////////////////////////////////////////////////////
	function set_fk_field( $field_id, $table, $fk_field_name, $other_field_values = array() )
	{
		$this->fk_fields[$field_id] = array(
						'table'			=> $table,
						'fk_field_name'		=> $fk_field_name,
						'other_field_values'	=> $other_field_values
						);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Populates form, overrides parent class method, adds support
	* for populating a field from multiple foreign keyed rows on
	* another table.
	* @var array $array List of field values
	*/
	//////////////////////////////////////////////////////////////
	function populate_from_array( $array = array() )
	{
		foreach( $array AS $field_id => $current_value )
		{
			if( is_object($this->fields[$field_id]) )
			{
				$this->set_field_properties($field_id, array('current_value' => $current_value));
			}
		}

		// data for this field comes from multiple rows
		// on a table with a foreign key to the main table
		foreach( array_keys($this->fk_fields) AS $field_id )
		{
			$query = new select_query();
			$query->add_field( $field_id );
			$query->add_table( $this->fk_fields[$field_id]['table'] );

/*			if( count( $this->fk_fields[$field_id]['other_field_values'] ) )
			{
				foreach( $this->fk_fields[$field_id]['other_field_values'] AS $field_name => $field_value )
				{
					$query->add_where_clause("$field_name = '$field_value'");
				}
			}
*/
			$query->add_where_clause( $this->fk_fields[$field_id]['fk_field_name'] . ' = ' . $this->get_field_value('id'));			
			$value = $this->db->query_all_results( $query->make() );
			
			$this->set_field_properties($field_id, array('current_value' => $value));
		}
	}

	function _update_fk_fields()
	{	
		// on a table with a foreign key to the main table
		foreach( array_keys($this->fk_fields) AS $field_id )
		{
			$this->db->query("DELETE FROM " . $this->fk_fields[$field_id]['table'] . " WHERE " . $this->fk_fields[$field_id]['fk_field_name'] . " = '" . $this->get_field_value('id') . "'");

			// each value for this field is inserted as a separate row
			$fk_field_values = $this->get_field_value( $field_id );
			foreach( $fk_field_values AS $value )
			{
				$db_stuff = $this->fk_fields[$field_id]['other_field_values'];
				$db_stuff[$this->fk_fields[$field_id]['fk_field_name']] = $this->get_field_value('id');
				$db_stuff[$field_id] = $value;
				$this->db->insert_from_array( $db_stuff, $this->fk_fields[$field_id]['table'] );
			}
		}
	}
}

//////////////////////////////////////////////////////////////////////////////
/**
 * Object-oriented HTML form interface
 * @package form
 */
//////////////////////////////////////////////////////////////////////////////
class form
{
	/**
	* ID for form
	*
	* @var string
	*/
	var $id;

	/**
	* @var string
	*/
	var $name;

	/**
	* @var string
	*/
	var $description;

	/**
	* Where the form will submit to
	*
	* @var string
	*/
	var $action;

	/**
	* GET or POST
	*
	* @var string
	*/
	var $method;

	/**
	* Array of field in this form (objects)
	*
	* @var array
	*/
	var $fields		= array();

	/**
	* Array of field groups
	*
	* @var array
	*/
	var $field_groups	= array();

	/**
	* Array defining default properties and constraints for specific field types
	*
	* @var array
	*/
	var $type_defaults	= array();

	/**
	* Array of input variables that came in from the GET or POST
	*
	* @var array
	*/
	var $input_vars		= array();

	/**
	* Whether or not the form is in read-only mode
	*
	* @var bool
	*/
	var $readonly		= false;

	/**
	* Template to use to render the form
	*
	* @var string
	*/
	var $template;

	/**
	* Hidden 'action' field used to tell the script which action to
	* perform when the form is submitted
	*
	* @var string
	*/
	var $submit_action;

	/**
	* Icon
	* @var string
	*/
	var $icon;

	//////////////////////////////////////////////////////////////
	/**
	* Constructor
	*
	* @param string $id
	*/
	//////////////////////////////////////////////////////////////
	function form($id)
	{
		global $HTTP_POST_VARS, $HTTP_POST_FILES;

		$this->id	= $id;
		$this->name	= 'Form';
		$this->action	= $_SERVER['PHP_SELF'];
		$this->method	= 'post';

		$this->input_vars = ( is_array($_POST) ) ? $_POST : $HTTP_POST_VARS;

		if( is_array($_FILES) )
		{
			foreach( $_FILES AS $key => $value )
			{
				if( is_numeric($value) )
				{
					$this->input_vars[$key] = (int)$value;
				}
				else
				{
					$this->input_vars[$key] = $value;
				}		
			}
		}
		else
		{
			foreach( $HTTP_POST_FILES AS $key => $value )
			{
				$this->input_vars[$key] = $value;
			}
		}

		// Submit action field
		$this->submit_action = $_REQUEST['action'];

	} // end constructor

	//////////////////////////////////////////////////////////////
	/**
	* Set form property
	*
	* @param string $key
	* @param string $value
	*/
	//////////////////////////////////////////////////////////////
	function set_property($key, $value)
	{
		$this->{$key} = $value;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Get form property
	* @param string $key
	*/
	//////////////////////////////////////////////////////////////
	function get_property($key)
	{
		return $this->{$key};
	}

	//////////////////////////////////////////////////////////////
	/**
	* Sets the submit action from whatever button was clicked
	*/
	//////////////////////////////////////////////////////////////
	function set_submit_action_from_button()
	{
		if( $this->get_submit_button_id() )
		{
			$this->submit_action	= $this->get_submit_button_id();
			$_REQUEST['action']	= $this->submit_action;
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Sets the submit action from the value of a field
	*
	* @param string $field_id
	*/
	//////////////////////////////////////////////////////////////
	function set_submit_action_from_field($field_id)
	{
		$this->submit_action	= $this->get_field_value($field_id);
		$_REQUEST['action']	= $this->submit_action;

	}

	//////////////////////////////////////////////////////////////
	/**
	* Set multiple form properties
	*
	* @param array $properties list of form properties to set
	*/
	//////////////////////////////////////////////////////////////
	function set_properties($properties)
	{
		foreach( $properties AS $key => $value )
		{
			$this->{$key} = $value;
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns true if form was submitted by "the" submit button
	*/
	//////////////////////////////////////////////////////////////
	function submitted()
	{
		if( $field_id = $this->get_submit_button_id() )
		{
			// was it "the" submit button?
			return ( $this->fields[$field_id]->get_property('submits_form')  ) ? true : false;
		}
		else
		{
			return false;
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns id of submit button that was used to submit the form
	*/
	//////////////////////////////////////////////////////////////
	function get_submit_button_id()
	{
		if( !$this->posted() )
		{
			return false;
		}

		foreach( array_keys($this->fields) AS $field_id )
		{
			if( $this->fields[$field_id]->get_property('is_button') && $this->input_vars[$this->id . '_' . $field_id] )
			{
				return $field_id;
			}
		}
		return NULL;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns true if form was posted (but not necessarily submitted)
	*/
	//////////////////////////////////////////////////////////////
	function posted()
	{
		return ( count($this->input_vars) ) ? true : false;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Add a field group to the form
	*
	* @param string $group Group name
	* @param array $fields List of fields in group
	*/
	//////////////////////////////////////////////////////////////
	function add_field_group($group, $fields)
	{
		$this->field_groups[$group] = $fields;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Populates field values from previously POST'ed form
	*/
	//////////////////////////////////////////////////////////////
	function get_post_input()
	{
		foreach( array_keys($this->fields) AS $field_id )
		{
			$field_var = $this->fields[$field_id]->get_field_var();
			if( $this->input_vars[$field_var] !== NULL )
			{
				$this->fields[$field_id]->set_current_value($this->input_vars[$field_var]);
			}
			else
			{
				$this->fields[$field_id]->set_current_value($this->fields[$field_id]->get_property('default_value'));
			}
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Creates form definition from an associative array
	*
	* @param array $array Form definition array
	*/
	//////////////////////////////////////////////////////////////
	function create_from_array( $array = array() )
	{		
		foreach( $array AS $field_id => $field_info )
		{
			$this->add_field($field_id, $field_info['type'], $field_info['properties']);

			if( count($field_info['constraints']) )
			{
				$this->set_field_constraints($field_id, $field_info['constranits']);
			}

		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Add field to the form
	*
	* @param string $id Field id
	* @param string $type Field type (field class name)
	* @param array $properties Field properties
	*/
	//////////////////////////////////////////////////////////////
	function add_field($id, $type, $properties = array())
	{
		$this->fields[$id]		= new $type($id);
		$this->fields[$id]->form_id	= $this->id;
		$this->fields[$id]->form_obj	=& $this;
		
		// set properties based on defaults first
		if( isset($this->field_type_defaults[$type]) )
		{
			$this->fields[$id]->set_properties($this->field_type_defaults[$type]['properties']);
			$this->fields[$id]->set_constraints($this->field_type_defaults[$type]['constraints']);
		}
		$this->fields[$id]->set_properties($properties);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Delete field from form
	*
	* @param string $id Field id
	*/
	//////////////////////////////////////////////////////////////
	function delete_field($id)
	{
		unset($this->fields[$id]);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Creates duplicate(s) of specified field
	*
	* @param string $field_id Field to duplicate
	8 @param mixed $duplicates Dupliacte field(s) to create
	*/
	//////////////////////////////////////////////////////////////
	function duplicate_field($field_id, $duplicates=array())
	{
		foreach( $duplicates AS $duplicate )
		{
			$this->fields[$duplicate]		= $this->fields[$field_id];
			$this->fields[$duplicate]->field_id	= $duplicate;
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns current value of specified field
	*
	* @param string $field_id
	*/
	//////////////////////////////////////////////////////////////
	function get_field_value($field_id)
	{
		$this->_check_field_exists($field_id);
		return $this->fields[$field_id]->get_current_value();
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns array of values for all fields set to exportable
	*/
	//////////////////////////////////////////////////////////////
	function get_field_values($filter_function=NULL)
	{
		foreach( array_keys($this->fields) AS $field_id )
		{
			// only return if this field should be exported
			if( $this->fields[$field_id]->get_property('export') )
			{
				if( !(!$this->fields[$field_id]->get_property('export_if_null') && $this->fields[$field_id]->get_current_value() == NULL) )
				{
					// only export value if action == show_on_action or show_on_action is null
					if( !$this->fields[$field_id]->get_property('show_on_action') | $this->fields[$field_id]->get_property('show_on_action') == $_REQUEST['action'] )
					{
						if( $this->fields[$field_id]->get_property('export_filter_function') )
						{
							$export_filter_function = $this->fields[$field_id]->get_property('export_filter_function');
							if( is_array($export_filter_function) )
							{					
								$field_values[$field_id] = $export_filter_function[0]->{$export_filter_function[1]}($this->fields[$field_id]->get_current_value());
							}
							else
							{
								$field_values[$field_id] = $export_filter_function($this->fields[$field_id]->get_current_value());
							}
						}
						else
						{
							$field_values[$field_id] = $this->fields[$field_id]->get_current_value();
						}
	
						if( $filter_function )
						{
							$field_values[$field_id] = $filter_function( $field_values[$field_id] );
						}
					}
				}
			}
		}
		return $field_values;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Set default properties for a type of field
	*
	* @param string $type Field type (field class name)
	* @param array $defaults Array of default properties
	*/
	//////////////////////////////////////////////////////////////
	function set_field_type_defaults($type, $properties = array(), $constraints = array())
	{
		$this->field_type_defaults[$type]['properties'] = $properties;
		$this->field_type_defaults[$type]['constraints'] = $constraints;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Displays form
	*/
	//////////////////////////////////////////////////////////////
	function get_form_definition()
	{
		$form = array(
				'name'		=> $this->name,
				'description'	=> $this->description,
				'errors'	=> $this->errors,
				'icon'		=> $this->icon,
				'action'	=> $this->action,
				'submit_action'	=> $this->submit_action,
				'method'	=> $this->method,
				'has_errors'	=> $this->has_errors(),
				'readonly'	=> $this->readonly
				);

		if( count($this->field_groups) )
		{
			foreach( $this->field_groups AS $group_id => $group_fields )
			{
				$groups[$group_id]['name'] = $group_id;

				foreach( $group_fields AS $field_id )
				{
					$show_on_action = $this->fields[$field_id]->get_property('show_on_action');
					if( !$show_on_action || $show_on_action == $_REQUEST['action'] )
					{
						$field = $this->get_field_info($field_id);
						if( !$field['hidden'] )
						{
							$groups[$group_id]['fields'][$field_id] = $field;
							$form['num_errors'] += count($field['errors']);
						}
					}
				}
			} // end foreach

			foreach( array_keys($this->fields) AS $field_id )
			{
				if( $this->fields[$field_id]->get_property('is_button') )
				{
					$buttons[$field_id] = $this->get_field_info($field_id);
				}
			}
		} // end if
		else
		{
			foreach( array_keys($this->fields) AS $field_id )
			{
				if( !$this->fields[$field_id]->get_property('is_button') )
				{
					$show_on_action = $this->fields[$field_id]->get_property('show_on_action');
					if( !$show_on_action || $show_on_action == $_REQUEST['action'] )
					{
						$field = $this->get_field_info($field_id);
						if( !$field['hidden'] )
						{
							$fields[$field_id] = $field;
						}
					}
				}
				else
				{
					$buttons[$field_id] = $this->get_field_info($field_id);
				}
				$form['num_errors'] += count($field['errors']);
			}

		} // end else

		// get hidden fields
		foreach( array_keys($this->fields) AS $field_id )
		{
			$field = $this->get_field_info($field_id);
			if( $field['hidden'] )
			{
				$hidden_fields[$field_id] = $field;
			}
		}

		$form_definition = array(
					'form'		=> $form,
					'buttons'	=> $buttons,
					'hidden_fields'	=> $hidden_fields
					);
					
		if( isset($groups) )
		{
			$form_definition['groups'] = $groups;
		}
		else
		{
			$form_definition['fields'] = $fields;
		}
		return $form_definition;

	} // end function display

	//////////////////////////////////////////////////////////////
	/**
	* Returns associative array of field information
	*
	* @param string $field_id
	*/
	//////////////////////////////////////////////////////////////
	function get_field_info($field_id)
	{
		$this->_check_field_exists($field_id);

		if( !$this->fields[$field_id]->readonly && !$this->readonly || $this->fields[$field_id]->hidden )
		{
			$html = $this->fields[$field_id]->render();
		}
		else
		{
			$html = $this->fields[$field_id]->get_display_value();
				if( $this->submittable )
			{
				$html .= $this->fields[$field_id]->render_as_hidden();
			}
		}

		return array(
			'id'			=> $this->fields[$field_id]->get_field_var(),
			'name'			=> $this->fields[$field_id]->get_property('name'),
			'description'		=> $this->fields[$field_id]->get_property('description'),
			'html'			=> $html,
			'html_escaped_value'	=> $this->fields[$field_id]->get_html_escaped_value(),
			'display_value'		=> $this->fields[$field_id]->get_display_value(),
			'errors'		=> $this->fields[$field_id]->get_property('errors'),
			'hidden'		=> $this->fields[$field_id]->get_property('hidden'),
			'is_button'		=> $this->fields[$field_id]->get_property('is_button')
			);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Validate form by running validate() method for each field
	*/
	//////////////////////////////////////////////////////////////
	function validate()
	{
		foreach( $this->fields AS $field_id  => $field_obj )
		{
			$this->fields[$field_id]->validate();
		}
		return ( $this->has_errors() ) ? false : true;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns true if form has any errors
	*/
	//////////////////////////////////////////////////////////////
	function has_errors()
	{
		foreach( $this->fields AS $field_id  => $field_obj )
		{
			if( $this->fields[$field_id]->has_errors() )
			{
				return true;
			}
		}
		if( count( $this->errors ) )
		{
			return true;
		}
		return false;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Triggers an error on the form (but not on a specified field
	*
	* @param string $error Error message
	*/
	//////////////////////////////////////////////////////////////
	function trigger_error($error)
	{
		$this->errors[] = $error;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Triggers on error on the specified field
	*
	* @param string $field_id
	* @param string $error Error message
	*/
	//////////////////////////////////////////////////////////////
	function trigger_field_error($field_id, $error)
	{
		$this->fields[$field_id]->trigger_error($error);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Set properties for specified field
	*
	* @param string $field_id
	* @param array $properties
	*/
	//////////////////////////////////////////////////////////////
	function set_field_properties($field_id, $properties)
	{
		$this->_check_field_exists($field_id);
		$this->fields[$field_id]->set_properties($properties);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Set current value of specified field
	*
	* @param string $field_id
	* @param array $value
	*/
	//////////////////////////////////////////////////////////////
	function set_field_value($field_id, $value)
	{
		$this->_check_field_exists($field_id);
		$this->fields[$field_id]->set_properties( array( 'current_value' => $value) );
	}
	
	//////////////////////////////////////////////////////////////
	/**
	* Set constraints for specified field (used for validation)
	*
	* @param string $field_id
	* @param array $constraints List of constraints
	*/
	//////////////////////////////////////////////////////////////
	function set_field_constraints($field_id, $constraints = array())
	{
		$this->_check_field_exists($field_id);
		$this->fields[$field_id]->set_constraints($constraints);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Populate field values from an associative array
	* (field id => field value)
	*
	* @param array $values Array of field values
	*/
	//////////////////////////////////////////////////////////////
	function populate_from_array($values)
	{
		foreach( $values AS $field_id => $value )
		{
			if( is_object($this->fields[$field_id]) )
			{
				if( $this->fields[$field_id]->get_property('populate_from_array') )
				{
					if( $this->fields[$field_id]->get_property('import_filter_function') && $value !== NULL )
					{
						$import_filter_function = $this->fields[$field_id]->get_property('import_filter_function');
						if( is_array($import_filter_function) )
						{	
							$this->fields[$field_id]->set_current_value( $import_filter_function[0]->{$import_filter_function[1]}($value) );
						}
						else
						{
							$this->fields[$field_id]->set_current_value( $import_filter_function($value) );
						}
					}
					else
					{
						$this->fields[$field_id]->set_current_value($value);
					}
				}	
			}
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Return value of specified field property
	*
	* @param string $field_id
	* @param string $property Field property to return
	*/
	//////////////////////////////////////////////////////////////
	function get_field_property($field_id, $property)
	{
		return $this->fields[$field_id]->get_property($property);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Return HTML for specified field
	*
	* @param string $field_id
	* @param string $value
	*/
	//////////////////////////////////////////////////////////////
	function get_field_html($field_id, $key = NULL)
	{
		$this->_check_field_exists($field_id);

		// render only one part of multiple field?
		if( $key !== NULL )
		{
			return $this->fields[$field_id]->render_one($key);
		}
		// just render whole field
		else
		{
			return $this->fields[$field_id]->render();
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns true if specified field exists
	* @param string $field_id
	*/
	//////////////////////////////////////////////////////////////
	function field_exists($field_id)
	{
		return ( is_object($this->fields[$field_id]) ) ? true : false;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Errors out if specified field does not exist
	*
	* @param string $field_id
	*/
	//////////////////////////////////////////////////////////////
	function _check_field_exists($field_id)
	{
		if( !is_object($this->fields[$field_id]) )
		{
			echo "<b>Form '$this->id' Error:</b> field '$field_id' does not exist.";
			exit;
		}
	}
}

//////////////////////////////////////////////////////////////////////////////
// CLASS: field
// PURPOSE: common class for form fields
//////////////////////////////////////////////////////////////////////////////

/**
 * Contains basic functionality for a field in an HTML form
 *
 * @package form
 */
class field
{
	var $form_id;
	var $form_obj;			// reference to parent form instance


	var $id;			// id for the field, used in variable name
	var $name;			// name of the field, used only in display
	var $description;		// description of the field

	var $hidden = false;		// boolean, whether or not this is a hidden input

	/**
	* Whether value should be returned when $form->get_field_values()
	* is called
	* @var bool
	*/
	var $export = true;		// whether value should be returned when
					// $form->get_field_values() is called

	/**
	* Whether value should be exported if NULL
	* @var bool
	*/
	var $export_if_null = true;

	/**
	* Whether value should be populated by $form->populate_from_array
	* @var bool
	*/
	var $populate_from_array = true;

	var $current_value;		// current submitted or set value of the field

	var $readonly;			// boolean, whether the field is read only

	var $constraints = array();	// constraints checks to run when validating the field

	var $errors = array();		// errors found while validating

	var $disable_action = array();

	var $display_on	= array();

	var $validate_when_null = true;

	var $css_class = 'input';

	var $export_filter;

	//////////////////////////////////////////////////////////////
	/**
	* Constructor
	*
	* @param string $field_id
	*/
	//////////////////////////////////////////////////////////////
	function field( $id )
	{
		$this->id = $id;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns HTML escaped value of field
	*/
	//////////////////////////////////////////////////////////////
	function get_html_escaped_value()
	{
		if( @get_magic_quotes_gpc() )
		{
			return @htmlspecialchars(stripslashes($this->current_value));
		}
		else
		{
			return @htmlspecialchars($this->current_value);
		}
	}


	//////////////////////////////////////////////////////////////
	/**
	* Returns value of specified field property
	*
	* @param string $property
	*/
	//////////////////////////////////////////////////////////////
	function get_property($property)
	{
		return $this->{$property};
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns displayable (read-only) value of field
	*/
	//////////////////////////////////////////////////////////////
	function get_display_value()
	{
		return $this->get_html_escaped_value();
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns current value of field
	*/
	//////////////////////////////////////////////////////////////
	function get_current_value()
	{
		if( $this->current_value != NULL )
		{
			return $this->current_value;
		}
		else
		{
			return $this->default_value;
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Set current value of field
	*
	* @param mixed $value
	*/
	//////////////////////////////////////////////////////////////
	function set_current_value($value)
	{
		$this->current_value = $value;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Set properties of field
	*
	* @param array $properties
	*/
	//////////////////////////////////////////////////////////////
	function set_properties($properties=array())
	{
		foreach( $properties AS $key => $value )
		{
			if( $key == 'current_value' )
			{
				$this->set_current_value($value);
			}
			else
			{
				$this->{$key} = $value;
			}
		}

	} // end function set_properties

	//////////////////////////////////////////////////////////////
	/**
	* Set constraints for field
	*
	* @param array $constraints
	*/
	//////////////////////////////////////////////////////////////
	function set_constraints($constraints = array())
	{
		$this->constraints = $this->constraints + $constraints;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Validates field input based on set constraints
	*/
	//////////////////////////////////////////////////////////////
	function validate()
	{
		if( !($this->current_value == NULL && !$this->export_if_null) )
		{
		@reset($this->constraints);
		while( @list($constraint_key, $constraint_value) = @each($this->constraints) )
		{
			switch( $constraint_key )
			{
				case 'not_null':

					if( $this->get_current_value() == NULL )
					{
						$this->trigger_error("<b>$this->name</b> cannot be blank");
						$stop_validating = true;
					}

				break;


				case 'must_not_match_field':

					if( $this->get_current_value() == $this->form_obj->get_field_value($constraint_value) )
					{
						$other_field_name = $this->form_obj->get_field_property($constraint_value, 'name');
						$this->trigger_error("<b>$this->name</b> cannot match <b>$other_field_name</b>");
						$this->form_obj->trigger_field_error($constraint_value, "<b>$other_field_name</b> cannot match <b>$this->name</b>");
					}

				break;

				case 'must_match_field':

					if( $this->get_current_value() != $this->form_obj->get_field_value($constraint_value) )
					{
						$other_field_name = $this->form_obj->get_field_property($constraint_value, 'name');
						$this->trigger_error("<b>$this->name</b> must match <b>$other_field_name</b>");
						$this->form_obj->trigger_field_error($constraint_value, "<b>$other_field_name</b> must match <b>$this->name</b>");
					}
				break;

				case 'must_not_match_field_i':

					if( strtolower($this->get_current_value()) == strtolower($this->form_obj->get_field_value($constraint_value)) )
					{
						$other_field_name = $this->form_obj->get_field_property($constraint_value, 'name');
						$this->trigger_error("<b>$this->name</b> cannot match <b>$other_field_name</b>");
						$this->form_obj->trigger_field_error($constraint_value, "<b>$other_field_name</b> cannot match <b>$this->name</b>");
					}

				break;

				case 'must_match_field_i':

					if( strtolower($this->get_current_value()) != strtolower($this->form_obj->get_field_value($constraint_value)) )
					{
						$other_field_name = $this->form_obj->get_field_property($constraint_value, 'name');
						$this->trigger_error("<b>$this->name</b> must match <b>$other_field_name</b>");
						$this->form_obj->trigger_field_error($constraint_value, "<b>$other_field_name</b> must match <b>$this->name</b>");
					}

				break;

				case 'must_not_match':


				break;

				case 'must_match':

					if( !in_array_i($this->get_current_value(), $constraint_value) )
					{
						$this->trigger_error("<b>$this->name</b> must match one "
								." of the following:<br /><b>"
								. implode("<br />", $constraint_value)
								. "</b>");
					}

				break;

				case 'min_length':

					if( strlen($this->get_current_value()) < $constraint_value )
					{
						$this->trigger_error("<b>$this->name</b> must be at least "
								."$constraint_value characters long.");
					}

				break;

				case 'max_length':

					if( strlen($this->get_current_value()) > $constraint_value )
					{
						$this->trigger_error("<b>$this->name</b> cannot be more "
								."than $constraint_value characters long.");
					}

				break;

				case 'min_num':

					if( $this->get_current_value() < $constraint_value )
					{
						$this->trigger_error("<b>$this->name</b> must be at least "
								."$constraint_value");
					}

				break;

				case 'max_num':

					if( $this->get_current_value() > $constraint_value )
					{
						$this->trigger_error("<b>$this->name</b> cannot be more than "
								."$constraint_value");
					}

				break;

				case 'min_words':

					$word_count = count(split("[\s\t\r\n]", $this->get_current_value()));

					if( $word_count < $constraint_value )
					{
						$this->trigger_error("<b>$this->name</b> must be at least "
								."$constraint_value words long. It is "
								."currently $word_count words long.");
					}

				break;

				case 'max_words':

					$word_count = count(split("[\s\t\n\r]+", $this->get_current_value()));

					if( $word_count > $constraint_value )
					{
						$this->trigger_error("<b>$this->name</b> cannot be more than "
								."$constraint_value words long. It is "
								."currently $word_count words long.");
					}

				break;

				case 'pattern_match':

					// see which pattern match we need to do			
					switch( $constraint_value )
					{
						case 'email':

							if( !preg_match("/^\w+[\w|\.|-]*\w+@(\w+[\w|\.|-]*\w+\.[a-z]{2,4}|(\d{1,3}\.){3}\d{1,3})$/i", $this->get_current_value()) )
							{
								$this->trigger_error("<b>$this->name</b> must be "
										."a valid email address (ex: "
										."user@example.com)");
							}

						break;

						case 'url':

						break;

						case 'number':
							if( !is_numeric($this->get_current_value()) )
							{
								$this->trigger_error("<b>$this->name</b> must be a number");
							}
						break;

					} // end switch

				break;
		
			} // end switch

			if( $stop_validating )
			{
				break;
			}

		} // end while

		}

	} // end function validate

	//////////////////////////////////////////////////////////////
	/**
	* Returns HTML variable name from the field
	*/
	//////////////////////////////////////////////////////////////
	function get_field_var()
	{
		return str_replace(' ', '_', $this->form_id . '_' . str_replace('.', '_', $this->id));
	}

	//////////////////////////////////////////////////////////////
	/**
	* Adds an error to the field
	*
	* @param string $error
	*/
	//////////////////////////////////////////////////////////////
	function trigger_error($error)
	{
		$this->errors[] = $error;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns true if field has any errors
	*/
	//////////////////////////////////////////////////////////////
	function has_errors()
	{
		return ( count($this->errors) ) ? true : false;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Renders field as if it were a hidden field.
	*/
	//////////////////////////////////////////////////////////////
	function render_as_hidden()
	{
		return '<input type=hidden name="' . $this->get_field_var() . '" value="' . $this->get_html_escaped_value() . '" />';
	}

} // enc class field

/**
 * Hidden field
 * @package form
 */
class field_hidden extends field
{
	var $hidden	= true;

	//////////////////////////////////////////////////////////////
	/**
	* Returns HTML for field
	*/
	//////////////////////////////////////////////////////////////
	function render()
	{
		return '<input type="hidden" name="' . $this->get_field_var() . '" value="' . $this->get_html_escaped_value() . '" />';
	}
}

//////////////////////////////////////////////////////////////
/**
 * Basic text input field
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_text extends field
{
	function render()
	{
		return '<input type="text" name="' 
			.$this->get_field_var()  
			.'" class="'
			.$this->css_class
			.'" size="'
			.$this->size 
			.'" maxlength="'
			.$this->constraints['max_length'] 
			.'" value="'  
			.$this->get_html_escaped_value() 
			.'" title="'
			.htmlspecialchars($this->description)
			.'" />';
	}
}

//////////////////////////////////////////////////////////////
/**
 * Password field
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_password extends field
{
	/**
	* Character to display instead of password 
	*
	* @var string
	*/
	var $display_character = '*';

	function render()
	{
		return '<input type="password"'
			.'" name="'
			.$this->get_field_var()
			.'" class="'
			.$this->css_class
			.'" size="'
			.$this->size
			.'"value="'
			. $this->get_html_escaped_value()
			. '" />';
	}

	function get_display_value()
	{
		// hide password
		return str_repeat($this->display_character, strlen($this->current_value));
	}

	function get_current_value()
	{
		return $this->current_value;
	}
}

//////////////////////////////////////////////////////////////
/**
 * Textarea field
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_textarea extends field
{
	/**
	* @var rows
	*/
	var $rows	= 5;

	/**
	* @var cols
	*/
	var $cols	= 30;

	function render()
	{
		return  '<textarea name="'
			.$this->get_field_var()
			.'"class="'
			.$this->css_class
			.'" rows="'
			.$this->rows
			.'" cols="'
			.$this->cols
			.'">'
			.$this->get_html_escaped_value()
			.'</textarea>';
	}
	function get_display_value()
	{
		return  '<textarea readonly="readonly" name="'
			.$this->get_field_var()
			.'" class="'
			.$this->css_class
			.'" rows="'
			.$this->rows
			.'" cols="'
			.$this->cols
			.'">'
			.$this->get_html_escaped_value()
			.'</textarea>';
	}
}

//////////////////////////////////////////////////////////////
/**
 * Field with two options: "Yes" and "No"
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_yes_no_select extends field_select
{
	var $select_options	= array(
					array('array_key' => 'Yes', 'array_value' => 1),
					array('array_key' => 'No', 'array_value' => 0)
					);

} // end class field_yes_no_select

//////////////////////////////////////////////////////////////
/**
 * Data and time selection field
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_date_time extends field
{
	function get_current_value()
	{
		if( $this->current_value !== NULL )
		{
			extract($this->current_value);
			$hour += ( $ampm == 'pm' ) ? 12 : 0;
			return gmmktime($hour, $minute, $second, $month, $day, $year);
		}
		else
		{
			return NULL;
		}
	}

	function set_current_value($current_value)
	{
		// setting from post input
		if( is_array($current_value) )
		{
			$this->current_value = $current_value;
		}
		// setting from unix timestamp
		elseif( is_numeric($current_value) )
		{
			$this->current_value = array(
						'month'		=> gmdate('n', $current_value),
						'day'		=> gmdate('j', $current_value),
						'year'		=> gmdate('Y', $current_value),
						'hour'		=> gmdate('g', $current_value),
						'minute'	=> gmdate('i', $current_value),
						'ampm'		=> gmdate('a', $current_value)
						);
		}
	}

	function get_display_value()
	{
		return gmdate('<\b>' . "l F j, Y " . '</\b>' . " \a\\t " . '<\b>' . "g:ia" . '</\b>', $this->get_current_value());
	}

	function render()
	{
		$month_select = new field_select($this->id . '[month]');
		$month_select->set_properties(array(
						'form_id'	=> $this->form_id,
						'css_class'	=> $this->css_class,
						'select_options'=> array(
								'January'	=> 1,
								'February'	=> 2,
								'March'		=> 3,
								'April'		=> 4,
								'May'		=> 5,
								'June'		=> 6,
								'July'		=> 7,
								'August'	=> 8,
								'September'	=> 9,
								'October'	=> 10,
								'November'	=> 11,
								'December'	=> 12
								),
						'current_value'	=> $this->current_value['month']
						));

		$day_select = new field_select($this->id . '[day]');
		$day_select->set_properties(array(
						'form_id'	=> $this->form_id,
						'css_class'	=> $this->css_class,
						'select_options'=> range(1, 31),
						'current_value'	=> $this->current_value['day']
						));

		$year_select = new field_select($this->id . '[year]');
		$year_select->set_properties(array(
						'form_id'	=> $this->form_id,
						'css_class'	=> $this->css_class,
						'select_options'=> range(2002, 2039),
						'current_value'	=> $this->current_value['year']
						));

		$hour_select = new field_select($this->id . '[hour]');
		$hour_select->set_properties(array(
						'form_id'	=> $this->form_id,
						'css_class'	=> $this->css_class,
						'select_options'=> range(12, 1),
						'current_value'	=> $this->current_value['hour']
						));

		$minute_select = new field_select($this->id . '[minute]');
		$minute_select->set_properties(array(
						'form_id'	=> $this->form_id,
						'css_class'	=> $this->css_class,
						'current_value'	=> $this->current_value['minute']
						));
		
		$select_options = range(0, 59);
		foreach( $select_options AS $key => $value )
		{
			$select_options[$key] = sprintf('%02d', $value);
		}
		$minute_select->set_properties(array('select_options' => $select_options));

		$ampm_select = new field_select($this->id . '[ampm]');
		$ampm_select->set_properties(array(
						'form_id'	=> $this->form_id,
						'css_class'	=> $this->css_class,
						'select_options'=> array('am', 'pm'),
						'current_value'	=> $this->current_value['ampm']
						));

		$html = $month_select->render()
			.$day_select->render()
			.$year_select->render()
			.' at '
			.$hour_select->render()
			.':'
			.$minute_select->render()
			.$ampm_select->render();

		return $html;

	} // end function render()

	function validate()
	{
		@reset($this->constraints);
		while( @list($constraint_key, $constraint_value) = @each($this->constraints) )
		{
			switch( $constraint_key )
			{
				case 'must_be_before_field':

					if( $this->get_current_value() > $this->form_obj->get_field_value($constraint_value) )
					{
						$other_field_name = $this->form_obj->get_field_property($constraint_value, 'name');
						$this->trigger_error("<b>$this->name</b> must be a date earlier than <b>$other_field_name</b>");
						$this->form_obj->trigger_error($constraint_value, "<b>$other_field_name</b> must be a date later than <b>$this->name</b>");
					}

				break;

			} // end switch

		} // end while

	} // end function

} // end class field_date_time

//////////////////////////////////////////////////////////////
/**
 * class for time amount field - allows selections of days, hours,
 * minutes, and seconds and returns total time in seconds.
 * Basic text input field
 *
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_time_amount extends field
{
	var $current_value	= array();

	/**
	* Which fields to have in the time amount selection field
	* (i.e. days, hours, minutes, seconds, etc.)
	*
	* @var array
	*/
	var $have_fields	= array('days', 'hours', 'minutes', 'seconds');

	function get_current_value()
	{
		return	($this->current_value['days'] * 86400) +
			($this->current_value['hours'] * 3600) +
			($this->current_value['minutes'] * 60) +
			($this->current_value['seconds']);
	}

	function get_display_value()
	{
		// each field (i.e. days, hours, minutes, seconds)
		foreach( $this->current_value AS $field => $value )
		{
			if( $value )
			{
				// i.e. "5 days"
				$values[] = "<b>$value</b> $field";
			}
		}

		// return comma separated list
		return implode(', ', $values);

	} // end function get_display_value()

	function set_current_value($current_value)
	{
		// setting from form input
		if( is_array($current_value) )
		{
			$this->current_value = $current_value;
		}
		// setting from number of seconds
		elseif( is_numeric($current_value) )
		{
			$this->current_value['days'] = floor($current_value / 86400);
			$current_value -= $this->current_value['days'] * 86400;

			$this->current_value['hours'] = floor($current_value / 3600);
			$current_value -= $this->current_value['hours'] * 3600;

			$this->current_value['minutes'] = floor($current_value / 60);
			$current_value -= $this->current_value['minutes'] * 60;

			$this->current_value['seconds'] = $current_value;
		}
	}

	function render()
	{
		if( in_array('days', $this->have_fields) )
		{
			$days_select = new field_select($this->id . '[days]');
			$days_select->set_properties(array(
							'form_id'	=> $this->form_id,
							'css_class'	=> $this->css_class,
							'select_options'=> range(0, 365),
							'current_value'	=> $this->current_value['days']
							));
			$html .= $days_select->render() . "day(s) &nbsp;";
		}
		if( in_array('hours', $this->have_fields) )
		{
			$hours_select = new field_select($this->id . '[hours]');
			$hours_select->set_properties(array(
							'form_id'	=> $this->form_id,
							'css_class'	=> $this->css_class,
							'select_options'=> range(0, 23),
							'current_value' => $this->current_value['hours']
							));
			$html .= $hours_select->render() . "hour(s) &nbsp;";
		}
		if( in_array('minutes', $this->have_fields) )
		{
			$minutes_select = new field_select($this->id . '[minutes]');
			$minutes_select->set_properties(array(
							'form_id'	=> $this->form_id,
							'css_class'	=> $this->css_class,
							'select_options'=> range(0, 59),
							'current_value'	=> $this->current_value['minutes']
							));
			$html .= $minutes_select->render() . "minute(s) &nbsp;";
		}
		if( in_array('seconds', $this->have_fields) )
		{
			$seconds_select = new field_select($this->id . '[seconds]');
			$seconds_select->set_properties(array(
							'form_id'	=> $this->form_id,
							'css_class'	=> $this->css_class,
							'select_options'=> range(0, 59),
							'current_value'	=> $this->current_value['seconds']
							));
			$html .= $seconds_select->render()  . "second(s) &nbsp;";
		}

		return $html;

	} // end function render

} // end class field_time_amount

//////////////////////////////////////////////////////////////
/**
 * class for "list" field, which is a textarea where each line is
 * treated as a separate value.
 *
 * @package form
 * @todo fix problem with blank arrays being returned
 */
//////////////////////////////////////////////////////////////
class field_list extends field
{
	var $cols = 30;
	var $rows = 5;

	function get_current_value()
	{
		// each value should be on a separate line
		// separated by either \n or \r (or both)
		$this->current_value = preg_replace("/\n\n/", '', $this->current_value);
		return explode("\n", $this->current_value);
	}

	function set_current_value($current_value)
	{
		if( @is_array($current_value) )
		{
			$this->current_value = implode("\n", $current_value);
		}
		else
		{
			$this->current_value = str_replace("\r", '', $current_value);
			$this->current_value = preg_replace("/\n\n/", '', $this->current_value);
		}
	}

	function get_display_value()
	{
		$array = explode("\n", $this->current_value);

		$html = '<ol>';
		foreach( $array AS $value )
		{
			if( $value != NULL )
			{
				$html .= '<li>' . htmlspecialchars($value) . '</li>';
			}
		}
		$html .= '</ol>';

		return $html;
	}

	function render()
	{
		return  '<textarea name="'
			.$this->get_field_var()
			.'"class="'
			.$this->css_class
			.'" rows="'
			.$this->rows
			.'" cols="'
			.$this->cols
			.'">'
			.$this->get_html_escaped_value()
			.'</textarea>'
			.'<br /><small>(Enter one per line)</small>';
	}

}

//////////////////////////////////////////////////////////////
/**
 * Field that allows a list of values to ordered from greatest
 * to least.
 *
 * @package form
 * @todo Finish and test
 */
//////////////////////////////////////////////////////////////
class field_order_list extends field
{
	var $size	= 2;

	function render()
	{
		foreach( $this->select_options AS $key => $value )
		{
			$order_input = new field_text;
			$order_input->set_properties(array(
							'form_id'	=> $this->form_id,
							'css_class'	=> $this->css_class,
							'id'		=> $this->id . "[$value]",
							'current_value'	=> $this->current_value[$value],
							'size'		=> 1
							));
			$html .= $order_input->render()  . " $key<br />";
		}

		return $html;
	}

	function set_current_value($value)
	{
		$this->current_value = asort($value);
	}

	function get_display_value()
	{
		asort($this->current_value);
		foreach( $this->current_value AS $key => $value )
		{
			$i++;
			$html .= "$i: " . array_search($key, $this->select_options) . '<br />';
		}

		return $html;
	}

} // end class field_order_list

//////////////////////////////////////////////////////////////
/**
 * Drop-down select field
 *
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_select extends field
{
	/**
	* Associative array of selectable options
	* (array key = display, array value = returned value)
	*
	* @var array
	*/
	var $select_options	= array();

	/**
	* Whether or not to have a NULL option at the top of the
	* list.
	*
	* @var bool
	*/
	var $have_null_option	= false;

	/**
	* Whether or not to use option groups
	*
	* @var bool
	*/
	var $use_optgroups	= false;

	/**
	* Array of option groups
	*
	* @var array
	*/
	var $optgroups		= array();

	function set_properties( $properties = array() )
	{
		foreach( $properties AS $property_key => $property_value )
		{
			switch( $property_key )
			{
				case 'current_value':
					$this->set_current_value($property_value);
				break;
				case 'select_options':
					if( !is_array( current( $property_value ) ) )
					{
						foreach( $property_value AS $key => $value )
						{
							if( is_numeric( $key ) )
							{
								$key = $value;
							}
							$this->select_options[] = array('array_key' => $key, 'array_value' => $value);
						}
					}
					else
					{
						$this->select_options = $property_value;
					}
				break;
				default;
					$this->{$property_key} = $property_value;
			}
		}
	}				
	
	
	function render()
	{
		if( $this->have_null_option && !in_array( NULL, $this->select_options, true) )
		{
			array_unshift($this->select_options, array('array_key' => '-', 'array_value' => NULL));
		}
		else
		{
			$this->default_value = $this->select_options[0]['array_value'];
		}

		$onchange = ( $this->submit_on_change ) ? 'onChange="this.form.submit()"' : '';

		$html = "<select $onchange"
			.' name="'
			.$this->get_field_var()
			.'" class="'
			.$this->css_class
			.'" size="'
			.$this->size
			.'">';

		for( $i = 0; $i < count($this->select_options); $i++ )
		{
			if( $this->select_options[$i]['array_value'] == $this->current_value )
			{
				$option_selected = $i;
				break;
			}
		}

		for( $i = 0; $i < count($this->select_options); $i++ )
		{
			$key = $this->select_options[$i]['array_key'];
			$value = $this->select_options[$i]['array_value'];

			$selected = ( $i == $option_selected ) ? 'selected' : '';
			$html .= '<option value="' . htmlspecialchars($value) . "\" $selected>$key</option>";
		}
		$html .= '</select>';

		return $html;

	}

	function get_display_value()
	{
		for( $i = 0; $i < count($this->select_options); $i++ )
		{
			if( $this->select_options[$i]['array_value'] == $this->current_value )
			{
				$option_selected = $i;
				break;
			}
		}

		if( is_numeric($this->select_options[$option_selected]['array_key']) )
		{
			return $this->select_options[$option_selected]['array_value'];
		}
		else
		{
			return $this->select_options[$option_selected]['array_key'];
		}
	}
						
} // end class field_select

//////////////////////////////////////////////////////////////
/**
 * Drop-down timezone select
 *
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_timezone_select extends field_select
{
	var $select_options = array(
					'(GMT -12:00 hours)'						=> "-12",
					'(GMT -11:00 hours)'						=> "-11",
					'(GMT -10:00 hours)'						=> "-10",
					'(GMT -9:00 hours) Alaska'					=> "-9",
					'(GMT -8:00 hours) Pacific Time'				=> "-8",
					'(GMT -7:00 hours) Mountain Time'				=> "-7",
					'(GMT -6:00 hours) Central Time'				=> "-6",
					'(GMT -5:00 hours) Eastern Time'				=> "-5",
					'(GMT -4:00 hours) Atlantic Time'				=> "-4",
					'(GMT -3:30 hours)'						=> "-3.5",
					'(GMT -3:00 hours)'						=> "-3",
					'(GMT -2:00 hours)'						=> "-2",
					'(GMT -1:00 hours)'						=> "-1",
					'(GMT) Western Europe Time'					=> "0",
					'(GMT +1:00 hours) CET(Central Europe Time)'			=> "+1",
					'(GMT +2:00 hours) EET(Eastern Europe Time)'			=> "+2",
					'(GMT +3:00 hours)'						=> "+3",
					'(GMT +3:30 hours)'						=> "+3.5",
					'(GMT +4:00 hours)'						=> "+4",
					'(GMT +4:30 hours)'						=> "+4.5",
					'(GMT +5:00 hours)'						=> "+5",
					'(GMT +5:30 hours)'						=> "+5.5",
					'(GMT +6:00 hours)'						=> "+6",
					'(GMT +7:00 hours)'						=> "+7",
					'(GMT +8:00 hours)'						=> "+8",
					'(GMT +9:00 hours)'						=> "+9",
					'(GMT +9:30 hours)'						=> "+9.5",
					'(GMT +10:00 hours) EAST(East Australian Standard)'		=> "+10",
					'(GMT +11:00 hours)'						=> "+11",
					'(GMT +12:00 hours)'						=> "+12"
					);

	function field_timezone_select()
	{
		$this->set_properties(array('select_options' => $this->select_options));
	}
	
	function get_display_value()
	{
		if( $this->current_value >= 0 )
		{
			return 'GMT +' . $this->current_value;
		}
		else
		{
			return 'GMT ' . $this->current_value;
		}
	}

} // end class field_timezone_select

//////////////////////////////////////////////////////////////
/**
 * File upload field
 *
 * @package form
 * @todo Finish and test
 */
//////////////////////////////////////////////////////////////
class field_file_upload extends field
{
	/**
	* Whether or not field is a file field
	*
	* @var bool
	*/
	var $is_file 		= true;

	/**
	* Maximum file size that can be uploaded
	* (for use in HTML file input tag)
	*
	* @var int
	*/
	var $max_file_size	= 10240000;	// max file size in bytes

	var $export = false;

	function set_current_value($value)
	{
		$this->current_value = $value;
		
		// get file extension
		$array = explode('.', $this->current_value['name']);
		$this->current_value['extension'] = $array[count($array)-1];
	}

	function render()
	{
		return '<input type="hidden" name="MAX_FILE_SIZE" value="' . $this->max_file_size . '" />'
			.'Upload File: ' 
			.'<input type="file" name="'
			.$this->get_field_var()
			.'" class="'
			.$this->css_class
			.'" />';
	}

	function validate()
	{
		if( $this->current_value['name'] != NULL )
		{
			if( !is_uploaded_file($this->current_value['tmp_name']) )
			{
				$this->trigger_error("<b>$this->name</b> must be a file uploaded from your computer.");
			}
	
			foreach( $this->constraints AS $constraint_key => $constraint_value )
			{
				switch( $constraint_key )
				{
					case 'min_file_size':
	
						if( $this->current_value['size'] < $constraint_value )
						{
							$this->trigger_error("<b>$this->name</b> must be at least $constraint_value bytes.");
						}
					break;
	
	
					case 'max_file_size':
	
						if( $this->current_value['size'] > $constraint_value )
						{
							$this->trigger_error("<b>$this->name</b> must be less than $constraint_value bytes.");
						}
	
					break;
	
					case 'valid_extensions':
	
						if( !in_array($this->current_value['extension'], $constraint_value) )
						{
							$this->trigger_error("<b>$this->name</b> must have one of the following extensions: " . implode(', ', $constraint_value));
						}
	
					break;
	
				} // end switch
	
			} // end foreach
		}

	} // end function

} // end class field_file_upload


//////////////////////////////////////////////////////////////
/**
 * File upload field (multiple
 *
 * @package form
 * @todo Finish and test
 */
//////////////////////////////////////////////////////////////
class field_file_upload_multiple extends field_file_upload
{
	/**
	* Number of file upload fields
	* @var int
	*/
	var $num_files		= 2;

	var $allow_add_file	= false;
	var $export		= false;
	var $size		= 40;

	function set_current_value( $current_value )
	{
		// array comes in weird
		// (each file property comes in as an array of properties)
		// flip it so that it's an array of files, and truncate 
		// blank entries

		for( $i = 0; $i < $this->num_files; $i++ )
		{
			if( $current_value['name'][$i] != NULL )
			{
				$field_file_number = $i+1;
				$this->current_value[] = array(
							'field_name'	=> "File $field_file_number",
							'name'		=> $current_value['name'][$i],
							'type'		=> $current_value['type'][$i],
							'tmp_name'	=> $current_value['tmp_name'][$i],
							'error'		=> $current_value['error'][$i],
							'size'		=> $current_value['size'][$i]
							);
			}
		}
	}
	
	function render()
	{
		$html = '<input type="hidden" name="MAX_FILE_SIZE" value="' . $this->max_file_size . '" />';
		for( $i = 0; $i < $this->num_files; $i++ )
		{
			$file_number = $i+1;
			$html = $html 
				.'File '
				.$file_number
				.': <input type="file" name="'
				.$this->get_field_var()
				."[$i]\""
				.' class="'
				.$this->css_class
				.'" size="'
				.$this->size
				.'" /><br />';
		}
		return $html;
	}

	function validate()
	{
		if( count($this->current_value) < $this->constraints['min_file_uploads'] )
		{
			$this->trigger_error("You must upload at least <b>" . $this->constraints['min_file_uploads'] ."</b> file(s).");
		}
	
		if( count($this->current_value) )
		{
			foreach( $this->current_value AS $file )
			{
				// blank file or nothing uploaded
				if( !$file['size'] )
				{
					$this->trigger_error("<b>$file[field_name]</b>: file uploaded was empty or did not exist.");
				}
		
				foreach( $this->constraints AS $constraint_key => $constraint_value )
				{
					switch( $constraint_key )
					{
						case 'min_file_size':
		
							if( $file['size'] < $constraint_value )
							{
								$this->trigger_error("<b>$file[field_name]</b> must be at least $constraint_value bytes.");
							}
						break;
		
		
						case 'max_file_size':
							if( $file['size'] > $constraint_value )
							{
								$this->trigger_error("<b>$file[field_name]</b> must be less than $constraint_value bytes.");
							}
						break;
		
						case 'valid_extensions':
							if( !in_array($file['extension'], $constraint_value) )
							{
								$this->trigger_error("<b>$file[field_name]</b> must have one of the following extensions: " . implode(', ', $constraint_value));
							}
						break;
		
					} // end switch

				} // end foreach

			} // end foreach
		} // end if

	} // end function

	function get_display_value()
	{
		if( count($this->current_value) )
		{
			$html = '<ol>';
			foreach( $this->current_value AS $file )
			{
				$html = $html
					.'<li><b>'
					.$file['name']
					.'</b> <small>('
					.$file['size']
					.' bytes)</small>'
					.'</li>';
			}
			$html .= '</ol>';
			return $html;
		}
	}
}

//////////////////////////////////////////////////////////////
/**
 * Radio button field
 *
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_radio extends field
{
	function render()
	{
		foreach( $this->select_options AS $key => $value )
		{
			$checked = ( $this->current_value == $value ) ? ' checked' : '';

			$html[$key] =
				'<input type="radio" name="'
				. $this->get_field_var()
				.'" class="'
				.$this->css_class
				.'" value="'
				.htmlspecialchars($value)
				.'"'
				.$checked
				.' />';
		}
		return $html;
	}

	function get_display_value()
	{
		return array_search($this->current_value, $this->select_options);
	}
}

//////////////////////////////////////////////////////////////
/**
 * Submit button
 *
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_submit_button extends field
{
	/**
	* @var bool
	*/
	var $is_button		= true;

	/**
	* Will the form be considered "submitted()" by the main
	* form class if this button is clicked?
	*
	* @var bool
	*/
	var $submits_form	= true;

	var $export		= false;
	var $css_class		= 'button';

	function render()
	{
		return '<input type="submit" name="' 
			.$this->get_field_var()
			.'" class="'
			.$this->css_class
			.'" value="'
			.$this->name
			.'" />';
	}
}
		
//////////////////////////////////////////////////////////////
/**
 * Common class for fields which can hold multiple values
 *
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_multi extends field
{
	var $select_options	= array();
	var $current_value	= array();

	var $populate_from_mysql_set_field = false;	// field would be set from a
							// comma separated list instead
							// of an array

	function set_current_value($value)
	{
		if( is_array($value) )
		{
			$this->current_value = $value;
		}	
		elseif( $this->populate_from_mysql_set_field )
		{
			$this->current_value = explode(',', $value);
		}
		else
		{
			$this->current_value = $value;
		}
	}
			
	// validates the input for this field
	// overrides the validate() method from the field class, because there
	// are only a few special checks we need to do for multi fields
	function validate()
	{

		foreach( $this->constraints AS $constraint_key => $constraint_value )
		{
			switch( $constraint_key )
			{
				case 'min_selections':
			
					if( count($this->current_value) < $constraint_value )
					{
						$this->trigger_error("You must select at least <b>$constraint_value</b> from the list.");
					}

				break;

				case 'max_selections':

					if( count($this->current_value) > $constraint_value )
					{
						$this->trigger_error("You cannot select more than <b>$constraint_value</b> from the list.");
					}

				break;

			} // end switch

		} // end foreach

	} // end function validate()

	function get_display_value()
	{
		for($i = 0; $i < count($this->current_value); $i++)
		{
			$num = $i+1;
			$html .= "$num. " . array_search($this->current_value[$i], $this->select_options) . '<br />';
		}

		return $html;
	}
}

//////////////////////////////////////////////////////////////
/**
 * Drop-down select field which allows multiple selections
 *
 * @package form
 */
//////////////////////////////////////////////////////////////
class field_multi_select extends field_multi
{
	/**
	* Height of select field (number of options)
	*
	* @var int
	*/
	var $size = 5;

	function render()
	{
		if( $this->size > count($this->select_options) )
		{
			$this->size = count($this->select_options);
		}

		$html = '<select multiple="multiple" name="'
			.$this->get_field_var() . '[]'
			.'" class="'
			.$this->css_class
			.'" size="'
			.$this->size
			.'" >';
		if( $this->use_optgroups )
		{
			foreach( $this->optgroups AS $optgroup => $options )
			{
				$html .= '<optgroup label="' . $optgroup . '">';
			
				foreach( $options AS $key )
				{
					$selected = ( @in_array($value, $this->current_value) ) ? 'selected' : '';
					$html .= "<option value=\"" . htmlspecialchars($this->select_options[$key]) . "\" $selected>$key</option>";
				}
			}
		}
		else
		{
			for( $i = 0; $i < count($this->select_options); $i++ )
			{
				if( @in_array($this->select_options[$i]['array_value'], $this->current_value) )
				{
					$options_selected[] = $i;
				}
			}
	
			for( $i = 0; $i < count($this->select_options); $i++ )
			{
				$key = $this->select_options[$i]['array_key'];
				$value = $this->select_options[$i]['array_value'];
	
				$selected = ( @in_array($i, $options_selected) ) ? 'selected' : '';
				$html .= '<option value="' . htmlspecialchars($value) . "\" $selected>$key</option>";
			}
		}

		$html .= '</select><br /><small>(Hold CTRL to select more than one)</small>';
		return $html;

	}

}
//////////////////////////////////////////////////////////////
/**
 * Multiple checkbox field
 *
 * @package form
 * @todo Finish and test
 */
//////////////////////////////////////////////////////////////
class field_multi_checkbox extends field_multi
{
	function render()
	{
		foreach( $this->select_options AS $key => $value )
		{
			$checked = ( @in_array($value, $this->current_value) ) ? 'checked="checked" ' : '';

			$html = $html
				.'<input ' . $checked . 'type="checkbox" name="'
				.$this->get_field_var() .'[]'
				.'" class="'
				.$this->css_class
				.'" value="'
				.htmlspecialchars($value)
				.'" />'
				." <b>$key</b>"
				.'<br />';
		}
		return $html;
	}

	function render_one($key)
	{
		$checked = ( @in_array($this->select_options[$key], $this->current_value) ) ? 'checked="checked" ' : '';

		return '<input ' . $checked . 'type="checkbox" name="'
			.$this->get_field_var() .'[]'
			.'" class="'
			.$this->css_class
			.'" value="'
			.htmlspecialchars($this->select_options[$key])
			.'" />'
			.'<br />';
	}


}

//////////////////////////////////////////////////////////////
/**
 * Case-insensitive in_array()
 *
 * @package form
 * @param string $needle Text to search for
 * @param array $haystack Array to search in
 */
//////////////////////////////////////////////////////////////
function in_array_i($needle, $haystack = array())
{
	while( @list($key, $value) = @each($haystack) )
	{
		if( stristr($needle, $value) !== false )
		{
			return true;
		}
	}

	return false;
}

//////////////////////////////////////////////////////////////
/**
 * Returns listing of files in specified directory
 *
 * @package form
 * @param string $directory Directory
 * @param string $extension File extension
 */
//////////////////////////////////////////////////////////////
function list_files($directory, $extension='')
{
	$dir = @opendir($directory);
	while( $filename = @readdir($dir) )
	{
		if( ereg("$extension\$", $filename) )
		{
			$options[] = $filename;
		}

	}
	return $options;
}

//////////////////////////////////////////////////////////////
/**
 * Returns listing of files in specified directory
 *
 * @package form
 * @param string $directory Directory
 * @param string $extension File extension
 */
//////////////////////////////////////////////////////////////
function list_dirs($directory)
{
	$dir = @opendir($directory);
	while( $filename = @readdir($dir) )
	{
		if( is_dir($directory . '/' . $filename) && $filename != '..' && $filename != '.' )
		{
			$dirs[] = $filename;
		}

	}
	return $dirs;
}

function safe_html( $string )
{
	return trim(strip_tags(htmlentities($string)));
}

class select_query
{
	var $fields	= array();	// fields to select
	var $tables	= array();	// tables to select from
	var $where	= array();	// WHERE clauses
	var $order_by	= array();	// fields for ORDER BY clause
	var $group_by	= array();	// fields for GROUP BY clause
	var $query;			// the actual, constructed query
	var $order_type;		// ASC or DESC
	var $have_limit;		// whether or not to put a limit on this query
	var $limit_offset;		// what record to start on for a limit
	
	// how many records to get
	var $limit_num_records;
	
	function select_query()
	{
		// nothing
	}
	
	
	function add_field($fields)
	{
		// adds fields from which we'll be selecting stuff
		$this->fields[] = $fields;
	}
	
	function add_table($table)
	{
		// adds a table from which to select results
		$this->tables[] = $table;
	}
	
	function add_where_clause($clause)
	{
		// adds a where clause to the query
		$this->where[] = $clause;
	}
	
	function add_order_by($field)
	{
		// adds a field to order by
		$this->order_by[] = $field;
	}
	
	function add_group_by($field)
	{
		// adds a field to group by
		$this->group_by[] = $field;
	}
	
	function set_order_type($type)
	{
		// sets order type (ASC or DESC)
		$this->order_type = $type;
	}
	
	function set_limit($offset, $num_records)
	{
		// adds a limit to the query
		$this->have_limit = true;
		$this->limit_offset = $offset;


		$this->limit_num_records = $num_records;
	}
	
	function make($count_only=false)
	{
		$this->query = 'SELECT ';
		$this->query .= implode(',', $this->fields);
		
		$this->query .= ' FROM ';
		$this->query .= implode(',', $this->tables);
		
		// if there are any where clauses
		if(count($this->where))
		{
			$this->query .= ' WHERE ';
			$this->query .= implode(' AND ', $this->where);
		}
		
		// if there are any fields to group by
		if( count($this->group_by) )
		{
			$this->query .= " GROUP BY ";
			$this->query .= implode(",", $this->group_by);
		}
		
		// any fields to order by
		if( count($this->order_by) && !$count_only )
		{
			$this->query .= " ORDER BY ";
			$this->query .= implode(",", $this->order_by);
			
			$this->query .= " " . $this->order_type;
		}

		// a limit
		if( $this->have_limit && !$count_only )
		{
			$this->query .= " LIMIT $this->limit_offset,";
			$this->query .= $this->limit_num_records;
		}
		return $this->query;
	}

	function make_count()
	{
		$count_query = $this->make(true);
		return $count_query;
	}

} // end class select_query

function show_cp_message( $message )
{
	global $lore_system;
	$lore_system->te->assign('message', $message);
	$lore_system->te->display('cp_message.tpl');
}

function cp_error_out( $message )
{
	show_cp_message( $message );
	exit;
}

?>
