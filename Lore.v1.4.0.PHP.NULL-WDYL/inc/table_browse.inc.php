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

/**

 * @copyright 2003 Pineapple Technologies
 * @author Pineapple Technologies
 * @package cp_lib
 */

//////////////////////////////////////////////////////////////
/**
 * General purpose database table browsing class
 * @package table_browse
 */
//////////////////////////////////////////////////////////////
class table_browse
{
	/**
	* Name of the table browser
	* @var string
	*/
	var $name;

	/**
	* Description of table browser
	* @var string
	*/
	var $description;

	/**
	* Array of links shown on each row
	* (ex: "Edit", "Delete", etc)
	* @var array
	*/
	var $links			= array();

	/**
	* Array of database fields displayed in the browser
	* @var array
	*/
	var $fields			= array();

	/**
	* Array of errors on the form (but not on a specific field)
	* @var array
	*/
	var $errors			= array();

	/**
	* Array of special fields that require a query on
	* each row.
	* @var array
	*/
	var $query_fields		= array();

	/**
	* Array of select option fields
	* @var array
	*/
	var $option_fields		= array();

	/**
	* Array of text searchable fields
	* @var array
	*/
	var $search_fields		= array();

	/**
	* Array of fields which have an action argument
	* (i.e. 'Move field to [     ] section'
	* @var array
	*/
	var $action_argument_fields	= array();

	/**
	* Array of fields in which the results can be 
	* ordered by.
	* @var array
	*/
	var $order_by_fields		= array();

	/**
	* Select query object
	* @var object
	*/
	var $select_query;

	/**
	* Select query object for count query (retrieves number
	* of results)
	* @var object
	*/
	var $count_query;

	/**
	* Form object
	* @var object
	*/
	var $form;

	/**
	* Whether or not to have page controls
	* @var bool
	*/
	var $have_page_controls;

	/**
	* Whether or not to have checkboxes on each row
	* (for performing actions on selected rows)
	* @var bool
	*/
	var $have_row_checkboxes;

	/**
	* Whether or not to have order by controls
	* (allows results to be ordered by a specific field)
	* @var bool
	*/
	var $have_order_by_controls;

	/**
	* Reference to database object
	* @var reference
	*/
	var $db;

	/**
	* Reference to template engine object
	* @var reference
	*/
	var $te;

	/**
	* Template to use to render the table browser
	* @var string
	*/
	var $template;

	/**
	* Name of rows (i.e. 'widgets')
	* @var string
	*/
	var $row_name = 'rows';

	/**
	* Field that identifies each row (used in COUNT() query)
	* @var string
	*/
	var $row_identifier = 'id';

	/**
	* Icon to show on table browser
	* @var string
	*/
	var $icon;

	//////////////////////////////////////////////////////////////
	/**
	* Constructor
	*
	* @param string $name name of table browser
	* @param string $description description of table browser
	*/
	//////////////////////////////////////////////////////////////
	function table_browse($name, $description='')
	{
		$this->name		= $name;
		$this->description	= $description;
		$this->select_query	= new select_query;
		$this->form		= new form('table_browse');
	}

