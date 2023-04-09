<?

function MakeAdminLink($Page, $SessionId = ""){
	GLOBAL $SID, $ROOTURL;

	if($SessionId != "")
		$SID = $SessionId;

	if(substr_count($Page, "?")>0){
		$Page=$ROOTURL."admin/index.php/$Page&SID=$SID";
	}else{
		$Page=$ROOTURL."admin/index.php/$Page?SID=$SID";
	}
	return $Page;
}

function Encrypt($Password){
	return md5($Password);
}

function FinishOutput(){
	GLOBAL $OUTPUT, $t, $SECTIONS,$DIRSLASH,$ROOTDIR,$Page;
	include "includes/admin.inc.php";
}



?>