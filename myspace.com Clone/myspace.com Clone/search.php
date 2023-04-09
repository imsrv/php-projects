<?
/*
           .ÜÜÜÜÜÜÜÜÜÜÜÜ,                                  .ÜÜÜÜÜÜÜÜÜ:     ,ÜÜÜÜÜÜÜÜ:
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                             .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ             D O N          ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                           ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ          ÜÜÜÜÜÜÜ;        .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜ;
         ,ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜ        ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜ;
          ÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜ      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜÜÜ
          ÜÜÜÜÜÜÜÜ: ÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜ;      :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ   ;ÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜ     .ÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ
        :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜ,,,ÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
       ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ, ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
     .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
    ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
   ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
  ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;     ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ,  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
 ,ÜÜÜÜLiquidIceÜÜÜÜÜÜ          ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ
    .ÜÜÜÜÜÜÜÜÜÜ;                 ÜÜÜÜÜÜÜÜÜ        .ÜÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜÜÜ,

*/

$act=form_get("act");
if($act=='user'){
  search_user();
}
elseif($act=='listing'){
  search_listing();
}
elseif($act=='events'){
  search_events();
}
elseif($act=='tribe'){
  search_tribe();
}
elseif($act==''){
  search_main();
}
elseif($act=='simple'){
  search_simple();
}

//showing main search page
function search_main(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$sql_query="select zip from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');

$type=form_get("type");

show_header();
?>
     <table width=100% class='body'>
     <tr><td width=75% valign=top>
     <table width=100% class=body>
     <tr><td class='lined title'>My Friends</td>
     <tr><td class='lined padded-6'><table class=body><? show_friends($m_id,"14","7","1"); ?></table></td>
     </table>
     </td>
     <td valign=top class='lined padded-6'>
            <? if(($type=='')||($type=='basic')){ ?>
            <table class=body>
            <tr><td class='lined-right lined-top lined-left' align=center width=50>
            <a href='index.php?mode=search'><b>Basic</b></a>
            </td><td class='lined' align=center width=80>
            <a href='index.php?mode=search&type=advanced'>Advanced</a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="basic">
            <tr><td colspan=2 class='maingray'>Proximity to Me</td>
            <tr><td>Degrees</td><td><select name="degrees">
			<option value="any">any degree
			<option value="4">4&deg or closer
			<option value="3">3&deg or closer
			<option value="2">2&deg or closer
			<option value="1">1&deg friends
			</select></td>
            <tr><td>Distance</td><td><select name="distance">
			<option value="any">anywhere
			<option value="5">5 miles
			<option value="10">10 miles
			<option value="25">25 miles
			<option value="100">100 miles
			</select></td>
            <tr><td>From</td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'>User Search</td>
	        <tr><td>First Name</td><td><input type=text size=15 name="fname"></td>
	        <tr><td>Last Name</td><td><input type=text size=15 name="lname"></td>
	        <tr><td>E-mail</td><td><input type=text size=15 name="email"></td>
	        <tr><td colspan=2><input type=submit value="Search All Users"></td>
	        </table></form></table>
            <? } elseif($type=='advanced'){ ?>
            <table class=body>
            <tr><td class='lined' align=center width=50>
            <a href='index.php?mode=search'><b>Basic</b></a>
            </td><td class='lined-right lined-top lined-left' align=center width=80>
            <a href='index.php?mode=search&type=advanced'>Advanced</a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="advanced">
            <tr><td colspan=2><input type='checkbox' name='only_wp' value='1'>&nbsp&nbspFind only people with photos</td>
            <tr><td colspan=2 class='maingray'>Proximity to Me</td>
            <tr><td>Degrees</td><td><select name="degrees">
            <option value="any">any degree
			<option value="4">4&deg or closer
			<option value="3">3&deg or closer
			<option value="2">2&deg or closer
			<option value="1">1&deg friends
			</select></td>
            <tr><td>Distance</td><td><select name="distance">
			<option value="any">anywhere
			<option value="5">5 miles
			<option value="10">10 miles
			<option value="25">25 miles
			<option value="100">100 miles
			</select></td>
            <tr><td>From</td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'>User Search</td>
            <tr><td>Interests</td><td><input type=text size=15 name="interests"></td>
	        <tr><td>First Name</td><td><input type=text size=15 name="fname"></td>
	        <tr><td>Last Name</td><td><input type=text size=15 name="lname"></td>
	        <tr><td>E-mail</td><td><input type=text size=15 name="email"></td>
            <tr><td colspan=2 class='maingray'>Personal Information</td>
            <tr><td>Here For</td><td><input type=text size=15 name='here_for'></td>
            <tr><td>Gender</td><td><input type='radio' name='gender' value='m'>Male
            &nbsp<input type='radio' name='gender' value='f'>Female</td>
            <tr><td>Age</td><td><input type='text' size=5 name='age_from'> to&nbsp<input type='text' name='age_to' size=5></td>
            <tr><td>Schools</td><td><input type='text' size=15 name='schools'></td>
            <tr><td colspan=2 class='maingray'>Professional Information</td>
            <tr><td>Occupation</td><td><input type='text' size=15 name='occupation'></td>
            <tr><td>Company</td><td><input type='text' size=15 name='company'></td>
            <tr><td>Position</td><td><input type='text' size=15 name='position'></td>
            <tr><td colspan=2 class='maingray'>Display Preferences</td>
            <tr><td>Show</td><td><select name='show'>
            <option value='pnt'>Photos & Text
            <option value='po'>Photos Only
            </select></td>
            <tr><td>Sort By</td><td><select name='sort'>
            <option value='ll'>Last Login
            <option value='ff'>Friends First
            <option value='ma'>Miles Away
            </select></td>
	        <tr><td colspan=2><input type=submit value="Search"></td>
	        </table></form></table>
            <? } ?>
     </td>
     </table>
<?
show_footer();
}//function

