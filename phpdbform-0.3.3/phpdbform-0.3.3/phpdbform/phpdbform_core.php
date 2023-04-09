<?php
/* Copyright (C) 2000 Paulo Assis <paulo@coral.srv.br>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.  */

include("siteconfig.inc.php");
include("phpdbform/phpdbform_db.php");

class phpdbform {
  var $db;

  var $values;
  var $codigo_Value;

  var $attrib_allow_null;

  var $show_select_form;
  var $show_edit_button;
  var $show_delete_button;

  var $db_table;
  var $dblist_field_show;
  var $dblist_field_order;
  var $dblist_field_key;

  // Frédéric Berger <frederic.berger@noos.fr> 2001/04
  var $dblist_extra_field_name;
  var $dblist_extra_field_source;
  var $dblist_extra_field_target;
  var $dblist_extra_table_name;
  var $dblist_extra_field_order;
  var $extra_num=0;  

  var $html_table_cols;
  var $num=0;
  var $fields;
  var $titles;
  var $types;
  var $sizes;
  var $maxlengths;
  var $colspans;
  var $lb_show_fields;
  var $lb_key_fields;
  var $lb_table_names;
  var $lb_order_fields;
  var $field_eregs;
  var $msg_eregs;

  var $filter_stmt;
  var $filter_title;
  var $filter_size;
  var $filter_max;
  var $filter_value;
  var $filtered;

  var $readonly;
  var $disabled;

  function phpdbform( $database_obj, $db_table_name, $table_cols, $form_field_show, $form_field_order, $form_field_key ) {
    $this->db = $database_obj;
        $this->db_table = $db_table_name;
        $this->html_table_cols = $table_cols;
        $this->dblist_field_show = $form_field_show;
        $this->dblist_field_order = $form_field_order;
        $this->dblist_field_key = $form_field_key;
        $this->show_select_form = true;
        $this->show_edit_button = true;
        $this->show_delete_button = true;
        $this->filtered = false;
    }

  function add_field( $field_name, $field_title, $field_type, $field_size, $field_max, $field_colspan, $field_lb_show, $field_lb_key,  $field_lb_order, $field_lb_table ) {
    $this->fields[$this->num] = $field_name;
    $this->titles[$this->num] = $field_title;
    $this->types[$this->num] = $field_type;
    $this->sizes[$this->num] = $field_size;
    $this->maxlengths[$this->num] = $field_max;
    $this->colspans[$this->num] = $field_colspan;
    $this->lb_show_fields[$this->num] = $field_lb_show;
    $this->lb_key_fields[$this->num] = $field_lb_key;
    $this->lb_order_fields[$this->num] = $field_lb_order;
    $this->lb_table_names[$this->num] = $field_lb_table;
    $this->readonly[$this->num] = 0;
    $this->disabled[$this->num] = 0;
    return $this->num++;
  }

