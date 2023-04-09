<?
//////////////////////////////////////////////////////////////////////////////
// Program Name         : Max-eMail Elite                                   //
// Release Version      : 3.01                                              //
// Program Author       : SiteOptions inc.                                  //
// Supplied by          : CyKuH [WTN]                                       //
// Nullified by         : CyKuH [WTN]                                       //
// Distribution         : via WebForum, ForumRU and associated file dumps   //
//////////////////////////////////////////////////////////////////////////////
// COPYRIGHT NOTICE                                                         //
// (c) 2002 WTN Team,  All Rights Reserved.                                 //
// Distributed under the licencing agreement located in wtn_release.nfo     //
//////////////////////////////////////////////////////////////////////////////
include "../config.inc.php";


if($action=="list"){

		if(CanPerformAction("lists|stats|$ListID")!=1){
			$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
			FinishOutput();
		}
	$list_info=list_info($ListID);
	$FULL_OUTPUT.=MakeBox("Statistics Overview",'The following statistics are for the list '.$list_info[ListName].'<P>'.MakeLink("stats.php", "Return to statistics main"));
	
	switch($page){
		case "":
		GeneraListStats($ListID);
		break;
		
		case "charts":
		ChartsListStats($ListID);
		break;	
		
		case "sends":
		SendListStats($ListID);
		break;
		
		case "fields":
		FieldListStats($ListID);
		break;
		
	}

}elseif($action=="system"){
		if(CanPerformAction("system|stats|")!=1){
			$FULL_OUTPUT=MakeBox("ERROR OCCURED!",HandleError("Error402",2));
			FinishOutput();
		}
	
	SystemStats();


}else{
	StatsMain();
}


/////////////////////////////////////////////////////////////




function StatsMain(){
	GLOBAL $FULL_OUTPUT;
	
	//get lists this user can get stats on!
	$lists=mysql_query("SELECT * FROM lists");
		while($l=mysql_fetch_array($lists)){
				if(CanPerformAction("lists|stats|".$l[ListID])==1){
					$alllists.=$l[ListID]."->".$l[ListName].";";
				}
		}
	
				$FORM_ITEMS["Get stats on list"]="select|ListID:1:$alllists";
				$FORM_ITEMS[-1]="submit|Get Stats";
				$FORM=new AdminForm;
				$FORM->title="ListStats";
				$FORM->items=$FORM_ITEMS;
				$FORM->action="stats.php?action=list";
				$FORM->MakeForm();
				$BO.=$FORM->output;
				
	$FULL_OUTPUT.=MakeBox("List stats", $BO);
	
		if(CanPerformAction("system|stats|")==1){
	
				$FORM2_ITEMS["Get stats on"]="select|ListID:1:full->Full System Stats";
				$FORM2_ITEMS[-1]="submit|Generate Report";
				$FORM2=new AdminForm;
				$FORM2->title="SystemStats";
				$FORM2->items=$FORM2_ITEMS;
				$FORM2->action="stats.php?action=system";
				$FORM2->MakeForm();
				$BO2.=$FORM2->output;
				
	$FULL_OUTPUT.=MakeBox("System stats", $BO2);	
	}
	
}


FinishOutput();

?>