	//////////////////////////////////////////////////////////////
	/**
	* Add field onto query which will be displayed in table browser.
	*
	* @param string $field Database field to select
	* @param string $display_name Name to display in head for field
	* @param string $css_class CSS class for table cells displaying this field
	*/
	//////////////////////////////////////////////////////////////
	function add_display_field($field_id, $display_name='', $css_class='')
	{
		$this->select_query->add_field($field_id);
		if( stristr($field_id, 'AS') )
		{
			list($junk, $field_id) = split('AS ', $field_id);
		}

		$display_name = ( $display_name ) ? $display_name : $field_id;
		$this->fields[$field_id] = array(
						'display_name'	=> $display_name,
						'display_html'	=> $display_html,
						'css_class'		=> $css_class
						);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Adds page controls to browser
	*
	* @param string $table
	*/
	//////////////////////////////////////////////////////////////
	function add_page_controls( $results_per_page=25 )
	{
		$this->have_page_controls = true;
		$this->form->add_field('results_per_page', 'field_text', array('size' => 2, 'default_value' => $results_per_page));
		$this->form->add_field('first_page', 'field_submit_button', array('name' => '<< First'));
		$this->form->add_field('last_page', 'field_submit_button', array('name' =>  'Last >>'));
		$this->form->add_field('next_page', 'field_submit_button', array('name' => 'Next >'));
		$this->form->add_field('prev_page', 'field_submit_button', array('name' => '< Prev'));
		$this->form->add_field('current_page', 'field_hidden', array('default_value' => 1));

		$this->_add_update_results_submit_button();
	}

	//////////////////////////////////////////////////////////////
	/**
	* Adds order by controls, which allow results to be ordered
	* by the specified field
	*
	* @param array $only_fields List of fields to allow ordering by (assumed all if not specified)
	*/
	//////////////////////////////////////////////////////////////
	function add_order_by_controls( $only_fields=array() )
	{
		$this->have_order_by_controls = true;	
		$this->form->add_field('order_by_field', 'field_select');
		$this->form->add_field('order_by_type', 'field_select', array('select_options' => array('Ascending' => 'ASC', 'Descending' => 'DESC')));
		$this->form->add_field('order_by_submit_button', 'field_submit_button', array('name' => 'Go'));

		$fields = ( count($only_fields) ) ? $only_fields : array_keys($this->fields);
		foreach( $fields AS $field_id )
		{
			$field_display_name = $this->fields[$field_id]['display_name'];
			$select_options[$field_display_name] = $field_id;
		}
		$this->form->set_field_properties('order_by_field', array('select_options' => $select_options));
	}
	//////////////////////////////////////////////////////////////
	/**
	* Adds tables onto query (variable number of arguments)
	*
	* @param string $table
	*/
	//////////////////////////////////////////////////////////////
	function add_tables()
	{
		$tables = func_get_args();
		foreach( $tables AS $table )
		{
			$this->select_query->add_table($table);
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Add fields onto query (which will not be displayed in table browser)
	*
	* @param string $field Database field to select
	*/
	//////////////////////////////////////////////////////////////
	function add_fields()
	{
		$fields = func_get_args();
		foreach( $fields AS $field )
		{
			$this->select_query->add_field($field);
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Add text searchable fields to table browser
	*
	* @param array $fields List of searchable fields
	*/
	//////////////////////////////////////////////////////////////
	function add_text_search_field( $fields = array() )
	{
		$this->search_fields[] = array('type' => 'text');
		foreach( $fields AS $field_id => $display_name )
		{
			$select_options[$display_name] = $field_id;
		}
		$this->form->add_field('search_by', 'field_select', array('select_options' => $select_options, 'have_null_option' => false));
		$this->form->add_field('search_for', 'field_text');

		foreach( $fields AS $field_id => $display_name )
		{
			if( $_GET[$field_id] !== NULL )
			{
				$this->form->set_field_properties('search_by', array('default_value' => $field_id));
				$this->form->set_field_properties('search_for', array('default_value' => $_GET[$field_id]));
			}
		}
		
		$this->_add_update_results_submit_button();

	}

	//////////////////////////////////////////////////////////////
	/**
	* Add drop-down select field to table browser
	*
	* @param string $field Database field
	* @param array $select_options Field values to select from
	*/
	//////////////////////////////////////////////////////////////
	function add_option_field($field, $caption, $select_options = array() )
	{
		$this->option_fields[$field] = array( 'caption' => $caption );
		$this->form->add_field($field, 'field_select', array('default_value' => $_GET[$field]));
		$this->form->set_field_properties($field, array('select_options' => $select_options, 'have_null_option' => true));
	}

	//////////////////////////////////////////////////////////////
	/**
	* Add 'WHERE' clause onto query
	*
	* @param string $where 'WHERE' clause
	*/
	//////////////////////////////////////////////////////////////
	function add_where_clause($where)
	{
		$this->select_query->add_where_clause($where);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Add 'GROUP BY' clause onto query
	*
	* @param string $group_by
	*/
	//////////////////////////////////////////////////////////////
	function add_group_by($group_by)
	{
		$this->select_query->add_group_by($group_by);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Add link to each row displayed in table browser
	* (i.e. 'EDIT' link to allow editing of the row)
	*
	* @param string $link Name of link
	* @param string $url URL to link to
	*/
	//////////////////////////////////////////////////////////////
	function add_link($display_name, $script, $vars=array())
	{
		$this->links[] = array('display_name' => $display_name, 'script' => $script, 'vars' => $vars);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Adds a checkbox to each row so that it can be selected
	*
	* @param string $table
	*/
	//////////////////////////////////////////////////////////////
	function add_row_checkboxes()
	{
		$this->have_row_checkboxes = true;
		$this->form->add_field('row_checkboxes', 'field_multi_checkbox');
		$this->form->add_field('action', 'field_select');
		$this->form->add_field('action_submit_button', 'field_submit_button', array('name' => 'Go'));
	}

	//////////////////////////////////////////////////////////////
	/**
	* Adds argument field to specified action
	*
	* @param string $action
	8 @apram array $select_options
	*/
	//////////////////////////////////////////////////////////////
	function add_action_argument_field($action, $select_options)
	{
		$this->action_argument_fields[] = $action;
		$this->form->add_field($action, 'field_select', array('select_options' => $select_options));
	}

	//////////////////////////////////////////////////////////////
	/**
	* Sets list of actions that can be performed on selected rows
	*
	* @param string $actions
	*/
	//////////////////////////////////////////////////////////////
	function set_actions($actions = array())
	{
		$this->form->set_field_properties('action', array('select_options' => $actions));
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns previously submitted input
	*/
	//////////////////////////////////////////////////////////////
	function get_input()
	{
		$this->form->get_post_input();

		if( $this->form->field_exists('action_submit_button') )
		{
			if( $this->form->get_field_value('action_submit_button') )
			{
				$_REQUEST['action'] = $this->form->get_field_value('action');
			}
		}

		if( $this->form->field_exists('update_results') )
		{
			if( $this->form->get_field_value('update_results') )
			{
				// go back to page 1 - query was changed
				$this->form->set_field_properties('current_page', array('current_value' => 1));
			}
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns array of selected rows
	*
	* @param string $table
	*/
	//////////////////////////////////////////////////////////////
	function get_selected_rows()
	{
		return $this->form->get_field_value('row_checkboxes');
	}

	//////////////////////////////////////////////////////////////
	/**
	* Display table browser
	*
	* @param string $template Template to use
	*/
	//////////////////////////////////////////////////////////////
	function display()
	{
		$this->_initialize_query();

		$template_vars = array(
					'have_row_checkboxes'		=> $this->have_row_checkboxes,
					'have_order_by_controls'	=> $this->have_order_by_controls,

					'current_page'			=> $this->current_page,
					'total_results'			=> $this->total_results,
					'num_pages'			=> $this->num_pages,
					'have_page_controls'		=> $this->have_page_controls,

					'name'				=> $this->name,
					'icon'				=> $this->icon,
					'links'				=> $this->links,
					'option_fields'			=> $this->option_fields,
					'search_fields'			=> $this->search_fields,
					'row_name'			=> $this->row_name,

					'action'			=> $_SERVER['PHP_SELF'],

					'num_cols'			=> $num_cols,
					'field_names'			=> $field_names,
					'num_link_cols'			=> count($this->links),
					'rows'				=> $rows
				);

		if( count($this->option_fields) || count($this->search_fields) || $this->have_page_controls )
		{
			$template_vars['form']['update_results'] = $this->form->get_field_html('update_results');
		}

		foreach( array_keys($this->option_fields) AS $field_id )
		{
			$template_vars['form']['option_fields'][$field_id] = $this->form->get_field_html($field_id);
		}
		foreach( $this->search_fields AS $search_field )
		{
			if( $search_field['type'] == 'text' )
			{
				$template_vars['form']['search_by']	= $this->form->get_field_html('search_by');
				$template_vars['form']['search_for']	= $this->form->get_field_html('search_for');
			}
		}
		foreach( $this->fields AS $field )
		{
				$field_names[] = $field['display_name'];

		}
		foreach( $this->query_fields AS $display_name => $array)
		{
			$field_names[] = $display_name;
		}

		if( $this->have_page_controls )
		{
			if( $this->current_page > 1 )
			{
				$template_vars['form']['prev_page']  = $this->form->get_field_html('prev_page');
				$template_vars['form']['first_page'] = $this->form->get_field_html('first_page');
			}
			if( $this->current_page < $this->num_pages )
			{
				$template_vars['form']['next_page'] = $this->form->get_field_html('next_page');
				$template_vars['form']['last_page'] = $this->form->get_field_html('last_page');
			}

			$template_vars['form']['current_page_input']	= $this->form->get_field_html('current_page');
			$template_vars['form']['results_per_page']	= $this->form->get_field_html('results_per_page');
		}
		if( $this->have_order_by_controls )
		{
			$template_vars['form']['order_by_field']		= $this->form->get_field_html('order_by_field');
			$template_vars['form']['order_by_type']			= $this->form->get_field_html('order_by_type');
			$template_vars['form']['order_by_submit_button']	= $this->form->get_field_html('order_by_submit_button');
		}

		$rownum = 0;
		$result = $this->db->query( $this->select_query->make() );
		while( $row = $this->db->fetch_array($result) )
		{
			$row_checkboxes[$rownum] = $row['id'];

			// fields retrieved from database that need to be displayed
			foreach( $this->fields AS $field => $array )
			{
					extract($array);
					$rows[$rownum]['fields'][$field] = $row[$field];
			}

			// for each link, substitute in any fields from this row
			$linknum = 0;
			foreach( $this->links AS $link )
			{
				$rows[$rownum]['links'][$linknum]['link'] = $link['display_name'];
				$vars = array();
				foreach( $link['vars'] AS $var_name => $var_value )
				{
					eval('$vars[$var_name] = ' . '"$var_name=' .  $var_value . '";');
				}
				$rows[$rownum]['links'][$linknum]['link_to'] = $link['script'] . '?' . implode('&', $vars);
				$linknum++;
			}
			$rownum++;

		} // end while

		$num_cols = count($this->fields)+count($this->links)+count($this->query_fields)+2;
		if( $this->have_row_checkboxes )
		{
			$this->form->set_field_properties('row_checkboxes', array('select_options' => $row_checkboxes));
			for( $i = 0; $i < count($rows); $i++ )
			{
				$template_vars['form']['row_checkboxes'][$i] = $this->form->get_field_html('row_checkboxes', $i);
			}
			foreach( $this->action_argument_fields AS $field )
			{
				$template_vars['form']['action_argument_fields'][$field] = $this->form->get_field_html($field);
			}

			$template_vars['form']['action']			= $this->form->get_field_html('action');
			$template_vars['form']['action_submit_button']		= $this->form->get_field_html('action_submit_button');
		}

		$template_vars['rows']		= $rows;
		$template_vars['num_cols']	= $num_cols;
		$template_vars['field_names']	= $field_names;

		$template_vars['form']['submit_action'] = $this->form->get_property('submit_action');
		$this->te->assign($template_vars);
		$this->te->display($this->template);

	} // end function display

	//////////////////////////////////////////////////////////////
	/**
	* Adds submit button for updating results. This is the submit
	* button used on search and option fields.
	*/
	//////////////////////////////////////////////////////////////
	function _add_update_results_submit_button()
	{
		if( !$this->form->field_exists('update_results') )
		{
			$this->form->add_field('update_results', 'field_submit_button', array('name' => 'Go', 'export' => false));
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Return suitable name for specified field
	*
	* @access private
	* @param string $field Database name
	*/
	//////////////////////////////////////////////////////////////
	function _get_field_display_name($field)
	{
		return str_replace(' ', '', ucwords(str_replace('_', '', $field)));
	}

	//////////////////////////////////////////////////////////////
	/**
	* Initialize select query by adding respective WHERE caluses
	* and other parameters based on form input
	*
	* @access private
	*/
	//////////////////////////////////////////////////////////////
	function _initialize_query()
	{
		// if any option or search fields were selected, add respective
		// where clauses to query
		foreach( array_keys($this->option_fields) AS $field_id )
		{
			// if option was specified
			$option_value = $this->form->get_field_value($field_id);
			if( $option_value !== NULL )
			{
				$this->select_query->add_where_clause($field_id . " = '$option_value'");
			}
		}
		foreach( $this->search_fields AS $search_field )
		{
			if( $search_field['type'] == 'text' )
			{			
				$search_for = $this->form->get_field_value('search_for');
				if( $search_for !== NULL )
				{
					// replace asterisks with MySQL's wildcard '%'
					$search_value = str_replace('*', '%', $search_value);
					$this->select_query->add_where_clause($this->form->get_field_value('search_by') . " LIKE '%$search_for%'");
				}
			}
		}

		if( $this->have_page_controls )
		{
			$this->results_per_page	= $this->form->get_field_value('results_per_page');
			$this->current_page	= $this->form->get_field_value('current_page');
			$this->total_results	= $this->db->num_rows( $this->db->query($this->select_query->make_count()) );
			$this->num_pages	= ceil($this->total_results / $this->results_per_page);
	
			// update current page if next/prev buttons were used
			switch( !NULL )
			{
				case $this->form->get_field_value('first_page'):
					$this->current_page = 1;
				break;
	
				case $this->form->get_field_value('prev_page'):
					$this->current_page--;
				break;
	
				case $this->form->get_field_value('last_page'):
					$this->current_page = $this->num_pages;
				break;
	
				case $this->form->get_field_value('next_page'):
					$this->current_page++;
				break;
	
			} // end switch
		
			$this->select_query->set_limit( ($this->current_page - 1) * $this->results_per_page, $this->results_per_page );
			$this->form->set_field_properties('current_page', array('current_value' => $this->current_page));

		} // end if

		if( $this->have_order_by_controls )
		{
			if( $order_by_field = $this->form->get_field_value('order_by_field') )
			{
				$this->select_query->add_order_by( $order_by_field );
				$this->select_query->set_order_type( $this->form->get_field_value('order_by_type') );
			}
		}
	}

} // end class table_browse
