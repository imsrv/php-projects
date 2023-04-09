<?
	if(1==2){
		echo "SCRIPT_NAME=<b>".$_SERVER[SCRIPT_NAME]."</b><br>";
		echo "REMORE_ADDR=<b>".$_SERVER[REMOTE_ADDR]."</b><br>";
		echo "HTTP_REFERER=<b>".$_SERVER[HTTP_REFERER]."</b><br>";
		echo "SERVER_NAME=<b>".$_SERVER[SERVER_NAME]."</b><br>";
		echo "SERVER_PORT=<b>".$_SERVER[SERVER_PORT]."</b><br>";
		echo "REQUEST_METHOD=<b>".$_SERVER[REQUEST_METHOD]."</b><br>";
		echo "QUERY_STRING=<b>".$_SERVER[QUERY_STRING]."</b><br>";

		exit;	
	}
	if(($_SERVER['SCRIPT_NAME']=='/emlakadamlar/admin/index.php')or($_SERVER['SCRIPT_NAME']=='/admin/index.php')or($_SERVER['SCRIPT_NAME']=='/index.php')or($_SERVER['SCRIPT_NAME']=='/emlakadamlar/index.php')){
		//ok
	}else{
		//showMessage("Hatalý eriþim");
		//goTo("index.php");
		exit;
	}
?>