function search_user(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$type=form_get("type");
//basic search
if($type=="basic"){

    //getting values
    $form_data=array('degrees','distance','zip','fname','lname','email');
    while (list($key,$val)=each($form_data)){
    ${$val}=form_get("$val");
    }//while


    //setting filter
    $sql_query="select zip,filter from members where mem_id='$m_id'";
    $mem=sql_execute($sql_query,'get');

    $items=split("\|",$mem->filter);

    if($zip==''){
	$zip=$mem->zip;
	}
	$degree=$degrees;
    if($degree==''){
       $degree=$items[2];
    }//if
    if($distance==''){
       $distance=$items[0];
    }//if
	//applying distance filter
	$zone=array();
    if($distance=='any'){
    $zonear='not found';
    }
    else {
    $zonear=inradius($zip,$distance);
    }

	if(($zonear=='not found')||($zonear=='no result')){
     	$sql_query="select mem_id from members";
	     $res=sql_execute($sql_query,'res');
	     while($z=mysql_fetch_object($res)){
              array_push($zone,$z->mem_id);
	     }//while
	}//if
	else {
	 $sql_query="select mem_id from members where ";
	 foreach($zonear as $zp){
	    $sql_query.="zip='$zp' or ";
	 }
	 $sql_query=rtrim($sql_query,' or ');
	 $res=sql_execute($sql_query,'res');
	 while($z=mysql_fetch_object($res)){
	    array_push($zone,$z->mem_id);
	 }//while
	}//else
	//applying degree filter
	$friends=array();
	$filter=array();
	if($degree=='any'){
	 $sql_query="select mem_id from members";
	 $res=sql_execute($sql_query,'res');
	 while($fr=mysql_fetch_object($res)){
	    array_push($friends,$fr->mem_id);
	 }//while
	}//if
	else {
	$friends=count_network($m_id,$degree,"ar");
	}
    if($friends==''){
      $friends=array();
    }
	$filter=array_intersect($friends,$zone);

    $flag=0;
    foreach($filter as $id){
       if ($id!=''){
       $flag=1;
       }
    }
    if($flag==1){
    $sql_query="select mem_id from members where (";
    reset($filter);
    foreach($filter as $id){
        $sql_query.="mem_id='$id' or ";
    }//foreach
    $sql_query=rtrim($sql_query,' or ');
    $sql_query.=") ";
    reset($form_data);
    //adding to sql-query search fields values
    while(list($key,$val)=each($form_data)){
       if((${$val}!='')&&($val!='degrees')&&($val!='distance')&&($val!='zip')){
          $sql_query.="and $val='${$val}' ";
       }//if
    }//while
    $sql_query=rtrim($sql_query);
    $res=sql_execute($sql_query,'res');
    $result='';
    if(mysql_num_rows($res)){
    $result=array();
    while($ar=mysql_fetch_object($res)){
        array_push($result,$ar->mem_id);
    }//while
    }//if
    }//if
    else {
    $result='';
    }//else
    $sorted_result=$result;

}//if
elseif($type=='advanced'){

    //getting values
    $form_data=array('degrees','gender','distance','zip','fname','lname','email');
    $form_data2=array('interests','here_for','schools','occupation','company','position');
    $only_wf=form_get("only_wp");
    $sort=form_get("sort");
    $show=form_get("show");
    $age_from=form_get("age_from");
    $age_to=form_get("age_to");

    while (list($key,$val)=each($form_data)){
    ${$val}=form_get("$val");
    }//while
    while (list($key,$val)=each($form_data2)){
    ${$val}=form_get("$val");
    }//while

    //creating unix time from normal (age from and age to)
    if($age_from!=''){
      $age_from=$age_from+1970;
      $now=time();
      $dif=mktime(0,0,0,date("m"),date("d"),$age_from);
      $born_from=$now-$dif;
    }
    if($age_to!=''){
      $age_to=$age_to+1970;
      $now2=time();
      $dif2=mktime(0,0,0,date("m"),date("d"),$age_to);
      $born_to=$now2-$dif2;
    }

    //setting filter
    $sql_query="select zip from members where mem_id='$m_id'";
    $mem=sql_execute($sql_query,'get');

    if($zip==''){
	$zip=$mem->zip;
	}
	$degree=$degrees;
	//applying distance filter
	$zone=array();
    if($distance=='any'){
    $zonear='not found';
    }
    else {
    $zonear=inradius($zip,$distance);
    }
	if(($zonear=='not found')||($zonear=='no result')){
     	$sql_query="select mem_id from members";
	     $res=sql_execute($sql_query,'res');
	     while($z=mysql_fetch_object($res)){
              array_push($zone,$z->mem_id);
	     }//while
	}//if
	else {
	 $sql_query="select mem_id from members where ";
	 foreach($zonear as $zp){
	    $sql_query.="zip='$zp' or ";
	 }
	 $sql_query=rtrim($sql_query,' or ');
	 $res=sql_execute($sql_query,'res');
	 while($z=mysql_fetch_object($res)){
	    array_push($zone,$z->mem_id);
	 }//while
	}//else
	//applying degree filter
	$friends=array();
	$filter=array();
	if($degree=='any'){
	 $sql_query="select mem_id from members";
	 $res=sql_execute($sql_query,'res');
	 while($fr=mysql_fetch_object($res)){
	    array_push($friends,$fr->mem_id);
	 }//while
	}//if
	else {
	$friends=count_network($m_id,$degree,"ar");
	}
	$filter=array_intersect($friends,$zone);

    $flag=0;
    foreach($filter as $id){
       if($id!=''){
       $flag=1;
       }
    }
    if($flag==1){
    $sql_query="select mem_id from members where (";
    reset($filter);
    foreach($filter as $id){
        $sql_query.="mem_id='$id' or ";
    }//foreach
    $sql_query=rtrim($sql_query,' or ');
    $sql_query.=") ";
    reset($form_data);
    //adding search fields values
    while(list($key,$val)=each($form_data)){
       if((${$val}!='')&&($val!='degrees')&&($val!='distance')&&($val!='zip')){
          $sql_query.="and $val='${$val}' ";
       }//if
    }//while
    $sql_query=rtrim($sql_query);
    //adding birthday criteria
    if($born_from!=''){
      $sql_query.=" and birthday<=$born_from";
    }
    if($born_to!=''){
      $sql_query.=" and birthday>=$born_to";
    }
    //if show only with photos
    if($only_wf=='1'){
      $sql_query.=" and photo!='no'";
    }
    $res=sql_execute($sql_query,'res');
    $adv_res1=array();
    while($ar=mysql_fetch_object($res)){
        array_push($adv_res1,$ar->mem_id);
    }//while

    $flag2=0;
    foreach($adv_res1 as $r){
       if($r!=''){
       $flag2=1;
       }
    }
    if($flag2==1){
    //adding profile criteria
    $sql_query="select mem_id from profiles where (";
    foreach($adv_res1 as $id){
        $sql_query.="mem_id='$id' or ";
    }//foreach
    $sql_query=rtrim($sql_query,' or ');
    $sql_query.=") ";
    reset($form_data2);
    while(list($key,$val)=each($form_data2)){
       if(${$val}!=''){
          $sql_query.="and $val='${$val}' ";
       }//if
    }//while
    $sql_query=rtrim($sql_query);
    $res=sql_execute($sql_query,'res');
    $result='';
    if(mysql_num_rows($res)){
    $result=array();
    while($ar2=mysql_fetch_object($res)){
        array_push($result,$ar2->mem_id);
    }//while
    }//if
    }//if
    }//if
    else {
       $result='';
       $sorted_result='';
    }//else

    //sorting array
    if($result!=''){
    $sorted_result=array();
        //last login
        if($sort=='ll'){
        $sql_query="select mem_id from members where ";
        foreach($result as $id){
           $sql_query.="mem_id='$id' or ";
        }//foreach
        $sql_query=rtrim($sql_query,' or ');
        $sql_query.=" order by current desc";
        $res=sql_execute($sql_query,'res');
        while($ll=mysql_fetch_object($res)){
            array_push($sorted_result,$ll->mem_id);
        }//while
        }//last login
        //friends first
        elseif($sort=='ff'){
        $fr1=count_network($m_id,"1","ar");
        $fr2=count_network($m_id,"2","ar");

        if($fr1!=''){
        foreach($result as $id){
             if(in_array($id,$fr1)){
                array_push($sorted_result,$id);
             }//if
        }//foreach
        }//if
        elseif($fr2!=''){
        foreach($result as $id){
             if(in_array($id,$fr2)){
                array_push($sorted_result,$id);
             }//if
        }//foreach
        }//elseif
        $sorted_result=array_unique($sorted_result);
        foreach($result as $id){
             if(!in_array($id,$sorted_result)){
                array_push($sorted_result,$id);
             }//if
        }//foreach
        }//elseif
        //miles away
        elseif($sort=='ma'){
            $sorted_result=$result;
        }//elseif
    }//if

}//elseif

			//output
            show_header();
            ?>
              <table>
              <tr><td width=75% valign=top>
              <table width=100% class='body'>
                    <tr><td class='lined title' valign=top>People Search: Results</td>
                    <?
                        if($sorted_result!=''){
                        $page=form_get("page");
                        if($page==''){
                           $page=1;
                        }//if
                        $i=1;
                        if($show=='po'){
                        echo "<tr><td><table align=center>";
                        }
                        $start=($page-1)*20;
                        $end=$start+20;
                        if($end>count($sorted_result)){
                           $end=count($sorted_result);
                        }//if
                        for($k=$start;$k<$end;$k++){
                        $sql_query="select occupation,here_for from profiles where mem_id='$sorted_result[$k]'";
                        $s_mem=sql_execute($sql_query,'get');?>

                        <? if($show!='po') {?>
                        <tr><td>
                        <table class='body lined' cellspacing=0 width=100% cellpadding=0>
              	        <tr><td width=65 height=75 rowspan=2 align=center class='lined-right padded-6'><? show_photo($sorted_result[$k]); ?></br>
	                    <? show_online($sorted_result[$k]); ?>
	                    </td>
	                    <td class='td-lined-bottom padded-6'><? connections($m_id,$sorted_result[$k]); ?></td>
	                    <tr><td class='padded-6'>
                        <? if($s_mem->occupation!=''){ ?><a href='index.php?mode=search&act=simple&interests=<? echo $s_mem->occupation; ?>'><? echo $s_mem->occupation; ?></a></br><?}
                        if ($s_mem->here_for!=''){?>Here For: <a href='index.php?mode=search&act=simple&interests=<? echo $s_mem->here_for; ?>'><? echo $s_mem->here_for; ?></a></br><?}?>
                        Network: <a href='index.php?mode=people_card&act=friends&p_id=<? echo $sorted_result[$k]; ?>'><? echo count_network($sorted_result[$k],"1","num"); ?> friends</a> in a
	                    <a href='index.php?mode=people_card&act=network&p_id=<? echo $sorted_result[$k]; ?>'>network of <? echo count_network($sorted_result[$k],"all","num"); ?></a>
	                    </td>
	                    </table>
                        </td>
                        <?
                        }
                        else {
                        if(($i==1)||($i%5==0)){
                             echo "<tr>";
                        }
                        ?>
                        <td>
                        <table class='body lined' cellspacing=0 cellpadding=0>
              	        <tr><td width=65 height=75 align=center class='padded-6'><? show_photo($sorted_result[$k]); ?></br>
	                    <? show_online($sorted_result[$k]); ?>
	                    </td></table></td>
                        <?
                        $i++;
                        }
                        }//foreach
                        if($show=='po'){
                        echo "</table></td>";
                        }
                        echo "<tr><td class='lined' align=center>";pages_line(count($sorted_result),"$type","$page","20");
                        echo "</td>";
                        }//if
                        else {
                           echo "<tr><td>Not found.</td>";
                        }//else
                    ?>
              </table>
              </td>
              <td valign=top class='lined padded-6' valign=top>
            <? if(($type=='')||($type=='basic')){ ?>
            <table class=body>
            <tr><td class='lined-right lined-top lined-left' align=center width=50>
            <a href='index.php?mode=search'><b>Basic</b></a>
            </td><td class='lined' align=center width=80>
            <a href='index.php?mode=search&type=advanced'>Advanced</a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="basic">
            <tr><td colspan=2 class='maingray'>Proximity to Me</td>
            <tr><td>Degrees</td><td><select name="degrees">
            <option value="any">any degree
			<option value="4">4&deg or closer
			<option value="3">3&deg or closer
			<option value="2">2&deg or closer
			<option value="1">1&deg friends
			</select></td>
            <tr><td>Distance</td><td><select name="distance">
			<option value="any">anywhere
			<option value="5">5 miles
			<option value="10">10 miles
			<option value="25">25 miles
			<option value="100">100 miles
			</select></td>
            <tr><td>From</td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'>User Search</td>
	        <tr><td>First Name</td><td><input type=text size=15 name="fname"></td>
	        <tr><td>Last Name</td><td><input type=text size=15 name="lname"></td>
	        <tr><td>E-mail</td><td><input type=text size=15 name="email"></td>
	        <tr><td colspan=2><input type=submit value="Search All Users"></td>
	        </table></form></table>
            <? } elseif($type=='advanced'){ ?>
            <table class=body>
            <tr><td class='lined' align=center width=50>
            <a href='index.php?mode=search'><b>Basic</b></a>
            </td><td class='lined-right lined-top lined-left' align=center width=80>
            <a href='index.php?mode=search&type=advanced'>Advanced</a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="advanced">
            <tr><td colspan=2><input type='checkbox' name='only_wp' value='1'>&nbsp&nbspFind only people with photos</td>
            <tr><td colspan=2 class='maingray'>Proximity to Me</td>
            <tr><td>Degrees</td><td><select name="degrees">
            <option value="any">any degree
			<option value="4">4&deg or closer
			<option value="3">3&deg or closer
			<option value="2">2&deg or closer
			<option value="1">1&deg friends
			</select></td>
            <tr><td>Distance</td><td><select name="distance">
			<option value="any">anywhere
			<option value="5">5 miles
			<option value="10">10 miles
			<option value="25">25 miles
			<option value="100">100 miles
			</select></td>
            <tr><td>From</td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'>User Search</td>
            <tr><td>Interests</td><td><input type=text size=15 name="interests"></td>
	        <tr><td>First Name</td><td><input type=text size=15 name="fname"></td>
	        <tr><td>Last Name</td><td><input type=text size=15 name="lname"></td>
	        <tr><td>E-mail</td><td><input type=text size=15 name="email"></td>
            <tr><td colspan=2 class='maingray'>Personal Information</td>
            <tr><td>Here For</td><td><input type=text size=15 name='here_for'></td>
            <tr><td>Gender</td><td><input type='radio' name='gender' value='m'>Male
            &nbsp<input type='radio' name='gender' value='f'>Female</td>
            <tr><td>Age</td><td><input type='text' size=5 name='age_from'>&nbspto&nbsp<input type='text' name='age_to' size=5></td>
            <tr><td>Schools</td><td><input type='text' size=15 name='schools'></td>
            <tr><td colspan=2 class='maingray'>Professional Information</td>
            <tr><td>Occupation</td><td><input type='text' size=15 name='occupation'></td>
            <tr><td>Company</td><td><input type='text' size=15 name='company'></td>
            <tr><td>Position</td><td><input type='text' size=15 name='position'></td>
            <tr><td colspan=2 class='maingray'>Display Preferences</td>
            <tr><td>Show</td><td><select name='show'>
            <option value='pnt'>Photos & Text
            <option value='po'>Photos Only
            </select></td>
            <tr><td>Sort By</td><td><select name='sort'>
            <option value='ll'>Last Login
            <option value='ff'>Friends First
            <option value='ma'>Miles Away
            </select></td>
	        <tr><td colspan=2><input type=submit value="Search"></td>
	        </table></form></table>
            <? } ?>
     </td>

              </table>
            <?
            show_footer();
}//function

