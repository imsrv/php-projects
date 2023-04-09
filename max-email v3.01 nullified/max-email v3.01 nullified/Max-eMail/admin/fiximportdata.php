<HTML>
<TITLE>Import Data Fixer!</TITLE>
<HEAD>
<style type="text/css">
   .sidebarlinks{font-size:12; text-decoration:none; color:black}
   .formtext{font-size:12; text-decoration:none; color:black}
   .admintext{font-size:12; text-decoration:none; color:black}
   .inputfields{border-style:box;border-width:1;font-size:12;background-color:#FFFFF4}
</style>
</HEAD>
<BODY bgcolor="#B0C0D0">
<?

include "../config.inc.php";
function ImportInfo($ImportID){
	$ImportInfo=mysql_fetch_array(mysql_query("SELECT * FROM imports WHERE ImportID='$ImportID'"));
	return $ImportInfo;
}

$ImportInfo=ImportInfo($ImportID);
$list_info=list_info($ImportInfo[ListID]);

if(CanPerformAction("use|import|".$ImportInfo[ListID])){
	$f=fopen("../temp/$ImportID-headed.txt","r");
		//grab file contents!
		while(!feof($f)){
			$data=fread($f,1024);
		}
		//split up the file into records!
		$recdel2=$recorddelim;
		$recorddelim=str_replace('NEWLINE', "\n", $recorddelim);
		$records=explode($recorddelim,$data);
		
			$the_headers=current($records);
			array_splice($records, 0,1);
			$fields=explode($fielddelim, $the_headers);
				
		foreach($records as $record){
			$i=0;
			$rn++;
			$datafields=explode($fielddelim,$record);
			foreach($fields as $field){
				$members[$rn][$field]=$datafields[$i];
				$i++;
			}


		}
	//end grabbing the data!
	reset($members);
	if($type=="format" || $type=="receiving"){
	
		if($BadChanges){
			$alldata=$the_headers.$recorddelim;
			foreach($members as $member){
				$ThisValue=$member[$FormatField];
				if(isset($ThisValue)){
				foreach($BadChanges as $Change){
					list($ImpValue,$NewValue)=explode("####",$Change);
					if($ThisValue==$ImpValue){
						$member[$FormatField]=$NewValue;					
					}
				}
				$line="";
				foreach($member as $field){
					$line.=$field.$fielddelim;
				}
						$fr=strlen($line);
						$line=substr($line,0,$fr-1);
				$alldata.=$line.$recorddelim;
				}
			}
			$f=fopen("../temp/$ImportID-headed.txt","w");
			fputs($f,$alldata);
			fclose($f);
				echo '<SCRIPT LANGUAGE="JAVASCRIPT">
					alert("ALL THE DATA IS OK NOW!");
					window.close();
				</SCRIPT>';
				exit;
		}	
	
		reset($members);
		if($type=="format"){
			list($yes,$no)=explode("/",$list_info[FormatValues]);
			$yesek="HTML";
			$noek="Text";
		}elseif($type=="receiving"){
			list($yes,$no)=explode("/",$list_info[ReceivingValues]);	
			$yesek="Receiving";
			$noek="Not Receiving";	
		}
			
		foreach($members as $member){
				$formatvalue=$member[$FormatField];
				if($formatvalue!=$yes && $formatvalue!=$no && isset($formatvalue)){
					$BadFormats[$formatvalue]=$formatvalue;
				}
		}
		
		if($BadFormats){
			echo '<font face="verdana,arial" size="2">The following values in your import data need changing!</font>';
			
			foreach($BadFormats as $Value){
				$FORM_ITEMS["Make '$Value' equal"]="select|BadChanges[$Value]:1:$Value####".$yes."->$yesek;$Value####".$no."->$noek:";
			}
		}
		
		$FORM_ITEMS[-2]="submit|Fix them!";
		
		$FORM=new AdminForm;
		$FORM->title="FormatFixer";
		$FORM->items=$FORM_ITEMS;
		$FORM->action="fiximportdata.php?FormatField=$FormatField&recorddelim=$recdel2&fielddelim=$fielddelim&type=$type&ImportID=$ImportID";
		$FORM->MakeForm();
		echo $FORM->output;
			
	
	}
	
	
	
	

}
?>
</BODY>
</HTML>