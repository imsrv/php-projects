<?php

//define ("PB_CRYPT_LINKS" , "1");

function DoEvents($this) {
	global $_CONF , $_TSM;

	$_TSM["MENU"] = "";

	//checking if user is logged in
	if (!$_SESSION["minibase"]["user"]) {

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			//autentificate
			$user = $this->db->QFetchArray("select * from {$this->tables[users]} where `user_login` = '{$_POST[user]}' AND `user_password` = '{$_POST[pass]}'");

			if (is_array($user)) {
				$_SESSION["minibase"]["user"] = 1;
				$_SESSION["minibase"]["raw"] = $user;

				//redirecing to viuw sites
				header("Location: $_CONF[default_location]");
				exit;
			} else
				return $this->templates["login"]->blocks["Login"]->output;

		} else
			return $this->templates["login"]->blocks["Login"]->output;
	}
	if ($_SESSION["minibase"]["raw"]["user_level"] == 0) {
		$_TSM["MENU"] = $this->templates["login"]->blocks["MenuAdmin"]->output;
	} else {
		$_TSM["MENU"] = $this->templates["login"]->blocks["MenuUser"]->output;
	}

	if (!$_POST["task_user"])
		$_POST["task_user"] = $_SESSION["minibase"]["user"];

	if($_SESSION["minibase"]["raw"]["user_level"] == 1) {
		$_CONF["forms"]["adminpath"] = $_CONF["forms"]["userpath"];
	}

	switch ($_GET["sub"]) {
		case "logout":
			unset($_SESSION["minibase"]["user"]);
			header("Location: index.php");

			return $this->templates["login"]->EmptyVars();
		break;

		case "export":

			$project = $this->db->QFetchArray("SELECT * FROM {$this->tables[projects]} WHERE project_id='$_GET[project_id]'");

			if (!is_array($project)) {
				header("Location: index.php?sub=projects");
				exit;
			} else {
				//read all the tasks
				$_task_cats = $this->db->QFetchRowArray("SELECT * FROM {$this->tables[taskcats]}");
				if (is_array($_task_cats)) {
					foreach ($_task_cats as $key => $val) 
						$task_cats[$_val["cat_id"]] = $val["cat_name"];
				}

				$_task_status = $this->db->QFetchRowArray("SELECT * FROM {$this->tables[taskstatus]}");
				if (is_array($_task_status)) {
					foreach ($_task_status as $key => $val) 
						$task_status[$_val["status_id"]] = $val["status_name"];
				}

				header("Content-Type: text/x-csv");
				header("Content-Disposition: inline; filename=" . urlencode($project["project_name"]) .".csv");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Pragma: public");

				echo 'id,Project,"Task Title","Task Description","Start Date","Estimated Completion Date","Completed Date","Task Category","Task Status"' . "\n";

				//now read the tasjs
				$tasks = $this->db->QFetchRowArray("SELECT * FROM {$this->tables[tasks]} WHERE task_project='{$_GET[project_id]}'");
				if (is_array($tasks)) {
					$id = 1;
					foreach ($tasks as $key => $val) {
						echo $id . "," .
						(strstr($project["project_name"] , " ") ? '"' . $project["project_name"] . '"' : $project["project_name"]) . "," .
						(strstr($val["task_name"] , " ") ? '"' . $val["task_name"] . '"' : $val["task_name"]) . "," .
						(strstr($val["task_description"] , " ") ? '"' . $val["task_description"] . '"' : $val["task_description"]) . "," .
						"\"" . ($val["task_date"] > 0 ? date("m.d.Y g:i a",$val["task_date"]) : "not available") . "\"," . 
						"\"" . ($val["date_ecompleted"] > 0 ? date("m.d.Y g:i a",$val["date_ecompleted"]) : "not available"). "\"," . 
						"\"" . ($val["date_completed"] > 0 ? date("m.d.Y g:i a",$val["date_completed"]) : "not available" ). "\"," . 
						(strstr($task_cats[$val["task_cat"]] , " ") ? '"' . $task_cats[$val["task_cat"]] . '"' : $task_cats[$val["task_cat"]]) . "," .
						(strstr($task_status[$val["task_status"]] , " ") ? '"' . $task_status[$val["task_status"]] . '"' : $task_status[$val["task_status"]]) . "" . "\n";
		
						$id++;
					}
					
				}

				die;
			}			

		break;

		case "copy":
			$data = new CForm($_CONF["forms"]["admintemplate"],$this->db,$this->tables);

			if ($_SERVER["REQUEST_METHOD"] == "GET") {

				$project = $this->db->QFetchArray("SELECT * FROM {$this->tables[projects]} WHERE project_id='$_GET[project_id]'");

				if (!is_array($project)) {
					header("Location: index.php?sub=projects");
					exit;
				} else {
						$values["values"]["project_name"] = $project["project_name"] . " (copy)";
				}			
			}

			if ($_GET["action"] == "store") {
				if (is_array($values = $data->Validate($_CONF["forms"]["adminpath"] . $file,$_POST))) {

					return $data->Show($_CONF["forms"]["adminpath"] . "copy.xml", $values);
				} else {
					//do the nasty things hercopy and redirect to the project details
					$project = $this->db->QFetchArray("SELECT * FROM {$this->tables[projects]} WHERE project_id='{$_POST[project_id]}'");
					$tasks = $this->db->QFetchRowArray("SELECT * FROM {$this->tables[tasks]} WHERE task_project='{$_POST[project_id]}'");

					unset($project["project_id"]);
					$project["project_name"] = $_POST["project_name"];

					$id = $this->db->QueryInsert($this->tables["projects"] , $project);

					if (is_array($tasks)) {
						foreach ($tasks as $key => $val) {
							unset($val["task_id"]);
							$val["task_project"] = $id;
							$val["task_date"] = $val["date_completed"] = $val["date_ecompleted"] = 0;

							$this->db->QueryInsert($this->tables["tasks"] , $val);
						}						
					}
					

					header("Location: index.php?sub=projects&action=details&project_id={$id}");
					exit;
				}
			} else 
				return $data->Show($_CONF["forms"]["adminpath"] . "copy.xml", $values);
		break;

		case "projects":
		case "tasks":	
		case "tasks2":
		case "taskcats":
		case "taskstatus":
		case "comments":
		case "last":

			if ($_SERVER["REQUEST_METHOD"] != "POST") {
				$_POST["comment_user"] = $_SESSION["minibase"]["raw"]["user_id"];
				$_POST["comment_date"] = time();
			}

			if (($_GET["sub"] == "projects") && ($_GET["action"] == "delete")) {
				//delete the comments and the tasks
			
				$tasks = $this->db->QFetchRowArray("SELECT * FROM {$this->tables[tasks]} WHERE task_project='{$_GET[project_id]}'");

				if (is_array($tasks)) {
					foreach ($tasks as $key => $val) {
						$this->db->Query("DELETE FROM {$this->tables[taskcomments]} WHERE comment_task='{$val[task_id]}'");
					}						
				}
				$this->db->Query("DELETE FROM {$this->tables[tasks]} WHERE task_project='{$_GET[project_id]}'");
			}

			if (($_GET["sub"] == "projects") && ($_GET["action"] == "details")) {
				$task = new CSQLAdmin("tasks", $_CONF["forms"]["admintemplate"],$this->db,$this->tables , $extra);
				$extra["details"]["after"] = $task->DoEvents();				

				$task = new CSQLAdmin("tasks2", $_CONF["forms"]["admintemplate"],$this->db,$this->tables , $extra);
				$extra["details"]["after"] .= $task->DoEvents();				

			}

			if (($_GET["sub"] == "tasks") && ($_GET["action"] == "det")) {
				$comments = new CSQLAdmin("comments", $_CONF["forms"]["admintemplate"],$this->db,$this->tables , $extra);
				$extra["details"]["after"] = $comments->DoEvents();				
			}

			$data = new CSQLAdmin($_GET["sub"], $_CONF["forms"]["admintemplate"],$this->db,$this->tables , $extra);
			return $data->DoEvents("","",$_POST);
		break;

		case "users":
			
			if ((!$_GET["action"])&&($_SESSION["minibase"]["raw"]["user_level"] != 0 )) {
				$_GET["action"] = "details";				
			}

			if ($_SESSION["minibase"]["raw"]["user_level"] == 1) {
				$_GET["user_id"] = $_SESSION["minibase"]["raw"]["user_id"]; 
				$_POST["user_id"] = $_SESSION["minibase"]["raw"]["user_id"];
			}
			
			$data = new CSQLAdmin($_GET["sub"], $_CONF["forms"]["admintemplate"],$this->db,$this->tables);
			return $data->DoEvents();
		break;

	}
}

?>