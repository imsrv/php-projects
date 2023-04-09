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

include("reportconfig.inc.php");
include("phpdbform/phpdbform_db.php");

class phpdbreport {
    var $db;

    var $values;

    var $db_table;

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

    var $readonly;
    var $disabled;
	
    var $report_part;

    function phpdbreport( $database_obj, $sql_string, $report_cols ) {
        $this->db = $database_obj;
        $this->db_table = $sql_string;
        $this->html_table_cols = $report_cols;
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
	function add_textarea( $field_name, $field_title, $area_cols, $area_rows, $field_colspan ) {		return $this->add_field( $field_name, $field_title, "textarea", $area_cols, $area_rows, $field_colspan, "", "", "", "" );
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
	function set_control_readonly($field_num, $value)
	{
		$this->readonly[$field_num] = $value;
	}
	function set_control_disabled($field_num, $value)
	{
		$this->disabled[$field_num] = $value;
	}
	function set_control_inheader($field_num)
	{
		$this->report_part[$field_num] = "header";
	}
	function set_control_infooter($field_num)
	{
		$this->report_part[$field_num] = "footer";
	}
	function set_control_indetail($field_num)
	{
		$this->report_part[$field_num] = "detail";
	}
	function add_ruler()
	{
		return $this->add_field( "", "", "ruler", 0, 0, -1, "", "", "", "");
	}
	function add_label( $label_caption, $colspan)
	{
		return $this->add_field( "", $label_caption, "label", 0, 0, $colspan, "", "", "", "");
	}

	function process_record($ret_lista)
	{
		$row = $this->db->fetch_array($ret_lista);

		if (!$row)
			return false;

		$i = 0;
		while ($i < $this->db->num_fields($ret_lista)) {
			$fldname = $this->db->field_name($ret_lista, $i);
			$fldlen = $this->db->field_len($ret_lista, $i);
			$value[$fldname] = $fldlen;
			$i++;
		}

			for( $idx = 0; $idx < $this->num; $idx++ ) {
				if (!isset($row[$this->fields[$idx]]))
					$this->values[$idx] = "#NO DATA#";
				else
					$this->values[$idx] = $row[$this->fields[$idx]];

				if ($this->types[$idx] == "textbox") {
					$this->maxlengths[$idx] = $value[$this->fields[$idx]];
					if (strcasecmp($this->sizes[$idx],"auto") == 0) {
						$this->sizes[$idx] = $value[$this->fields[$idx]];
					}
				}			
			}

		return $row;
	}
	function print_section($section)
	{
		$btd = 0;
		for( $idx = 0; $idx < $this->num; $idx++ ) {
			if( $btd == 0 ) echo "<tr>";
			$btd += $this->draw_control($idx, $section);
			if( $btd >= $this->html_table_cols ) {
				echo "</tr>";
				$btd = 0;
			}
		}
	}


	// Draws html form
	function draw()
	{
		if(!$this->db->connect()) return;
		if( $this->show_select_form ) $this->print_form_select();
	        echo "<form method='post' name='edit_db_form' enctype='multipart/form-data'>";
		echo "<table border='0' align='center'".$table2.">";

		$stmt = $this->db_table;
		$ret_lista = $this->db->query( $stmt, 6 );
		if(!$ret_lista) return false;

		$this->process_record($ret_lista);

//Print header

		$this->print_section("header");

//Print detail
		do
		{
			$this->print_section("detail");
		}while($this->process_record($ret_lista));
	
//Print footer
	
		$this->print_section("footer");
	
		$this->db->free_result($ret_lista);
		$this->db->close();
		echo "</table></form>";
	}

	// Draw each control (must be called only inside class)
	function draw_control( $field_num, $report_part) {
		global $id, $error_msg;
		// check if field_num is valid
		if( $field_num < 0 || $field_num > $this->num ) {
			print $error_msg[8];
			return 0;
		}

		if (!$this->report_part[$field_num])
			$this->report_part[$field_num] = "detail";

		if ($this->report_part[$field_num] != $report_part)
			return -1;

//		$readonly = ($this->readonly[$field_num])?"readonly":"";
		$disabled = ($this->disabled[$field_num])?"disabled":"";
		$disabled = "disabled";
		$ctrl_name = "form_v$field_num";

//		if (!$this->nolabel)
//			$label = $this->titles[$field_num];

		$txt = "<td colspan='".$this->colspans[$field_num]."'>";
		if ($this->colspans[$field_num] == -1)
			$txt="<td colspan=100%>";

		if( $this->types[$field_num] == "textbox" ) {
			if ($label)
				$txt .= $label.": ";

			$txt .= "<input type='text' name='$ctrl_name' $readonly $disabled size='";
			$txt .= $this->sizes[$field_num]."' maxlength='".$this->maxlengths[$field_num];
			$txt .= "' value='".$this->values[$field_num]."'>";
		} else if( $this->types[$field_num] == "textarea" ) {
			if ($label)
				$txt .= $this->titles[$field_num].":<br>";

			$txt .= "<textarea wrap name='$ctrl_name' $readonly $disabled cols='".$this->sizes[$field_num];
			$txt .= "' rows='".$this->maxlengths[$field_num]."'>";
			$txt .= $this->values[$field_num]."</textarea>";
		} else if( $this->types[$field_num] == "checkbox" ) {
			if ($readonly)
			{
				$txt .= "<script language='JavaScript'>var ".$ctrl_name."_v=0;</script>";
				$js = "onFocus=\"".$ctrl_name."_v=this.checked;\" ";
				$js .= "onChange=\"this.checked=".$ctrl_name."_v;\"";
			}
			$txt .= "<input type='checkbox' name='$ctrl_name' $disabled $js value='1'";
			if( $this->values[$field_num] > 0 ) $txt .= "checked";
			$txt .= "> ".$this->titles[$field_num];
		} else if( $this->types[$field_num] == "listbox" ) {
			$i=0;
			$stmt = "select ".$this->lb_show_fields[$field_num].",".$this->lb_key_fields[$field_num]." from ".$this->lb_table_names[$field_num]." order by ".$this->lb_order_fields[$field_num];
			$ret_lista_lb = $this->db->query( $stmt, 7 );
			if(!$ret_lista_lb) return false;
			if ($label)
				$txt .= $this->titles[$field_num].": ";

			//Implement read-only on listbox using javascript
			if ($readonly)
			{
				$txt .= "<script language='JavaScript'>var ".$ctrl_name."_v;</script>";
				$js = "onFocus=\"".$ctrl_name."_v=this.selectedIndex;\" ";
				$js .= "onChange=\"this.options[".$ctrl_name."_v].selected=true;\"";				}
			$txt .= "<select name='$ctrl_name' $disabled $js>";
			while( $row = $this->db->fetch_array($ret_lista_lb) ) {
				$selected = ($row[$this->lb_key_fields[$field_num]] == $this->values[$field_num])?"selected":"";
				if (strchr($this->lb_show_fields[$field_num], ",")) {
					$txt .= "<option value='".$row[$this->lb_key_fields[$field_num]]."' ".$selected.">";
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
				$txt .= "<option value='".$row[$this->lb_key_fields[$field_num]]."' " .$selected.">".$row[$this->lb_show_fields[$field_num]]."</option>";
			}
			$txt .= "</select>";
			$this->db->free_result($ret_lista_lb);
		} else if( $this->types[$field_num] == "image" ) {
			$txt .= $this->titles[$field_num].":<br>";
			$txt .= "<input type='file' name='$ctrl_name' $readonly $disabled><br>";
			$txt .= "<img src='phpdbimage.php?im=".$this->fields[$field_num].
			"&tb=".$this->db_table.
			"&kf=".$this->dblist_field_key.
			"&id=$id'>";
		} else if( $this->types[$field_num] == "fixed_combo") {
			// Roberto Rosario <skeletor@iname.com> 2001
			if ($label)
				$txt .= $this->titles[$field_num].": ";
	
			//Implement read-only on combobox using javascript
			if ($readonly)
			{
				$txt .= "<script language='JavaScript'>var ".$ctrl_name."_v;</script>";
				$js = "onFocus=\"".$ctrl_name."_v=this.selectedIndex;\" ";
				$js .= "onChange=\"this.options[".$ctrl_name."_v].selected=true;\"";				}
			$txt .= "<select name='$ctrl_name' $disabled $js>";
			$tok = strtok ($this->lb_show_fields[$field_num], ",");
			while( $tok ) {
				$selected = ($tok == $this->values[$field_num])?"selected":"";
			$txt .= "<option value='".$tok."' " .$selected.">".$tok."</option>";						$tok = strtok (",");
			}
		} else if( $this->types[$field_num] == "link_button") {
                        $location = htmlspecialchars($this->lb_key_fields[$field_num]);
                        //Dots are not allowed on the url. Substitue it.
                        $location = str_replace(".", "??", $location);
                        $message = $this->lb_show_fields[$field_num];
                        $title = $this->titles[$field_num];
                        $title = str_pad($title, $this->sizes[$field_num], " ", STR_PAD_BOTH);
			$txt .= "<input type='submit' name='cb_Link_".$location."' $disabled class='bt' value='".$title."' onmouseover=\"window.status='".$message."'\" onmouseout=\"window.status=''\" alt='".$message."'>";
                } else if( $this->types[$field_num] == "radiobox_fixed") {
                        $txt .= $this->titles[$field_num].":<br>";
			if ($readonly)
			{
				$txt .= "<script language='JavaScript'>var ".$ctrl_name."_v=0;</script>";
				$js = "onFocus=\"var max=this.form.$ctrl_name.length;for(var i=0;i<max;i++){if (this.form.".$ctrl_name."[i].checked == true){".$ctrl_name."_v=i;break;}}\" ";
				$js .= "onChange=\"this.form.".$ctrl_name."[".$ctrl_name."_v].checked=true;\" ";
			}
                        $tok = strtok ($this->lb_show_fields[$field_num], ",");
                        while( $tok ) {
                                $selected = ($tok == $this->values[$field_num])?"checked":"";
                        $txt .= "<input type='radio' name='$ctrl_name' $disabled $js value='".$tok."' " .$selected.">".$tok;
                                $tok = strtok (",");
                        }
                }
		else if( $this->types[$field_num] == "ruler")
		{
			$txt .= "<hr width=100%>";
		}
		else if( $this->types[$field_num] == "label")
		{
			$txt .= $this->titles[$field_num];
		}
		$txt .= "</td>";
		print $txt;
		// returns number of colspan
		if ($this->colspans[$field_num] == -1)
			return 999;  //Infinite
		else
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
            print $error_msg[10];
            return false;
        } else {
            setcookie("AuthName",$AuthName,time()+3600);
            setcookie("AuthPasswd",$AuthPasswd,time()+3600);
			return true;
        }
    } else {
		session_start();
		if( !session_is_registered("AuthName") ) {
			print $error_msg[10];
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
global $body_color, $body_background;
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
	if(defined("TAIL_MSG")) $txt .= "<tr><td colspan='2' align='center'>".TAIL_MSG."</td></tr>\n";
	$txt .= "<tr><td>";
	if($print_menu) $txt .= "<a href='menu.php'>Index</a>";
	else if(strlen($back_page)>0) $txt .= $back_page;
	else $txt .= "&nbsp;";
	$txt .= "</td><td align='right'>";
	if(defined("SHOW_LOGO")) $txt .= "<a href='http://www.phpdbform.com'>phpDBform</a><br>\n";
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