function search_listing(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$sql_query="select zip from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');

//getting values
$form_data=array('keywords','RootCategory','Category','degree','distance','zip');
while (list($key,$val)=each($form_data)){
${$val}=form_get("$val");
}//while

$cat_id=$RootCategory;
$sub_cat_id=$Category;
if($cat_id==$sub_cat_id){
  $sub_cat_id='';
}//if

if($zip==''){
 $zip=$mem->zip;
}

//applying distance filter
$zone=array();
if($distance=='any'){
$zonear='no result';
}else{
$zonear=inradius($zip,$distance);
}
if(($zonear=='not found')||($zonear=='no result')){
 $sql_query="select lst_id from listings";
 $res=sql_execute($sql_query,'res');
 while($z=mysql_fetch_object($res)){
  array_push($zone,$z->lst_id);
 }
}
else {
 $sql_query="select lst_id from listings where ";
 foreach($zonear as $zp){
 	$sql_query.="zip='$zp' or ";
 }
 $sql_query=rtrim($sql_query,' or ');
 $res=sql_execute($sql_query,'res');
 while($z=mysql_fetch_object($res)){
    array_push($zone,$z->lst_id);
 }
}
//applying degree filter
$friends=array();
$filter=array();
if($degree=='any'){
 $sql_query="select mem_id from members";
 $res=sql_execute($sql_query,'res');
 while($fr=mysql_fetch_object($res)){
  	array_push($friends,$fr->mem_id);
 }
}
else {
for($i=$degree;$i>=1;$i--){
$friends=array_merge($friends,count_network($m_id,$i,"ar"));
}//for
}//else
if($friends==''){
  $friends=array();
}
$filter=$friends;
$filter=if_empty($filter);
if($filter!=''){
$filter=array_unique($filter);
}//if
$zone=if_empty($zone);

   if(($zone!='')&&($filter!='')){
   $sql_query="select lst_id from listings where ";
   reset($filter);
   if($filter!=''){
   $sql_query.="( ";
   foreach($filter as $id){
       $sql_query.="mem_id='$id' or ";
   }//foreach
   $sql_query=rtrim($sql_query,' or ');
   $sql_query.=") ";
   }//if
   if($zone!=''){
   $sql_query.="and (";
   foreach($zone as $zon){
       $sql_query.="lst_id='$zon' or ";
   }//foreach
   $sql_query=rtrim($sql_query,' or ');
   }//if
   $sql_query.=")";
   $res=sql_execute($sql_query,'res');
   if(mysql_num_rows($res)){
   $result=array();
   while($sear=mysql_fetch_object($res)){
      array_push($result,$sear->lst_id);
   }//while
   }//if
   }//if
   else{
      $result='';
   }//else

                        //output
                        show_header();
                        ?>
                          <table width=100% class='body'>
                             <tr><td valign=top width=75%>
                             <table width=100% class='body'>
                             <tr><td class='lined title'>Listings: Search Results</td>
                             <tr><td class='lined'>
                             <?
                        if($result!=''){
                                $result=array_unique($result);
                                $page=form_get("page");
                                if($page==''){
                                  $page=1;
                                }
                                $start=($page-1)*20;
                                $end=$start+20;
                                if($end>count($result)){
                                  $end=count($result);
                                }
                                $sql_query="select lst_id from listings where (";
                                   foreach($result as $id){

                                       $sql_query.="lst_id='$id' or ";

                                   }//foreach
                                   $sql_query=rtrim($sql_query,' or ');
                                   $sql_query.=")";
                                   if($keywords!=''){
   	                               $keyword=split(' ',$keywords);
	                               $keyword=if_empty($keyword);
	                               foreach($keyword as $word){
	                                  $sql_query.=" and description like '%$word%'";
	                               }//foreach
	                               }//if
                                if($cat_id!=''){
                                $sql_query.=" and cat_id='$cat_id'";
                                }//if
                                if($sub_cat_id!=''){
                                $sql_query.=" and sub_cat_id='$sub_cat_id'";
                                }//if
                                if($degree!='any'){
                                   $sql_query.=" and anonim!='y'";
                                }//if
                                $sql_query.=" and stat='a' order by added";

                                $total=sql_execute($sql_query,'num');
                                $sql_query.=" limit $start,20";

                                       $res=sql_execute($sql_query,'res');
                                       $final=array();
                                       while($fin=mysql_fetch_object($res)){
                                          array_push($final,$fin->lst_id);
                                       }//while
                                       $flag=0;
                                       foreach($final as $lid){
                                           if($lid!=''){
                                             $flag=1;
                                             break;
                                           }
                                       }
                                       if($flag==1){
                                       ?>
                                       <table class='body'>
                                       <?
                                       foreach($final as $lid){
                                       $sql_query="select * from listings where lst_id='$lid'";
                                       $lst=sql_execute($sql_query,'get');
                                       if($lst->show_deg!='trb'){
	                                   if(($lst->show_deg!='any')&&($lst->mem_id!=$m_id)){
	                                   $lister_friends=lister_degree($lst->mem_id,$lst->show_deg);
	                                    }
	                                    else{
	                                    $lister_friends[]=$m_id;
	                                    }
	                                   if((in_array($m_id,$lister_friends))||($lst->anonim=='y')){
	                                   $date=date("m/d",$lst->added);
	                                   echo "$date  <img src='images/icon_listing.gif'>
	                                   <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id'>$lst->title</a>&nbsp";
	                                   if($lst->anonim!='y'){
	                                   show_online($lst->mem_id);
                                       echo " - ";echo find_relations($m_id,$lst->mem_id);
	                                   }
	                                   else{
	                                   echo "anonymous";
	                                   }
	                                   echo "</br>";
	                                   }//if
	                                   }//if
                                       }//foreach
                                       echo "</table>";
                                       echo "<tr><td class='lined' align=center>";
                                       pages_line($total,"search_lst","$page","20");
                                       echo "</td>";
                                       }//if
                        			   else {
                            			  echo "Not found.";
				                       }//else




                        }//if
                        else {
                            echo "Not found.";

                        }//else
                        ?>                             </td></table></td>
                             <td valign=top>
                             <table class='body'>

                <tr><td class="lined title">Search Listings</td>
                <tr><td class="lined padded-6">
                <form action='index.php' method=post name='searchListing'>
                <input type=hidden name="mode" value="search">
				<input type=hidden name="act" value="listing">
				<input type=hidden name="type" value="normal">
                    Keywords <input type=text name='keywords'></br>
                    Category <select name="RootCategory" onChange="listCategory.populate();" width="140" style="width: 140px">
							<option value="">Select Category</option>
               <option value="1000">announcements</option>
               <option value="2000">deals & steals</option>
               <option value="7000">for sale</option>
               <option value="6000">housing</option>
               <option value="9000">jobs</option>
               <option value="4000">local</option>
               <option value="5000">people/personals</option>
               <option value="8000">services</option>
       		     </select>
     <br/>
	   	<select name="Category" width="140" style="width: 140px">
	   				  <SCRIPT LANGUAGE="JavaScript">listCategory.printOptions();</script>
	   	</select>
	   	<SCRIPT LANGUAGE="JavaScript">listCategory.setDefaultOption("","");</script>
                </br>

                Proximity to me</br>
                Degrees <select name="degree">
				<option value="any">anyone
				<option value="4">within 4&deg of me
				<option value="3">within 3&deg of me
				<option value="2">within 2&deg of me
				<option value="1">a friend
				</select></br>
                Distance <select name="distance">
				<option value="any">any distance
				<option value="5">5 miles
				<option value="10">10 miles
				<option value="25">25 miles
				<option value="100">100 miles
				</select>
                From <input type=text size=10 name=zip value='<?
                $sql_query="select zip from members where mem_id='$m_id'";
                $mem=sql_execute($sql_query,'get');
                echo $mem->zip;
                ?>'></br></br>
                <input type='submit' value='Search'>
                </form>
                </td>
           </table>



                             </td>
                          </table>
                   <?


}//function
function search_events(){
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);

	$sql_query="select zip from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');

	//getting values
	$form_data=array('keywords','RootCategory','distance','degree','zip');
	while (list($key,$val)=each($form_data)){
		${$val}=form_get("$val");
	}//while

	$cat_id=$RootCategory;
	if($zip=='')	$zip=$mem->zip;

	//applying distance filter
	$zone=array();
	if($distance=='any')	$zonear='no result';
	else	$zonear=inradius($zip,$distance);
	if(($zonear=='not found')||($zonear=='no result')){
		$sql_query="select even_id from event_list";
		$res=sql_execute($sql_query,'res');
		while($z=mysql_fetch_object($res)){
			array_push($zone,$z->even_id);
		}
	}	else	{
		$sql_query="select even_id from event_list where ";
		foreach($zonear as $zp){
			$sql_query.="even_zip='$zp' or ";
		}
		$sql_query=rtrim($sql_query,' or ');
		$res=sql_execute($sql_query,'res');
		while($z=mysql_fetch_object($res)){
			array_push($zone,$z->even_id);
		}
	}
	//applying degree filter
	$friends=array();
	$filter=array();
	if($degree=='any'){
		$sql_query="select mem_id from members";
		$res=sql_execute($sql_query,'res');
		while($fr=mysql_fetch_object($res)){
			array_push($friends,$fr->mem_id);
		}
	}	else	{
		for($i=$degree;$i>=1;$i--){
			$friends=array_merge($friends,count_network($m_id,$i,"ar"));
		}//for
	}//else
	if($friends=='')	$friends=array();
	$filter=$friends;
