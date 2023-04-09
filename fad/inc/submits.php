<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/

//Function to generate a new session
function generate_session(){
	return substr(md5(uniqid(rand(),1)),1,31);
}

//Function to check date format
function is_valid_date($date){
	list($month,$day,$year) = explode("/",$date);
	if($month > 12 || $month < 01 || strlen($month) != 2 || !is_numeric($month)){return false;}
	if($day > 31 || $day < 1|| strlen($day) != 2 || !is_numeric($day)){return false;}
	if(strlen($year) != 4 || !is_numeric($year)){ return false;}
	return true;
}

//Include The Log-in Submission Form
if($_POST['submitid'] == 1){
	if($_POST['userloginid'] == NULL ){ $message = 'Please enter a username';}
	if($_POST['userloginpassword'] == NULL && $message == NULL){ $message = 'Please enter a password';}
	if($message == NULL){
		if($_POST['userloginid'] != $USER_NAME || $_POST['userloginpassword'] != $PASS_WORD){
			$message = 'Invalid username/or password.';
		} else {
			$mkdate  = date("Y-m-d G:i:s");
			$session_id = generate_session();
			$inesrt_user_session = @mysql_query("INSERT INTO `user_sessions` (`session_id`,`user_id`,`session_start`)
				VALUES ('$session_id','1','$mkdate')");				
			$_SESSION['session_id'] = $session_id;
			header("Location: index.php");
			exit();
		}			
	}
}

//Check if the form was submitted from a log-off form
if($_POST['submitid'] == 2){
	$day_less = date("d") -1;
	if($day_less < 0){ $month_less = date("m")-1;} else { $month_less = date("m");}
	if($month_less < 0){ $year_less = date("Y")-1;} else { $year_less = date("Y");}
	$end_session =  date("$year_less-$month_less-$day_less G:i:s");

	$remove_user = @mysql_query("DELETE FROM `user_sessions` WHERE `session_id`='$_SESSION[session_id]' OR
				`session_start` < '$end_session'");
	header("Location: index.php");
	exit();
}

//Check if the form was submitted from add a banner page
if($_POST['submitid'] == 3){
	//Form validation
	if($_POST['group'] == NULL){$message = 'Please choose a group name.';}	
	if(strlen($_POST['name']) < 3 && $message == NULL){$message = 'Please enter a name for the banner';}
	if($_POST['locationtype'] == 'http' && strlen($_POST['httploc']) < 3 && $message == NULL){$message = 'Please enter location url.';}
	if($_POST['locationtype'] == 'upload' && $_FILES['filename']['name'] == NULL && $message == NULL){$message = 'Please enter a filename.';}
	if(strlen($_POST['urlto']) < 3 && $message == NULL){$message = 'Please enter a URL location (to direct to).';}
	if($_POST['stopit'] == 'hits' && !is_numeric($_POST['hits'])  && $message == NULL){ $message = 'Invalid Hit amount to stop on.';}
	if($_POST['stopit'] == 'views' && !is_numeric($_POST['views']) && $message == NULL){ $message = 'Invalid Views amount to stop on.';}
	if($_POST['stopit'] == 'date' && is_valid_date($_POST['id1']) == false && $message == NULL){ $message = 'Invalid date to stop on.';}
	if($_POST['size'] == 'change' && !is_numeric($_POST['width']) && !is_numeric($_POST['height']) && $message == NULL){$message = 'Invalid Width/height.';}
	
	if($message == NULL){
		//Variables that do not need checking, just leave them be
		$java_statusbar = $_POST['status'];	
		$name = $_POST['name'];
		$mouse_over = $_POST['mouseover'];
		$urlto = $_POST['urlto'];
		$flash = $_POST['isflash'];
		$group = $_POST['group'];
			
	
		// Check Which Option Choose, Upload Banner or HTTP Link
		if($_POST['locationtype'] == 'upload'){
			$filename = $_FILES['filename']['name'];
		
			$expload = explode(".",$filename);
			$ext = $expload[count($expload)-1];
			if(is_file($IMAGEFOLDER . $_FILES['filename']['name'])){
				$filename = substr (md5(uniqid(rand(),1)), 3, 5) . '.' .  $ext;
			}
		
		move_uploaded_file($_FILES['filename']['tmp_name'],$IMAGEFOLDER. $filename);
		$location = $IMAGEFOLDER . $filename;
		} else {
			$location = $_POST['httploc'];
		}
		// Check When To Stop The Banner From Appearing
		if($_POST['stopit'] == 'ignore'){
			$stopit = 'OFF';
		}
		if($_POST['stopit'] == 'hits'){
			$stopit = 'H,' . $_POST['hits'];
		}
		if($_POST['stopit'] == 'views'){
			$stopit = 'V,' . $_POST['views'];
		}
		if($_POST['stopit'] == 'date'){
			$stopit = 'D,' . $_POST['id1'];
		}
	
		// Check the prefereed Size of the Banner
		if($_POST['size'] == 'leave'){
			$size = 'NORMAL';
		}
	
		// Check Window Openeing mode
		if($_POST['openin'] == 'new'){
			$openin = '_blank';
		} else {
			$openin = '_parent';
		}
	
		//Finally Add the banner to the database
		$banner_insert_query  = @mysql_query("INSERT INTO banners (`name`,`mouseover`,`location`,`urlto`,`stopit`,`java_status`,`openin`)
					VALUES ('$name','$mouse_over','$location','$urlto','$stopit','$java_statusbar','$openin')");
		// Check If Results Ok, if Yes Insert Stats information

		if($banner_insert_query){
			$made = date('m') . '/' . date('d') . '/' . date('Y');
			if($size == 'NORMAL'){
				$width = 'NA';
				$height = 'NA';
			} else {
				$width = $_POST['width'];
				$height = $_POST['height'];
			}
			$hits = 0;
			$uni_hits = 0;
			$views = 0;
			$uni_views = 0;
			$get_banner_id = @mysql_fetch_array(@mysql_query("SELECT * FROM `banners` ORDER BY `id` DESC"));
			
			$stat_insert_query = @mysql_query("INSERT INTO stats (`id`,`made`,`file_location`,`width`,`length`,`hits`,`uni_hits`,`views`,`uni_views`,`flash`,`group`)
							VALUES ('$get_banner_id[0]','$made','$location','$width','$height','$hits','$uni_hits','$views','$uni_views','$flash','$group')");
		}
		//If everything is complete give appropraite message
		if($stat_insert_query){
			$message = 'Banner: <font color="blue">' . $name . '</font>. Has Been Successfully Installed. The Banner ID is: <font color="blue">' . $get_banner_id[0] . '</font>';
			$_POST = NULL;
		} else {
			$message = 'An Error Occured While Processing Banner, Please Check Your Settings and Ensure that the Database is Setted up!';
		}
	}
}

//Check if the form was submitted from a view or edit banner form
if($_POST['submitid'] == 4){
	if($_POST['reason'] == 'view'){
		$id = $_POST['viewme'];
		header("Location: viewme.php?id=" . $id);
		exit();
	}
	if($_POST['reason'] == 'edit'){
		$id = $_POST['editme'];
		header("Location: editme.php?id=" . $id);
		exit();
	} 
	
}

//Check If a banner was edited
if($_POST['submitid'] == 5){
	//Form validation
	if($_POST['group'] == NULL){$message = 'Please choose a group name.';}	
	if(strlen($_POST['name']) < 3 && $message == NULL){$message = 'Please enter a name for the banner';}
	if($_POST['locationtype'] == 'http' && strlen($_POST['httploc']) < 3 && $message == NULL){$message = 'Please enter location url.';}
	if($_POST['locationtype'] == 'upload' && $_FILES['filename']['name'] == NULL && $message == NULL){$message = 'Please enter a filename.';}
	if(strlen($_POST['urlto']) < 3 && $message == NULL){$message = 'Please enter a URL location (to direct to).';}
	if($_POST['stopit'] == 'hits' && !is_numeric($_POST['hits'])  && $message == NULL){ $message = 'Invalid Hit amount to stop on.';}
	if($_POST['stopit'] == 'views' && !is_numeric($_POST['views']) && $message == NULL){ $message = 'Invalid Views amount to stop on.';}
	if($_POST['stopit'] == 'date' && is_valid_date($_POST['id1']) == false && $message == NULL){ $message = 'Invalid date to stop on.';}
	if($_POST['size'] == 'change' && !is_numeric($_POST['width']) && !is_numeric($_POST['height']) && $message == NULL){$message = 'Invalid Width/height.';}
	
	if($message == NULL){
		//Variables that do not need checking, just leave them b
		$java_statusbar = $_POST['status'];	
		$name = $_POST['name'];
		$mouse_over = $_POST['mouseover'];
		$urlto = $_POST['urlto'];
		$flash = $_POST['isflash'];
		$group = $_POST['group'];
		// Check Which Option Choose, Upload Banner or HTTP Link
		if($_POST['locationtype'] == 'upload'){
			$filename = $_FILES['filename']['name'];
		
			$expload = explode(".",$filename);
			$ext = $expload[count($expload)-1];
			if(is_file($IMAGEFOLDER . $_FILES['filename']['name'])){
				$filename = substr (md5(uniqid(rand(),1)), 3, 5) . '.' .  $ext;
			}
		
		move_uploaded_file($_FILES['filename']['tmp_name'],$IMAGEFOLDER. $filename);
		$location = $IMAGEFOLDER . $filename;
		} else {
			$location = $_POST['httploc'];
		}
	
		// Check When To Stop The Banner From Appearing
		if($_POST['stopit'] == 'ignore'){
			$stopit = 'OFF';
		}
		if($_POST['stopit'] == 'hits'){
			$stopit = 'H,' . $_POST['number'];
		}
		if($_POST['stopit'] == 'views'){
			$stopit = 'V,' . $_POST['number'];
		}
		if($_POST['stopit'] == 'date'){
			$stopit = 'D,' . $_POST['id1'];
		}
		// Check the prefereed Size of the Banner
		if($_POST['size'] == 'leave'){
			$size = 'NORMAL';
		}

		// Check Window Openeing mode
		if($_POST['openin'] == 'new'){
			$openin = '_blank';
		} else {
			$openin = '_parent';
		}
	
		//Update the banner (check first if we have changed the location)
		if($location != NULL){
			$update_banner  = @mysql_query("UPDATE banners SET `name`='$name' , `mouseover`='$mouse_over', `location`='$location',
					`urlto`='$urlto',`stopit`='$stopit',`java_status`='$java_statusbar',`openin`='$openin' WHERE `id`='$id'");
		} else {
			$update_banner  = @mysql_query("UPDATE banners SET `name`='$name' , `mouseover`='$mouse_over', `urlto`='$urlto',`stopit`='$stopit',
					`java_status`='$java_statusbar',`openin`='$openin' WHERE `id`='$id'");
		}
		if($update_banner){
			$made = date('m') . '/' . date('d') . '/' . date('Y');
			if($size == 'NORMAL'){
				$width = 'NA';
				$height = 'NA';
			} else {
				$width = $_POST['width'];
				$height = $_POST['height'];
			}
			
			$get_stat = @mysql_fetch_array(@mysql_query("SELECT * FROM stats WHERE id='$id'"));
			$currentgroup = $get_stat[10];
			$hits = $get_stat[5];
			$uni_hits = $get_stat[6];
			$views = $get_stat[7];
			$uni_views = $get_stat[8];
		
			if($location != NULL){
				$update_stat = @mysql_query("UPDATE stats SET `made`='$made',`file_location`='$location',`width`='$width',`length`='$height',`hits`='$hits',`uni_hits`='$hits',`views`='$views',`uni_views`='$uni_views',`flash`='$flash',`group`='$group' WHERE `id`='$id'");
			} else {
				$update_stat = @mysql_query("UPDATE stats SET `made`='$made',`width`='$width',`length`='$height',`hits`='$hits',`uni_hits`='$hits',`views`='$views',`uni_views`='$uni_views',`flash`='$flash',`group`='$group' WHERE `id`='$id'");
			}	

			//If everything is complete give appropraite message
			if($update_stat){
				$message = 'Banner: <font color="blue">' . $name . '</font> Has Been Successfully Edited.';
				header("Location: editbanner.php");
			} else {
				$message = 'An Error Occured While Processing Banner, Please Check Your Settings and Ensure that the Database is Setted up!';
			}
		}
	}
}

//Check if a Banner Was Removed
if($_POST['submitid'] == 6){

	$removeid = $_POST['removeme'];

	$get_stat = @mysql_fetch_array(@mysql_query("SELECT * FROM `stats` WHERE `id`='$removeid'"));
	$groupname = $get_stat[10];
	

	$get_banner = @mysql_fetch_array(@mysql_query("SELECT * FROM `banners` WHERE `id`='$removeid'"));

	$name = $get_banner[1];
	$location= explode('/',$get_banner[3]);

	if($location[0] == 'images'){
		unlink($get_banner[3]);
	}

	$query = @mysql_query("DELETE FROM `banners` WHERE `id`='$removeid'");

	$query = @mysql_query("DELETE FROM `banner_view_ip` WHERE `id`='$removeid'");
	
	$query = @mysql_query("DELETE FROM `banner_hit_ip` WHERE `id`='$removeid'");
	
	$query = @mysql_query("DELETE FROM `stats` WHERE `id`='$removeid'");

	if($query){
		$message = 'Banner: <font color="blue">' . $name . '</font>. Has Been Successfully REMOVED. The Banner ID Was: <font color="blue">' . $delete . '</font>';
	} else {
		$message = 'Critical Error, Unable to Access Database';
	}
}

//Check if a Banner Group Was Added
if($_POST['submitid'] == 7){
	$groupname = $_POST['groupname'];
	if(strlen($groupname) < 3){$message = 'Please enter a group name.';}
	if($message == NULL){
	
		$check_name = @mysql_query("SELECT * FROM banner_group WHERE `group_name`='$groupname'");
	
		if(@mysql_num_rows($check_name) <= 0){
			$insert_group = @mysql_query("INSERT INTO banner_group (`group_name`) VALUES ('$groupname')");
		  
			 if($insert_group){
			 	$message = 'Group Name: ' . $groupname . ' Has Been Successfully Added';
			 } else {
			 	$message = 'An Error Occured While Processing Request, Please Check Database Connection and Setup!';
			 }
		} else {
			$message = 'Group Name: ' . $groupname . ' Already Exists, Please Choose A Different One!';
		}
	}
}

//Check if a Banner Group Was remove
if($_POST['submitid'] == 8){
	$group = $_POST['group'];
	if($group != NULL){
		$check_banners = @mysql_query("SELECT * FROM stats WHERE `group` = '$group'");
	
		if(@mysql_num_rows($check_banners) <= 0){
			$remove_group = @mysql_query("DELETE FROM `banner_group` WHERE `group_name`='$group' LIMIT 1");
			
			if($remove_group){
			$message = 'Group Name: ' . $group . ' Has Been Removed!';
			} else {
				$message = 'Internal Error, Please Check Database Connection and Set-up Information!';
			}
		} else {
			$message = 'Group Name: ' . $group . ' Can Not Be Removed Because It Has Banners Associated With It, Please Remove Them Before Removing The Group!';
		}
	}
}

//Check if a Counter was added
if($_POST['submitid'] == 9){
	if(strlen($_POST['name']) < 3){$message = 'Please enter a counter name.';}
	if(!is_numeric($_POST['start']) && $message == NULL){$message = 'Please enter a valid count.';}
	if($message == NULL){
		$name = $_POST['name'];
		$start = $_POST['start'];
		$type = $_POST['type'];
		$viewable = $_POST['view'];
		$unique = $_POST['unique'];
	
		$check_name = @mysql_query("SELECT * FROM counter_list WHERE `name`='$name'");
		$check_name_exist_num = @mysql_num_rows($check_name_exist_result);
	
		if(@mysql_num_rows($check_name) <= 0){
			$insert_counter = @mysql_query("INSERT INTO `counter_list` (`name`,`type`,`viewable`,`unique`,`u_hits`,`all_hits`)
					VALUES ('$name','$type','$viewable','$unique','$start','$start')");
			$get_counter_id = @mysql_fetch_array(@mysql_query("SELECT * FROM `counter_list` ORDER BY `id` DESC"));
			
			//Insert Tracking Properties
			$countries = @mysql_query("INSERT INTO `counters_countries` (`id`) VALUES ('$get_counter_id[0]')");
	
			$systems = @mysql_query("INSERT INTO `counter_system` (`id`) VALUES ('$get_counter_id[0]')"); 
		
			$browsers = @mysql_query("INSERT INTO counter_browser (`id`) VALUES ('$get_counter_id[0]')"); 
		
			if($browsers){
				$message = 'Counter Name: ' . $name . ' Has Been Installed. The Counter ID Is: ' . $get_counter_id[0]; 
			} else {
				$message = 'Internal Error, Please Check Database Conenction and Configure File';
			}
		
		} else {
			$message = 'Counter Name: ' . $name . ' Already Exists, Please Choose A Different Name';
		}
	}
}
//Check if a Counter was edited or viewed
if($_POST['submitid'] == 10){
	if($_POST['reason'] == 'view'){
		$id = $_POST['viewme'];
		header("Location: viewmec.php?id=" . $id);
		exit();
	}
	if($_POST['reason'] == 'edit'){
		$id = $_POST['editme'];
		header("Location: editmec.php?id=" . $id);
		exit();
	} 
}
//Check if a Counter was removed
if($_POST['submitid'] == 11){
	$id = $_POST['removeme'];
	
	$get_the_name = @mysql_fetch_array(@mysql_query("SELECT * FROM `counter_list` WHERE `id`='$id'"));
		
	$remove_ips = @mysql_query("DELETE FROM `counter_ip` WHERE `id`='$id'");
	
	$remove_countries = @mysql_query("DELETE FROM `counters_countries` WHERE `id`='$id'");
	
	$remove_system =  @mysql_query("DELETE FROM `counter_system` WHERE `id`='$id'");

	$remove_broswer =  @mysql_query("DELETE FROM `counter_browser` WHERE `id`='$id'");
	
	$remove_counter =  @mysql_query("DELETE FROM `counter_list` WHERE `id`='$id'");
	
	if($remove_counter){
		$message = 'Banner ID: ' . $id . ', Name: ' . $get_the_name[1] . ' Has Been Removed';
	} else {
		$message = 'Internal Error, Please Check Settings and Database Connections';
	}
}
//Check if a Counter was actually edited
if($_POST['submitid'] == 12){
	if(strlen($_POST['name']) < 3){$message = 'Please enter a counter name.';}
	if(!is_numeric($_POST['u_hits']) && $message == NULL){$message = 'Please enter a valid Unique Hits.';}
	if(!is_numeric($_POST['all_hits']) && $message == NULL){$message = 'Please enter a valid All Hits.';}
	if($message == NULL){
		$id = $_POST['id'];
	
		$name = $_POST['name'];
		$start = $_POST['start'];
		$type = $_POST['type'];
		$viewable = $_POST['view'];
		$unique = $_POST['unique'];
		$u_hits = $_POST['u_hits'];
		$all_hits = $_POST['all_hits'];
		
		$update_counter = @mysql_query("UPDATE `counter_list` SET `name`='$name',`type`='$type',`viewable`='$viewable',`unique`='$unique',
				`u_hits`='$u_hits',`all_hits`='$all_hits' WHERE `id`='$id'");
		if($update_counter){
			$message = 'Counter Name: ' . $name . ' , ID Number: ' . $id . ' Has Been Updated';
			header("Location: editcounter.php");
		} else {
			$message = 'Internal Error, Please Check Database Connection and Configure Information';
		}	
	}
}

//Check if a referal was added
if($_POST['submitid'] == 13){
	if($_POST['name'] == NULL){$message = 'Please enter a name.';}
	if($message == NULL){
		$name = $_POST['name'];
		$make = date('m') . '/' . date('d') . '/' . date('Y');
		$hits = 0;
		$credits = 0;
		if($_POST['urlkind'] == 'main'){
			$urlto = 'Main';
		} else {
			$urlto = $_POST['urlto'];
		}
		
		$check_name = @mysql_num_rows(@mysql_query("SELECT * FROM `referrals` WHERE `name`='$name'"));
		
		if($check_name <= 0){
			$insert_ref = @mysql_query("INSERT INTO `referrals` (`name`,`urlto`,`hits`,`credits`,`make`) VALUES ('$name','$urlto','$hits','$credits','$make')");
			$get_id = @mysql_fetch_array(@mysql_query("SELECT * FROM `referrals` ORDER BY `id` DESC"));
			if($insert_ref){
				$message = 'Referral Name: ' . $name . ' Has Been Added
				<p>The Referral Link For This Referral (Which Can Be Viewed Later On Fom The Referral Stats) Is:</p>
				<p>' . $SITE_DIR . $FAD_DIR . 'ctchrefscr.php?sessionid=' . $get_id[0] . '</p>';
			} else {
				$message = 'Internal Error, Please Check Database Conection and Configure Information';
			}
		} else {
			$message = 'Referral name: ' . $name . ' already exists, please choose a different one';
		}
	}
}
//Check if a referral was edited or viewed
if($_POST['submitid'] == 14){
	if($_POST['reason'] == 'view'){
		$id = $_POST['viewme'];
		header("Location: viewmer.php?id=" . $id);
		exit();
	}
	if($_POST['reason'] == 'edit'){
		$id = $_POST['editme'];
		header("Location: editmer.php?id=" . $id);
		exit();
	} 
}

//Check if a referral was actually edited
if($_POST['submitid'] == 15){
	if($_POST['name'] == NULL){$message = 'Please enter a name.';}
	if($_POST['urlto'] == NULL && $message == NULL){$message = 'Please enter a redirect to url.';}
	if(!is_numeric($_POST['hits']) && $message == NULL){$message = 'Invalid hits count.';}
	if(!is_numeric($_POST['credits']) && $message == NULL){$message = 'Invalid hits count.';}
	if(is_valid_date($_POST['make']) == false && $message == NULL){$message = 'Invalid date entred.';}
	if($message == NULL){
		$name = $_POST['name'];
		$make = $_POST['make'];
		$hits = $_POST['hits'];
		$credits = $_POST['credits'];
		$id = $_POST['id'];
	
		if($_POST['urlto'] == $SITE_DIR){
			$urlto = 'Main';
		} else {
			$urlto = $_POST['urlto'];
		}
	
		$update_ref = @mysql_query("UPDATE `referrals` SET `id`='$id',`name`='$name',`urlto`='$urlto',`hits`='$hits',
			`credits`='$credits',`make`='$make' WHERE `id`='$id'");
	
		if($update_ref){
			$message = 'Referral Name: ' . $name . ' Has Been Updated';
			header("Location: editref.php");
			exit();
		} else {
			$message = 'Internal Error, Please Check Database Conection and Configure Information';
		}
	}
}

//Check if a referral was removed
if($_POST['submitid'] == 16){
	$id = $_POST['removeme'];

	//Get Info
	$get_name = @mysql_fetch_array(@mysql_query("SELECT * FROM `referrals` WHERE`id`='$id'"));
	$name = $get_name[1];
	
	//Delete
	$remove_ref = @mysql_query("DELETE FROM `referrals` WHERE `id`='$id'");
	
	if($remove_ref){
		$message = 'Referral ID: ' . $id . ',Name: ' . $name . ' Was Removed';
	} else {
		$message = 'Internal Error, Please Check Database Conection and Configure Information';
	}
}

//Check if the form was submitted from a form-login generatoe (form validation)
if($_POST['submitid'] == 17){
	if($_POST['dest'] == NULL){$message = 'Please enter a desination page.';}
	if(!is_numeric($_POST['time']) && $message == NULL){$message = 'Please enter a valid session length.';}
	if($message == NULL){
		if($_POST['username'] != NULL || $_POST['password'] != NULL){
			if($_POST['hostname'] != NULL || $_POST['dataname'] != NULL || $_POST['dusername'] != NULL
				|| $_POST['dpassword'] != NULL || $_POST['tablenames'] != NULL || $_POST['field1'] != NULL 
				|| $_POST['field2'] != NULL){
				$message = 'Please either enter a username/password or enter database information.';
			}
		} else {
			if($_POST['hostname'] == NULL || $_POST['dataname'] == NULL || $_POST['dusername'] == NULL
				|| $_POST['dpassword'] == NULL || $_POST['tablenames'] == NULL || $_POST['field1'] == NULL 
				|| $_POST['field2'] == NULL){
				$message = 'Please either enter a username/password or enter database information - Insure all fields are completed.';
			}
		}
	}
	if($message == NULL){
		$disabled = 'disabled';
		$message = 'Please insure that all information is correct, then click on create script.';
		$_SERVER['PHP_SELF'] = 'securemand.php';
		$_POST['submitid'] = 18;
	} else {
		$disabled = '';
	}
}

//Check if the form was submitted from a form-login generatoe (process form)
if($_POST['submitid'] == 18){
	include_once("inc/secure_submit.php");
}
?>