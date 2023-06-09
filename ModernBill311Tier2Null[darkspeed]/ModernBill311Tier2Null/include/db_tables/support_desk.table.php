<?
/*
** ModernBill [TM] (Copyright::2001)
** Questions? webmaster@modernbill.com
**
**
**          Always save a backup before your upgrade!
**          Proceed with caution. You have been warned.
*/

      $title = SUPPORTDESK;
      $parent = array(1=>"client_info");
      $children = array("support_log");
      $args = array(array("column"         => "call_id",
                           "required"      => 0,
                           "title"         => ID,
                           "type"          => "HIDDEN"),
                    array("column"         => "client_id",
                           "required"      => 1,
                           "title"         => CLIENT,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => client_select_box($client_id),
                           "link_to_parent"=> 1,
                           "parent_op"     => "client_details"),
                    array("column"         => "call_priority",
                           "required"      => 1,
                           "title"         => PRIORITY,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => priority_select_box($call_priority)),
                    array("column"         => "call_type",
                           "required"      => 1,
                           "title"         => TYPE,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => support_type_menu($call_type)),
                    array("column"         => "call_subject",
                           "required"      => 1,
                           "title"         => SUBJECT,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 255),
                    array("column"         => "call_question",
                           "required"      => 1,
                           "title"         => QUESTION,
                           "type"          => "TEXTAREA",
                           "rows"          => $textarea_rows,
                           "cols"          => $textarea_cols,
                           "wrap"          => $textarea_wrap,
                           "cuttext"       => 30),
                    array("column"         => "call_error",
                           "required"      => 0,
                           "title"         => ERROR,
                           "type"          => "TEXTAREA",
                           "rows"          => $textarea_rows,
                           "cols"          => $textarea_cols,
                           "wrap"          => $textarea_wrap,
                           "cuttext"       => 30),
                    array("column"         => "call_stamp",
                           "required"      => 1,
                           "title"         => TIMESTAMP,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => date_input_generator($call_stamp,"call_stamp")),
                    array("column"         => "call_status",
                           "required"      => 1,
                           "title"         => STATUS,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => call_status_select_box($call_status)),
                    array("column"         => "call_response",
                           "required"      => 1,
                           "title"         => RESPONSE,
                           "type"          => "TEXTAREA",
                           "rows"          => $textarea_rows,
                           "cols"          => $textarea_cols,
                           "wrap"          => $textarea_wrap,
                           "cuttext"       => 30),
                    array("column"         => "call_technician",
                           "required"      => 1,
                           "title"         => TECH,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => admin_select_box($call_technician,"call_technician")));

      $select_sql = "SELECT call_id,
                            client_id,
                            call_priority,
                            call_type,
                            call_subject,
                            call_status,
                            call_technician,
                            call_stamp FROM $db_table ";

      $insert_sql = "INSERT INTO $db_table (call_id,
                                            client_id,
                                            call_priority,
                                            call_type,
                                            call_subject,
                                            call_question,
                                            call_error,
                                            call_stamp,
                                            call_status,
                                            call_response,
                                            call_technician) VALUES (NULL,
                                                                     '$client_id',
                                                                     '$call_priority',
                                                                     '$call_type',
                                                                     '$call_subject',
                                                                     '$call_question',
                                                                     '$call_error',
                                                                     '".mktime()."',
                                                                     '$call_status',
                                                                     '$call_response',
                                                                     '$call_technician')";

      $update_sql = "UPDATE $db_table SET client_id='$client_id',
                                          call_priority='$call_priority',
                                          call_type='$call_type',
                                          call_subject='$call_subject',
                                          call_question='$call_question',
                                          call_error='$call_error',
                                          call_stamp='".mktime()."',
                                          call_status='$call_status',
                                          call_response='$call_response',
                                          call_technician='$call_technician' WHERE call_id='$call_id'";

      $delete_sql = array("DELETE FROM $db_table WHERE call_id='$call_id'",
                          "DELETE FROM support_log WHERE call_id='$call_id'");
?>