//	$filter=if_empty($filter);
	if($filter!='')	$filter=array_unique($filter);
//	$zone=if_empty($zone);
	if(($zone!='')&&($filter!='')){
		$sql_query="select even_id from event_list where ";
		reset($filter);
		if($filter!=''){
			$sql_query.="( ";
			foreach($filter as $id){
				$sql_query.="even_own='$id' or ";
			}//foreach
			$sql_query=rtrim($sql_query,' or ');
			$sql_query.=") ";
		}//if
		if($zone!=''){
			$sql_query.="and (";
			foreach($zone as $zon){
				$sql_query.="even_id='$zon' or ";
			}//foreach
			$sql_query=rtrim($sql_query,' or ');
		}//if
		$sql_query.=")";
		$res=sql_execute($sql_query,'res');
		if(mysql_num_rows($res)){
			$result=array();
			while($sear=mysql_fetch_object($res)){
				array_push($result,$sear->even_id);
			}//while
		}//if
   }	else	$result='';

	//output
	show_header();
	?>
	<table width=100% class='body'>
		<tr><td valign=top width=75%>
			<table width=100% class='body'>
				<tr><td class='lined title'>Events: Search Results</td>
				<tr><td class='lined'>
				<?
				if($result!=''){
					$result=array_unique($result);
					$page=form_get("page");
					if($page=='')	$page=1;
					$start=($page-1)*20;
					$end=$start+20;
					if($end>count($result))	$end=count($result);
					$sql_query="select even_id from event_list where (";
					foreach($result as $id){
						$sql_query.="even_id='$id' or ";
					}//foreach
					$sql_query=rtrim($sql_query,' or ');
					$sql_query.=")";
					if($keywords!=''){
						$keyword=split(' ',$keywords);
						$keyword=if_empty($keyword);
						foreach($keyword as $word){
							$sql_query.=" and even_desc like '%$word%'";
						}//foreach
					}//if
					$sql_query.=" order by even_dt";
					$total=sql_execute($sql_query,'num');
					$sql_query.=" limit $start,20";
					$res=sql_execute($sql_query,'res');
					$final=array();
					while($fin=mysql_fetch_object($res)){
						array_push($final,$fin->even_id);
					}//while
					$flag=0;
					foreach($final as $lid){
						if($lid!=''){
							$flag=1;
							break;
						}//If
					}//Foreach
					if($flag==1){
					?>
					<table class='body'>
					<?
					foreach($final as $lid){
						$sql_query="select * from event_list where even_id='$lid'";
						$lst=sql_execute($sql_query,'get');
						$date=date("m/d",$lst->even_dt);
						echo "$date  <img src='images/icon_listing.gif'>
						<a href='index.php?mode=events&act=viewevent&seid=$lst->even_id'>$lst->even_title</a>&nbsp";
						show_online($lst->mem_id);
						echo " - ";echo find_relations($m_id,$lst->even_own);
						echo "</br>";
					}//foreach
					echo "</table>";
					echo "<tr><td class='lined' align=center>";
					pages_line($total,"search_lst","$page","20");
					echo "</td>";
				}//if
				else {
					echo "Not found.";
				}//else
			}//if
			else {
				echo "Not found.";
			}//else
			?>
			</td></table></td>
			<td valign=top>
			<table class='body'>
			<tr><td class="lined title">Search Events</td>
			<tr><td class="lined padded-6">
			<form action='index.php' method=post name='searchEvent'>
				<input type=hidden name="mode" value="search">
				<input type=hidden name="act" value="events">
				<input type=hidden name="type" value="normal">
				Keywords <input type=text name='keywords'></br>
				Category <select name="RootCategory" width="140" style="width: 140px"><? events_cats(''); ?></select><br>
				Degrees <select name="degree">
				<option value="any">anyone</option>
				<option value="4">within 4&deg of me</option>
				<option value="3">within 3&deg of me</option>
				<option value="2">within 2&deg of me</option>
				<option value="1">a friend</option>
				</select><br><br>
				Distance <select name="distance">
				<option value="any">any distance</option>
				<option value="5">5 miles</option>
				<option value="10">10 miles</option>
				<option value="25">25 miles</option>
				<option value="100">100 miles</option>
				</select><br><br>
                From <input type=text size=10 name=zip value='<?
                $sql_query="select zip from members where mem_id='$m_id'";
                $mem=sql_execute($sql_query,'get');
                echo $mem->zip;
                ?>'></br></br>
                <input type='submit' value='Search'>
                </form>
				</td>
				</table>
				</td>
				</table>
				<?
}//function