  function add_textbox( $field_name, $field_title, $field_size, $field_colspan ) {
    return $this->add_field( $field_name, $field_title, "textbox", $field_size, "", $field_colspan, "", "", "", "" );
  }
  function add_textarea( $field_name, $field_title, $area_cols, $area_rows, $field_colspan ) {    return $this->add_field( $field_name, $field_title, "textarea", $area_cols, $area_rows, $field_colspan, "", "", "", "" );
  }
  function add_checkbox( $field_name, $field_title, $field_colspan ) {
    return $this->add_field( $field_name, $field_title, "checkbox", 0, 0, $field_colspan, "", "", "", "" );
  // falta checked value e se possivel unchecked value
  }
  function add_listbox( $field_name, $field_title, $field_colspan, $field_lb_show, $field_lb_key, $field_lb_order, $field_lb_table  ) {
    return $this->add_field( $field_name, $field_title, "listbox", 0, 0, $field_colspan, $field_lb_show, $field_lb_key, $field_lb_order, $field_lb_table );
  }
  function add_filter_textbox( $field_stmt, $field_title, $field_size, $field_max, $field_colspan ) {
    $this->filter_stmt = $field_stmt;
    $this->filter_title = $field_title;
    $this->filter_size = $field_size;
    $this->filter_max = $field_max;
    $this->filter_value = "";
    $this->filtered = true;
  }
  function add_image( $field_name, $field_title, $field_colspan ) {
    return $this->add_field( $field_name, $field_title, "image", 0, 0, $field_colspan, "", "", "", "" );
  }
  function set_field_ereg( $ereg_val, $ereg_msg ) {
    if($this->num<=1) return;
    $idx = $this->num - 1;
    if(($this->types[$idx] != "textbox") && ($this->types[$idx] != "textarea")) return;
    $this->field_eregs[$idx] = $ereg_val;
    $this->msg_eregs[$idx] = $ereg_msg;
  }
  // Roberto Rosario <skeletor@iname.com> 2001
  function add_combobox_fixed( $field_name, $field_title, $field_options, $field_colspan) {
    return $this->add_field( $field_name, $field_title, "fixed_combo", 0, 0 ,$field_colspan, $field_options, "", "", "");
  }
  function add_link_button( $title, $location, $message, $size, $colspan)
  {
    return $this->add_field( "", $title, "link_button", $size, 0, $colspan, $message, $location, "", "");
  }
  function add_radiobox_fixed( $field_name, $field_title, $field_options, $field_colspan)
        {
    return $this->add_field( $field_name, $field_title, "radiobox_fixed", 0, 0, $field_colspan, $field_options, "", "", "");
        }
  // Frédéric Berger <frederic.berger@noos.fr> 2001/04
  function add_extra_field($extra_field_name, $extra_field_source, $extra_field_target, $extra_table_name, $extra_field_order)
  {
    $this->dblist_extra_field_name[$this->extra_num] = trim($extra_field_name);
    $this->dblist_extra_field_source[$this->extra_num] = trim($extra_field_source);
    $this->dblist_extra_field_target[$this->extra_num] = trim($extra_field_target);
    $this->dblist_extra_table_name[$this->extra_num] = trim($extra_table_name);
    $this->dblist_extra_field_order[$this->extra_num] = trim($extra_field_order);
    return $this->extra_num++;
  }
  function add_date_field( $field_name, $field_title, $field_colspan, $field_format )
  {
    if( $field_format != "fmtUS" && $field_format != "fmtEUR" && $field_format != "fmtSQL" )
      $field_format = "fmtSQL";
    return $this->add_field( $field_name, $field_title, "textdate", 10, 10, $field_colspan, $field_format, "", "", "" );
  }
  
