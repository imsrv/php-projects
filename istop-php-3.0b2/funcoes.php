<?
function logou(){
	if(SESSION_IS_REGISTERED('info') and !empty($_SESSION['info']['Id'])){
		return True;
	}
	return False;
}

function sql_assoc_ar($obj){
	while($ar=$obj->fetchRow()){
		$return[$ar[0]]=$ar[1];
	}
	return $return;
}

function valid_mail($mail){
        if(!ereg("^[a-zA-Z0-9\-\_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$",$mail)){
                return False;
        }
        return True;
}

function form_info($ini,$ar){
        foreach($ar as $k=>$v){
                $quote="^".quotemeta($ini);
                if(ereg($quote,$k))
                        $return[$k]=trim($v);
        }
        return $return;
}

function start_db(){
	require_once ('DB.php');
	$db = DB::connect('mysql://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME);
	if (DB::isError($db)) {
		die ($db->getMessage());
	}

	return $db;
}

function aut_admin(){
	@SESSION_START();
	if($_POST['isac']=='logon'){
		SESSION_UNSET();
		$is_auth_user=$_POST['user'];
		$is_auth_senha=$_POST['senha'];
		if($is_auth_user==ADMIN_USER and $is_auth_senha==ADMIN_SENHA){
			SESSION_REGISTER('is_auth_user');
			SESSION_REGISTER('is_auth_senha');
			header('Location: index.php');
		}else
			header('Location: aut.htm');

		exit;
	}elseif(!session_is_registered('is_auth_user') or !session_is_registered('is_auth_senha')){
		header('Location: aut.htm');
		exit;
	}
}

function show_table($ar,$titulo,$id=NULL){
	$atr['bs']=array('style'=>"font-family: verdana, arial; font-size: 8 pt; text-align: center");
	$atr['cels']=array('bgcolor'=>"#DDFFDD");
	$atr['celtt']=array('bgcolor'=>"#CECEFF",
					'style'=>"font-family: verdana, arial; font-size: 8 pt;  font-weight: bold; text-align: center");
	$atr['all']=array('cellpadding'=>2,'style'=>"border: 1 solid #C0C0C0, text-align: center");
	$table = new HTML_Table($atr['all']);
	$table->setCellContents(0,0,'Log - '.$titulo);
	for($n=0, $m=0;$n<count($ar);$n++){
		$arb=explode("|",$ar[$n]);

		if($id==NULL or $id==$arb[0]){
			$table->setCellContents($m+1,0,$arb[0]);
			$table->setCellContents($m+1,1,$arb[1]);
			$ard=getdate($arb[2]);
			$hs=sprintf("%'02.2s:%'02.2s:%'02.2s",$ard['hours'],$ard['minutes'],$ard['seconds']);

			$table->setCellContents($m+1,2,$hs);
			$m++;
		}
	}
	$table->setAllAttributes($atr['bs']);
	$table->updateAllAttributes($atr['cels']);
	$table->updateCellAttributes(0,0,' colspan=3');
	$table->updateCellAttributes(0,0,$atr['celtt']);
	echo '<div align="center">'.$table->toHtml().'</div><br>';
}

?>