function search_tribe(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
show_header();
?>
   <table width=100%>
   <tr><td width=75% valign=top>
       <table width=100% class='body'>
       <tr><td class='lined title'>Groups: Search Results</td>


<?
//just selecting tribe with description, that contents search keywords
$keywords=form_get("keywords");
if($keywords!=''){
   $keyword=split(" ",$keywords);
   $sql_query="select trb_id from tribes where (";
   foreach($keyword as $word){
       $sql_query.="description like '%$word%' or ";
   }//foreach
   $sql_query=rtrim($sql_query,' or ');
   $sql_query.=") and type!='priv' order by mem_num";
   $res=sql_execute($sql_query,'res');
   $result='';
   if(mysql_num_rows($res)){
   $result=array();
      while($tr=mysql_fetch_object($res)){
         array_push($result,$tr->trb_id);
      }//while
   }//if
}//if
else {
   $sql_query="select trb_id from tribes where type!='priv' order by mem_num";
   $res=sql_execute($sql_query,'res');
   $result='';
   if(mysql_num_rows($res)){
   $result=array();
      while($tr=mysql_fetch_object($res)){
         array_push($result,$tr->trb_id);
      }//while
   }//if
}//else

                //output
                if($result!=''){
                $result=array_unique($result);
                $page=form_get("page");
                if($page==''){
                    $page=1;
                }//if
                $start=($page-1)*20;
                $end=$start+20;
                if($end>count($result)){
                   $end=count($result);
                }
                for($k=$start;$k<$end;$k++){
                    $sql_query="select * from tribes where trb_id='$result[$k]'";
                    $trb=sql_execute($sql_query,'get');
                    $sql_query="select name from t_categories where t_cat_id='$trb->t_cat_id'";
                    $name=sql_execute($sql_query,'get');
                    $name->name=rtrim($name->name);

                     echo "<tr><td><table width=100% class='body' cellpadding=0 cellspacing=0>";
                     echo "<tr><td class='lined-top lined-left lined-bottom' align=center height=75 width=65>";
                     show_tribe_s_photo($trb->trb_id);echo "</br>";
                     echo "<a href='index.php?mode=tribe&act=show&trb_id=$trb->trb_id'>$trb->name</a>";
                     echo "</td>
                     <td valign=top class='td-lined padded-6'>";
                     echo "<b><a href='index.php?mode=tribe&act=show&trb_id=$trb->trb_id'>$trb->name</a></b></br>";
                     echo "A ".tribe_type($trb->trb_id,'output').
                     " <a href='index.php?mode=tribe&act=cat&t_cat_id=$trb->t_cat_id'>$name->name</a> tribe.</br>";
                     echo $trb->mem_num." members ";join_tribe_link($m_id,$trb->trb_id);
                     echo "</br></br>";
                     echo $trb->description;
                     echo "</td>";
                     echo "</table></td>";

                }//foreach
                echo "<tr><td class='lined' align=center>";
                pages_line(count($result),"search_trb","$page","20");
                echo "</td>";
                }//if
                else {
                echo "<tr><td align=center class=lined>Not found.</td>";
                }

?>
  </table></td>
  <td valign=top>

            <table width=100% class='body'>
               <tr><td class='lined padded-6' align=center><input type=button value='Create A Group' onClick='window.location="index.php?mode=tribe&act=create"'></td>
               <tr><td class='lined title'>Search Groups</td>
               <tr><td class='padded-6 lined'>
               <form action="index.php" method='post'>
               <input type=hidden name="mode" value="search">
			   <input type=hidden name="act" value="tribe">
               Keywords</br>
               <input type='text' name='keywords'></br>
               <input type='submit' value='Search'></form>
               </td>
            </table>
       </td></table>

<?
show_footer();


}//function