  function set_control_readonly($field_num, $value)
  {
    $this->readonly[$field_num] = $value;
  }
  function set_control_disabled($field_num, $value)
  {
    $this->disabled[$field_num] = $value;
  }
  // Process results from form
  function process_form()
  {
    global $cb_Insert_Edit, $cb_Delete, $id, $error_msg;
    if( $this->filtered )
    {
      $this->filter_value = $GLOBALS["filter"];
    }
    for( $idx = 0; $idx < $this->num; $idx++ ) {
      $this->values[$idx]='';
      // check for ereg
      if( $cb_Insert_Edit != '')
      {
        if(!empty($this->field_eregs[$idx]))
        {
          if(!ereg($this->field_eregs[$idx],$GLOBALS["form_v$idx"]))
          {
            print($this->msg_eregs[$idx]);
            return false;
          }
        }
      }
    }
    if( $cb_Insert_Edit != '')
    {
      if( $id == '' )
      {
        $fldraw = false;
        $stmt = "insert into ".$this->db_table." (";
        for( $idx = 0; $idx < $this->num; $idx++ )
        {
          if( $this->types[$idx] == "link_button" ) continue;
          if( $fldraw ) $stmt .= ", ";
          $stmt .= $this->fields[$idx];
          if( $this->types[$idx] == "image" ) $stmt .= ", ".$this->fields[$idx]."_ctrl";
          if( !$fldraw ) $fldraw = true;
        }
        $stmt .= " ) values ( ";
        $fldraw = false;
        for( $idx = 0; $idx < $this->num; $idx++ )
        {
          if( $this->types[$idx] == "link_button" ) continue;
          if( $fldraw ) $stmt .= ", ";
          if( $this->types[$idx] == "image" )
          {
            if( $GLOBALS["form_v$idx"] != "none" )
            {
              $imsize= getimagesize($GLOBALS["form_v$idx"]);
              // 0 - width; 1 - height
              // 2 - Image Type: 1 = GIF, 2 = JPG, 3 = PNG
              // 3 - "height=xxx width=xxx"
              // phpdbform: twwwwhhhh (Image Type/width/height)
              $stmt .= "'";
              $fp = fopen( $GLOBALS["form_v$idx"],"rb" );
              if(!$fp)
              {
                print $error_msg[MSG_ERR_NO_FILE];
                return false;
              }
              $stmt .= addslashes(fread($fp, $GLOBALS["form_v".$idx."_size"])) . "'";
              fclose($fp);
              $stmt .= sprintf(", '%01d%05d%05d'",$imsize[2],$imsize[0],$imsize[1]);
            } else {
              $stmt .= "'',''";
            }
          } else if( $this->types[$idx] == "textdate" ) {
            if( $this->lb_show_fields[$idx] == "fmtUS" )
            {
              $tDate = substr( $GLOBALS["form_v$idx"], 6, 4 ) . "-" 
                .substr( $GLOBALS["form_v$idx"], 0, 2 ) . "-" 
                .substr( $GLOBALS["form_v$idx"], 3, 2 );
            } else if( $this->lb_show_fields[$idx] == "fmtEUR" )
            {
              $tDate = substr( $GLOBALS["form_v$idx"], 6, 4 ) . "-" 
                .substr( $GLOBALS["form_v$idx"], 3, 2 ) . "/" 
                .substr( $GLOBALS["form_v$idx"], 0, 2 );
            } else $tDate = $GLOBALS["form_v$idx"];
            $stmt .= "'$tDate'";
          } else {
            $stmt .= "'" . $GLOBALS["form_v$idx"] . "'";
          }
          if( !$fldraw ) $fldraw = true;
        }
        $stmt .= " )";
        $ret = $this->db->query( $stmt, MSG_ERR_NO_INSERT );
        $id = '';
        if(!$ret) return false;
      } else {
        $stmt = "update $this->db_table set ";
        $fldraw = false;
        for( $idx = 0; $idx < $this->num; $idx++ )
        {
          if( $this->types[$idx] == "link_button" ) continue;
          
          if( $this->types[$idx] == "image" )
          {
            if( $GLOBALS["form_v$idx"] != "none" )
            {
			  if( $fldraw ) $stmt .= ", ";
              $stmt .= $this->fields[$idx] . "='";
              $imsize= getimagesize($GLOBALS["form_v$idx"]);
              // 0 - width; 1 - height
              // 2 - Image Type: 1 = GIF, 2 = JPG, 3 = PNG
              // 3 - "height=xxx width=xxx"
              // phpdbform: twwwwhhhh (Image Type/width/height)
              $fp = fopen( $GLOBALS["form_v$idx"],"rb" );
              if(!$fp)
              {
                print $error_msg[MSG_ERR_NO_FILE];
                return false;
              }
              $stmt .= addslashes(fread($fp, $GLOBALS["form_v".$idx."_size"])) . "'";
              fclose($fp);
              $stmt .= ", ".$this->fields[$idx]."_ctrl";
              $stmt .= sprintf("='%01d%05d%05d'",$imsize[2],$imsize[0],$imsize[1]);
            }
          } else if( $this->types[$idx] == "textdate" ) {
		    if( $fldraw ) $stmt .= ", ";
            if( $this->lb_show_fields[$idx] == "fmtUS" )
            {
              $tDate = substr( $GLOBALS["form_v$idx"], 6, 4 ) . "-" 
                .substr( $GLOBALS["form_v$idx"], 0, 2 ) . "-" 
                .substr( $GLOBALS["form_v$idx"], 3, 2 );
            } else if( $this->lb_show_fields[$idx] == "fmtEUR" )
            {
              $tDate = substr( $GLOBALS["form_v$idx"], 6, 4 ) . "-" 
                .substr( $GLOBALS["form_v$idx"], 3, 2 ) . "/" 
                .substr( $GLOBALS["form_v$idx"], 0, 2 );
            } else $tDate = $GLOBALS["form_v$idx"];
            $stmt .= $this->fields[$idx] . "='$tDate'";
          } else {
		    if( $fldraw ) $stmt .= ", ";
            $stmt .= $this->fields[$idx] . "='" . $GLOBALS["form_v$idx"] . "'";
          }
          if( !$fldraw ) $fldraw = true;
        }
        $stmt .= " where $this->dblist_field_key='$id'";
        $ret = $this->db->query( $stmt, MSG_ERR_NO_UPDATE );
        if(!$ret) return false;
      }
    } else if( $cb_Delete != '' ) {
      $stmt = "delete from $this->db_table where $this->dblist_field_key='$id'";
      $ret = $this->db->query( $stmt, MSG_ERR_NO_DELETE );
      $id = '';
      if(!$ret) return false;
    }
    if( $id == '' )
    {
      //If id is null and there's no source table then this must be a dataless form
      if (!$this->db_table) return true;

      //fetch empty result set to allow auto size even when no record is selected
      $result = $this->db->query( "SELECT * from $this->db_table LIMIT 0", MSG_ERR_NO_RECORD );
      for( $idx = 0; $idx < $num_fields; $idx++ ) $this->values[$idx]='';
    } else {
      //todo: change this to select only fields defined in class
      $result = $this->db->query( "SELECT * from $this->db_table WHERE $this->dblist_field_key='$id'", MSG_ERR_NO_RECORD );
    }

    if(!$result) return false;
    $row1 = $this->db->fetch_array($result);
    $this->codigo_Value = $row1[$this->dblist_field_key];

    //Retrieve field attributes
    $i = 0;
    while ($i < $this->db->num_fields($result))
    {
      $fldname = $this->db->field_name($result, $i);
      $fldlen = $this->db->field_len($result, $i);
      $this->attrib_allow_null[$fldname] = $this->db->field_allow_null($result, $i);
      $value[$fldname] = $fldlen;
      $i++;
    }

    //Set control attributes
    for( $idx = 0; $idx < $this->num; $idx++ )
    {
      $this->values[$idx] = $row1[$this->fields[$idx]];
      if ($this->types[$idx] == "textbox")
      {
        $this->maxlengths[$idx] = $value[$this->fields[$idx]];
        if ($this->sizes[$idx] == "auto")
        {
          $this->sizes[$idx] = $value[$this->fields[$idx]];
        }
      }
    }
    $this->db->free_result($result);
    return true;
  } // end function process_form

  // Draws html form
  function draw()
  {
    global $id;
    
    if(!$this->db->connect()) return;
    if(!$this->process_form()) return;
    if( $this->show_select_form ) $this->print_form_select();
    //echo "<form method='post' action='".getenv("SCRIPT_NAME")."'
        // Testing without action
        echo "<form method='post' name='edit_db_form' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='id' value='".$this->codigo_Value."'>";
    echo "<input type='hidden' name='filter'  value='$this->filter_value'>";
    echo "<table border='0' align='center'".$table2.">";
    $btd = 0;
    for( $idx = 0; $idx < $this->num; $idx++ ) {
      if( $btd == 0 ) echo "<tr>";
      $btd += $this->draw_control($idx);
      if( $btd >= $this->html_table_cols ) {
        echo "</tr>";
        $btd = 0;
      }
    }
    $this->db->close();
    $but = 0;
    if( $this->show_edit_button ) $but++;
    if( $this->show_delete_button ) $but++;
    if( $but ) {
      echo "<tr><td colspan='".$this->html_table_cols."'><table width='100%'><tr valign='bottom'>";
      if( $this->show_edit_button )
      {
        if ($id == '') {
          $bmsg = MSG_INSERTONLY_BUTTON;
        } else {
          $bmsg = MSG_UPDATE_BUTTON;
        }
        echo "<td><input type='submit' name='cb_Insert_Edit' class='bt' value='".$bmsg."'></td>";
      }
      if( $this->show_delete_button && $id != '') {
        echo "<td";
        if( $but == 2 ) echo " align='right'";
        echo "><input type='submit' name='cb_Delete' class='bt' value='".MSG_DELETE_BUTTON."'></td>";
      }
      echo "</tr></table></td></tr>";
    }
    echo "</table></form>";
  }
  //print form select (listbox with all records)
  function print_form_select()
  {
    global $id;
        
    // Initialize select, from and order clause.
    $stmt_select = "select ".$this->db_table.".".$this->dblist_field_key;
    if ($this->dblist_field_show != "") $stmt_select .= ", ".$this->db_table.".".$this->dblist_field_show;
    $stmt_from = " from $this->db_table";
    $stmt_order = " order by ";

    // Build order clause.
    if (strchr($this->dblist_extra_field_order[$i], ","))
        {
      $tok = strtok($this->dblist_extra_field_order[$i], ",");
      while ($tok)
            {
        $stmt_order .= (($stmt_order == " order by ")? " $this->db_table." : ", $this->db_table.") . trim($tok);
        $tok = strtok(",");
      }
    } else if (trim($this->dblist_field_order) != "") $stmt_order .= (($stmt_order == " order by ") ? "$this->db_table." : ", $this->db_table.") . trim($this->dblist_field_order);
    for ($i = 0; $i < $this->extra_num; $i++) {
      // Build select clause.
      $stmt_select .= ", table$i." . $this->dblist_extra_field_name[$i] . " as field$i ";
      // Build from clause.
      $stmt_from .= " left outer join " . $this->dblist_extra_table_name[$i] . " as table$i on (" . $this->db_table . "." . $this->dblist_extra_field_source[$i] . " = table$i." . $this->dblist_extra_field_target[$i].")";
      // Build order clause.
      if (strchr($this->dblist_extra_field_order[$i], ","))
            {
        $tok = strtok($this->dblist_extra_field_order[$i], ",");
        while ($tok)
                {
          $stmt_order .= (($stmt_order == " order by ")? " table$i." : ", table$i.") . trim($tok);
          $tok = strtok(",");
        }
      } else if (trim($this->dblist_extra_field_order[$i]) != "") $stmt_order .= (($stmt_order == " order by ")? " table$i." : ", table$i.") . $this->dblist_extra_field_order[$i];
    }
    // Build where clause.
    if( $this->filtered && !empty($this->filter_value) )
        {
      $stmt_where = str_replace("%val%", $this->filter_value, " where $this->filter_stmt ");
    }   
    // Build query.
    $stmt = $stmt_select . $stmt_from . $stmt_where . $stmt_order;
    // echo $stmt;

    $ret_lista = $this->db->query( $stmt, MSG_ERR_NO_LOOKUP );
    if(!$ret_lista) return false;
    //echo "<form name='select_rec' action='".getenv("SCRIPT_NAME")."' method='post'>
        // Testing without action
        echo "<form name='select_rec' method='post'>
    <table border='0' align='center' $table2>
    <tr><td>
      <select name='id' onChange='document.select_rec.submit()'>
      <option value=''>&nbsp;</option>
      <option value=''>".MSG_ADD_NEW_REC."</option>";
    while( $row = $this->db->fetch_array($ret_lista) ) {
      echo "<option value='".$row[$this->dblist_field_key]."' ";
      echo ($row[$this->dblist_field_key] == $id)?"selected>":">";
      // Roberto Rosario <skeletor@iname.com> 2001
      if ( strchr($this->dblist_field_show, ",")) {
        $tok = strtok($this->dblist_field_show, ",");
        while ( $tok ) {
          echo $row[$tok];
          $tok = strtok(",");
          if ($tok) echo " | ";
        }
      } else echo $row[$this->dblist_field_show];

      // Add extra fields in the select box.
      for ($i = 0; $i < $this->extra_num; $i++)
            {
        if ($this->dblist_field_show == "" && $i == 0) echo $row["field$i"];
        else echo " | " . $row["field$i"];
      }
      echo "</option>";           
    }

    $this->db->free_result( $ret_lista );
    echo "</select></td><td align='right'>";
    echo "<input type='submit' name='cbselect' value='".MSG_SELECT_BUTTON."'>";
    echo "</td></tr>";
    if( $this->filtered ) {
      echo "<tr><td colspan='2'>";
      echo $this->filter_title . ":<br>";
      echo "<input type='text' name='filter' size='$this->filter_size' maxlength='$this->filter_maxlength' value='$this->filter_value'>";
      echo "</td></tr>";
    }
    echo "</table></form><br>";
  }