//simple search(only interests)
function search_simple(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$ar=array(
"interests"    ,
"hometown"     ,
"schools"      ,
"languages"    ,
"books"        ,
"music"        ,
"movies"       ,
"travel"       ,
"clubs"        ,
"position"     ,
"company"      ,
"occupation"   ,
"skills"	   ,
"specialities"
);

for($i=0;$i<count($ar);$i++){
  $val=$ar[$i];
  ${$val}=form_get("$val");
  if(${$val}!=''){
    $fl=$ar[$i];
    $sr=${$val};
    break;
  }
}


    //applying intersts value
    $sql_query="select mem_id from profiles where ";
    $sql_query.="($fl like '$sr,%') or ($fl like '%,$sr,%') or ($fl like '%,$sr')
    or ($fl like '$sr')";


    $sql_query=rtrim($sql_query);
    $res=sql_execute($sql_query,'res');
    $result='';
    if(mysql_num_rows($res)){
    $result=array();
    while($ar=mysql_fetch_object($res)){
        array_push($result,$ar->mem_id);
    }//while
    }//if
    else {
    $result='';
    }//else

            //output
            show_header();
            ?>
              <table>
              <tr><td width=75% valign=top>
              <table width=100% class='body'>
                    <tr><td class='lined title' valign=top>People Search: Results</td>
                    <?
                        if($result!=''){
                        $page=form_get("page");
                        if($page==''){
                           $page=1;
                        }//if
                        $start=($page-1)*20;
                        $end=$start+20;
                        if($end>count($result)){
                          $end=count($result);
                        }//if
                        for($k=$start;$k<$end;$k++){
                        $sql_query="select occupation,here_for from profiles where mem_id='$result[$k]'";
                        $s_mem=sql_execute($sql_query,'get');?>

                        <tr><td>
                        <table class='body lined' cellspacing=0 width=100% cellpadding=0>
              	        <tr><td rowspan=2 width=10% class='lined-right padded-6'><? show_photo($result[$k]); ?></br>
	                    <? show_online($result[$k]); ?>
	                    </td>
	                    <td class='td-lined-bottom padded-6'><? connections($m_id,$result[$k]); ?></td>
	                    <tr><td class='padded-6'>
                        <? if($s_mem->occupation!=''){ ?><a href='index.php?mode=search&act=simple&interests=<? echo $s_mem->occupation; ?>'><? echo $s_mem->occupation; ?></a></br><?}
                        if ($s_mem->here_for!=''){?>Here For: <a href='index.php?mode=search&act=simple&interests=<? echo $s_mem->here_for; ?>'><? echo $s_mem->here_for; ?></a></br><?}?>
                        Network: <? echo count_network($result[$k],"1","num"); ?> friends in a
	                    network of <? echo count_network($result[$k],"all","num"); ?>
	                    </td>
	                    </table>
                        </td>
                        <?
                        }//foreach
                        echo "<tr><td class='lined' align=center>";pages_line(count($result),"simple","$page","20");
                        echo "</td>";
                        }//if
                        else {
                           echo "<tr><td>Not found.</td>";
                        }//else
                    ?>
              </table>
              </td>
              <td valign=top class='lined padded-6' valign=top>
            <? if(($type=='')||($type=='basic')){ ?>
            <table class=body>
            <tr><td class='lined-right lined-top lined-left' align=center width=50>
            <a href='index.php?mode=search'><b>Basic</b></a>
            </td><td class='lined' align=center width=80>
            <a href='index.php?mode=search&type=advanced'>Advanced</a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="basic">
            <tr><td colspan=2 class='maingray'>Proximity to Me</td>
            <tr><td>Degrees</td><td><select name="degrees">
			<option value="any">anyone
			<option value="4">within 4&deg of me
			<option value="3">within 3&deg of me
			<option value="2">within 2&deg of me
			<option value="1">a friend
			</select></td>
            <tr><td>Distance</td><td><select name="distance">
			<option value="any">any distance
			<option value="5">5 miles
			<option value="10">10 miles
			<option value="25">25 miles
			<option value="100">100 miles
			</select></td>
            <tr><td>From</td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'>User Search</td>
	        <tr><td>First Name</td><td><input type=text size=15 name="fname"></td>
	        <tr><td>Last Name</td><td><input type=text size=15 name="lname"></td>
	        <tr><td>E-mail</td><td><input type=text size=15 name="email"></td>
	        <tr><td colspan=2><input type=submit value="Search All Users"></td>
	        </table></form></table>
            <? } elseif($type=='advanced'){ ?>
            <table class=body>
            <tr><td class='lined' align=center width=50>
            <a href='index.php?mode=search'><b>Basic</b></a>
            </td><td class='lined-right lined-top lined-left' align=center width=80>
            <a href='index.php?mode=search&type=advanced'>Advanced</a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="advanced">
            <tr><td colspan=2><input type='checkbox' name='only_wp' value='1'>&nbsp&nbspFind only people with photos</td>
            <tr><td colspan=2><input type='checkbox' name='only_ol' value='1'>&nbsp;&nbsp;Find only currently online users</td>
            <tr><td colspan=2 class='maingray'>Proximity to Me</td>
            <tr><td>Degrees</td><td><select name="degrees">
            <option value="any">any degree
			<option value="4">4&deg or closer
			<option value="3">3&deg or closer
			<option value="2">2&deg or closer
			<option value="1">1&deg friends
			</select></td>
            <tr><td>Distance</td><td><select name="distance">
			<option value="any">anywhere
			<option value="5">5 miles
			<option value="10">10 miles
			<option value="25">25 miles
			<option value="100">100 miles
			</select></td>
            <tr><td>From</td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'>User Search</td>
            <tr><td>Interests</td><td><input type=text size=15 name="interests"></td>
	        <tr><td>First Name</td><td><input type=text size=15 name="fname"></td>
	        <tr><td>Last Name</td><td><input type=text size=15 name="lname"></td>
	        <tr><td>E-mail</td><td><input type=text size=15 name="email"></td>
            <tr><td colspan=2 class='maingray'>Personal Information</td>
            <tr><td>Here For</td><td><input type=text size=15 name='here_for'></td>
            <tr><td>Gender</td><td><input type='radio' name='gender' value='m'>Male
            &nbsp<input type='radio' name='gender' value='f'>Female</td>
            <tr><td>Age</td><td><input type='text' size=5 name='age_from'>&nbspto&nbsp<input type='text' name='age_to' size=5></td>
            <tr><td>Schools</td><td><input type='text' size=15 name='schools'></td>
            <tr><td colspan=2 class='maingray'>Professional Information</td>
            <tr><td>Occupation</td><td><input type='text' size=15 name='occupation'></td>
            <tr><td>Company</td><td><input type='text' size=15 name='company'></td>
            <tr><td>Position</td><td><input type='text' size=15 name='position'></td>
            <tr><td colspan=2 class='maingray'>Display Preferences</td>
            <tr><td>Show</td><td><select name='show'>
            <option value='pnt'>Photos & Text
            <option value='po'>Photos Only
            </select></td>
            <tr><td>Sort By</td><td><select name='sort'>
            <option value='ll'>Last Login
            <option value='ff'>Friends First
            <option value='ma'>Miles Away
            </select></td>
	        <tr><td colspan=2><input type=submit value="Search"></td>
	        </table></form></table>
            <? } ?>
     </td>

              </table>
            <?
            show_footer();



}//function

?>