  // Draw each control (must be called only inside class)
  function draw_control( $field_num ) {
    global $id, $error_msg;
    // check if field_num is valid
    if( $field_num < 0 || $field_num > $this->num ) {
      print $error_msg[MSG_ERR_TOO_MANY_FIELDS];
      return 0;
    }
    $readonly = ($this->readonly[$field_num])?"readonly class=\"rdonly\"":"";
    $disabled = ($this->disabled[$field_num])?"disabled class=\"disabled\"":"";
    $ctrl_name = "form_v$field_num";
    $txt = "<td colspan='".$this->colspans[$field_num]."'>";
    switch ($this->types[$field_num]) {
    case 'textbox':
      $txt .= "<span class=\"text\">".$this->titles[$field_num].":</span><br>";
      $txt .= "<input type='text' name='$ctrl_name' $readonly $disabled size='";
      $txt .= $this->sizes[$field_num]."' maxlength='".$this->maxlengths[$field_num];
      $txt .= "' value=\"".$this->values[$field_num]."\">";
    break;
    case 'textarea':
      $txt .= "<span class=\"text\">".$this->titles[$field_num].":</span><br>";
      $txt .= "<textarea wrap name='$ctrl_name' $readonly $disabled cols='".$this->sizes[$field_num];
      $txt .= "' rows='".$this->maxlengths[$field_num]."'>";
      $txt .= $this->values[$field_num]."</textarea>";
    break;
    case 'checkbox':
      if ($readonly)
      {
        $txt .= "<script language='JavaScript'>var ".$ctrl_name."_v=0;</script>";
        $js = "onFocus=\"".$ctrl_name."_v=this.checked;\" ";
        $js .= "onChange=\"this.checked=".$ctrl_name."_v;\"";
      }
      $txt .= "<input type='checkbox' name='$ctrl_name' $disabled $js value='1'";
      if( $this->values[$field_num] > 0 ) $txt .= "checked";
      $txt .= "> <span class=\"text\">".$this->titles[$field_num].":</span><br>";
    break;
    case 'listbox':
      $i=0;
      $stmt = "select ".$this->lb_show_fields[$field_num].",".$this->lb_key_fields[$field_num]." from ".$this->lb_table_names[$field_num]." order by ".$this->lb_order_fields[$field_num];
      $ret_lista_lb = $this->db->query( $stmt, MSG_ERR_NO_LISTBOX );
      if(!$ret_lista_lb) return false;
      $txt .= "<span class=\"text\">".$this->titles[$field_num].":</span><br>";
      //Implement read-only on listbox using javascript
      if ($readonly)
      {
        $txt .= "<script language='JavaScript'>var ".$ctrl_name."_v;</script>";
        $js = "onFocus=\"".$ctrl_name."_v=this.selectedIndex;\" ";
        $js .= "onChange=\"this.options[".$ctrl_name."_v].selected=true;\"";        }
      $txt .= "<select name='$ctrl_name' $disabled $js>";

                        //Add blank entry if nulls are allowed for this field.
                        if ($this->attrib_allow_null[$this->fields[$field_num]])
                                $txt .= "<option value=''></option>";

      while( $row = $this->db->fetch_array($ret_lista_lb) ) {
        $selected = ($row[$this->lb_key_fields[$field_num]] == $this->values[$field_num])?"selected":"";
        if (strchr($this->lb_show_fields[$field_num], ",")) {
          $txt .= "<option value=\"".$row[$this->lb_key_fields[$field_num]]."\" ".$selected.">";
          $tok = strtok($this->lb_show_fields[$field_num], ",");
          while ($tok) {
            $txt .= $row[$tok];
            $tok = strtok(",");
            if ($tok) {
              $txt .= " | ";
            }
          }
          $txt .= "</option>";
        } else
        $txt .= "<option value=\"".$row[$this->lb_key_fields[$field_num]]."\" " .$selected.">".$row[$this->lb_show_fields[$field_num]]."</option>";
      }
      $txt .= "</select>";
      $this->db->free_result($ret_lista_lb);
    break;
    case 'image':
      $txt .= "<span class=\"text\">".$this->titles[$field_num].":</span><br>";
      $txt .= "<input type='file' name='$ctrl_name' $readonly $disabled><br>";
      $txt .= "<img src='phpdbimage.php?im=".$this->fields[$field_num].
      "&tb=".$this->db_table.
      "&kf=".$this->dblist_field_key.
      "&id=$id'>";
    break;
    case 'fixed_combo':
      // Roberto Rosario <skeletor@iname.com> 2001
      $txt .= "<span class=\"text\">".$this->titles[$field_num].":</span><br>";
      //Implement read-only on combobox using javascript
      if ($readonly)
      {
        $txt .= "<script language='JavaScript'>var ".$ctrl_name."_v;</script>";
        $js = "onFocus=\"".$ctrl_name."_v=this.selectedIndex;\" ";
        $js .= "onChange=\"this.options[".$ctrl_name."_v].selected=true;\"";        }
      $txt .= "<select name='$ctrl_name' $disabled $js>";

                        //Add blank entry if nulls are allowed for this field.
                        if ($this->attrib_allow_null[$this->fields[$field_num]])
                                $txt .= "<option value=''></option>";

      //If a = sign is found handle substitution
      //ie: Yes=2,No=5
      //If user selects Yes a 2 is going to be saved in the database.
      $tok = strtok ($this->lb_show_fields[$field_num], ",");
      while( $tok ) {
        if ($pos=strpos($tok,"="))
                                {
                                        $value_desc = substr($tok,0,$pos);
                                        $true_value = substr($tok,$pos+1);
                                }
                                else
                                {
                                        $true_value = $tok;
                                        $value_desc = $tok;
                                }

        $selected = ($true_value == $this->values[$field_num])?"selected":"";
        $txt .= "<option value=\"".$true_value."\" " .$selected.">".$value_desc."</option>";
        $tok = strtok (",");
      }
      $txt .= "</select>";
    break;
    case 'link_button':
                        $location = htmlspecialchars($this->lb_key_fields[$field_num]);
                        //Dots are not allowed on the url. Substitue it.
                        $location = str_replace(".", "??", $location);
                        $message = $this->lb_show_fields[$field_num];
                        $title = $this->titles[$field_num];
                        $title = str_pad($title, $this->sizes[$field_num], " ", STR_PAD_BOTH);
      $txt .= "<input type='submit' name='cb_Link_".$location."' $disabled class='bt' value='".$title."' onmouseover=\"window.status='".$message."'\" onmouseout=\"window.status=''\" alt='".$message."'>";
    break;
    case 'radiobox_fixed':
      $txt .= "<span class=\"text\">".$this->titles[$field_num].":</span><br>";
      if ($readonly)
      {
        $txt .= "<script language='JavaScript'>var ".$ctrl_name."_v=0;</script>";
        $js = "onFocus=\"var max=this.form.$ctrl_name.length;for(var i=0;i<max;i++){if (this.form.".$ctrl_name."[i].checked == true){".$ctrl_name."_v=i;break;}}\" ";
        $js .= "onChange=\"this.form.".$ctrl_name."[".$ctrl_name."_v].checked=true;\" ";
      }
                        $tok = strtok ($this->lb_show_fields[$field_num], ",");
                        while( $tok ) {
                                $selected = ($tok == $this->values[$field_num])?"checked":"";
                        $txt .= "<input type='radio' name='$ctrl_name' $disabled $js value=\"".$tok."\" " .$selected.">".$tok;
                                $tok = strtok (",");
                        }
    break;
    case 'textdate':
      if( strlen($this->values[$field_num]) == 10 )
      {
        if( $this->lb_show_fields[$field_num] == "fmtUS" )
        {
          $tDate = substr( $this->values[$field_num], 5, 2 ) . "/" 
              .substr( $this->values[$field_num], 8, 2 ) . "/" 
              .substr( $this->values[$field_num], 0, 4 );
        } else if( $this->lb_show_fields[$field_num] == "fmtEUR" )
        {
          $tDate = substr( $this->values[$field_num], 8, 2 ) . "/" 
              .substr( $this->values[$field_num], 5, 2 ) . "/" 
              .substr( $this->values[$field_num], 0, 4 );
        } else $tDate = $this->values[$field_num];
      } else $tDate = "";
      $txt .= "<span class=\"text\">".$this->titles[$field_num].":</span><br>";
      $txt .= "<input type='text' name='$ctrl_name' $readonly $disabled size='";
      $txt .= $this->sizes[$field_num]."' maxlength='".$this->maxlengths[$field_num];
      $txt .= "' value=\"$tDate\">";
    break;

    }
    $txt .= "</td>";
    print $txt;
    // returns number of colspan
    return $this->colspans[$field_num];
  }
}

// check if user is ok
function check_auth()
{
    global $AuthName;
    global $AuthPasswd;
  global $error_msg;
    if( AUTHDBFORM == "cookies" ) {
        if( empty($AuthName) ) {
            print $error_msg[MSG_ERR_BAD_PASSWD];
            return false;
        } else {
            setcookie("AuthName",$AuthName,time()+3600);
            setcookie("AuthPasswd",$AuthPasswd,time()+3600);
      return true;
        }
    } else {
    session_start();
    if( !session_is_registered("AuthName") ) {
      print $error_msg[MSG_ERR_BAD_PASSWD];
      return false;
    } else {
      return true;
    }
  }
}

// print html header, body and table1
function print_header($page_title)
{
global $img_header;
global $site_title;
global $table1;
global $theme;

  global $HTTP_POST_VARS;
  while (list ($var, $val) = each ($HTTP_POST_VARS))
  {
    if (strstr($var, "cb_Link"))
    {
      $link=substr($var, strlen("cb_Link")+1);
      $link=str_replace("??", ".", $link);
      header("Location:".$link);
    }
  }

include("themes/$theme/header.php");
}

// If you need to show another page as the backpage instead of index(menu.php) put the entire html command in back_page. print_logos(false,"<a href='index.html'>Home</a>");
function print_logos($print_menu=true, $back_page="")
{
  $txt = "<table border='0' width='100%'>";
  if(defined("TAIL_MSG")) $txt .= "<tr><td colspan='2' align='center'>".TAIL_MSG."</td></tr>";
  $txt .= "<tr><td>";
  if($print_menu) $txt .= "<a href='menu.php'>Index</a>";
  else if(strlen($back_page)>0) $txt .= $back_page;
  else $txt .= "&nbsp;";
  $txt .= "</td><td align='right'>";
  if(defined("SHOW_LOGO")) $txt .= "<a href='http://www.phpdbform.com'>phpDBform</a><br>";
  else $txt .= "&nbsp;";
  $txt .= "</td></tr></table>";
  print $txt;
}

// Close table1, body and html
function print_tail()
{
global $theme;
include("themes/$theme/footer.php");
}
?>
