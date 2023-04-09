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
if($act=='create'){
  create_tribe();
}
elseif($act=='inv'){
  invite();
}
elseif($act=='show'){
  tribe_main();
}
elseif($act=='event'){
  event_action();
}
elseif($act=='board'){
  board_action();
}
elseif($act=='join'){
  join_tribe();
}
elseif($act=='unjoin'){
  unjoin_tribe();
}
elseif($act==''){
  show_t_cats();
}
elseif($act=='cat'){
  show_t_cat_list();
}
elseif($act=='manage'){
  manage_tribe();
}
elseif($act=='save'){
  save();
}
elseif($act=='upload'){
  upload_photo();
}
elseif($act=='view_mems'){
  view_tribe_members();
}

//showing tribes members, depending on page
function view_tribe_members(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$trb_id=form_get("trb_id");
tribe_access_test($m_id,$trb_id);

$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'>View Group Members</td>
       <tr><td><table align=center class='body'>";
       show_members($trb_id,"10","5","$page");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($trb_id,"members","$page","10");
       echo "</td>
       </table>";
       show_footer();

}//function

//showing tribe categories
function show_t_cats(){
$m_id=cookie_get("mem_id");
//$m_pass=cookie_get("mem_pass");
//login_test($m_id,$m_pass);

$sql_query="select tribes from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');

$tribes=split("\|",$mem->tribes);
$tribes=if_empty($tribes);

$sql_query="select t_cat_id from t_categories";
$res=sql_execute($sql_query,'res');
$cats=array();
while($cat=mysql_fetch_object($res)){
   array_push($cats,$cat->t_cat_id);
}//while

//find middle of array
$mid=(int)(count($cats)/2);

show_header();
?>
   <table width=100%>
       <tr><td width=75%>

              <table width=100% class=body>
              <?
              //showing user's tribes
              if($tribes!=''){
              echo "<tr><td class='lined'>
              <table width=100% class='body'>
              <tr><td class='title'>My Groups</td>
              <td align=right><a href='#directory'>directory</a> | <a href='#newest'>newest</a> | <a href='#popular'>popular</a></td>
              </table>
              </td>
              <tr><td class='padded-6 lined'>";
              foreach($tribes as $trb){
                 $sql_query="select name,mem_num from tribes where trb_id='$trb'";
                 $name=sql_execute($sql_query,'get');
                 echo "<b><a href='index.php?mode=tribe&act=show&trb_id=$trb'>$name->name</a></b></br>";
                 echo "$name->mem_num members, ".tribe_new_posts($m_id,$trb)."</br></br>";
              }
              echo "</td>";
              }
              ?>
              <tr><td class='lined'>
              <table width=100% class='body'>
              <tr><td class='title'>
              <a name='directory'>
              Group Categories
              </a></td>
              <td align=right><a href='#newest'>newest</a> | <a href='#popular'>popular</a></td>
              </table>
              </td>
              <tr><td class='padded-6 lined'>
                   <table width=100% class="body">
                         <tr><td>
                             <?
                               for($i=0;$i<$mid;$i++){

                                     $sql_query="select name from t_categories where t_cat_id='$cats[$i]'";
                                     $t_name=sql_execute($sql_query,'get');
                                     $sql_query="select trb_id from tribes where t_cat_id='$cats[$i]'";
                                     $num=sql_execute($sql_query,'num');

                                     echo "<a href='index.php?mode=tribe&act=cat&t_cat_id=$cats[$i]'><b>$t_name->name</b></a>
                                     &nbsp<a href='index.php?mode=tribe&act=cat&t_cat_id=$cats[$i]'>($num groups)</a></br></br>";


                               }//for
                             ?>
                         </td>
                         <td>
                             <?
                               for($i=$mid;$i<count($cats);$i++){

                                     $sql_query="select name from t_categories where t_cat_id='$cats[$i]'";
                                     $t_name=sql_execute($sql_query,'get');
                                     $sql_query="select trb_id from tribes where t_cat_id='$cats[$i]'";
                                     $num=sql_execute($sql_query,'num');

                                     echo "<a href='index.php?mode=tribe&act=cat&t_cat_id=$cats[$i]'><b>$t_name->name</b></a>&nbsp
                                     <a href='index.php?mode=tribe&act=cat&t_cat_id=$cats[$i]'>($num groups)</a></br></br>";

                               }//for
                             ?>
                         </td>
                   </table>
              </td>
              <tr><td class='lined'>
              <table width=100% class='body'>
              <tr><td class='title'>
              <a name='newest'>
              Newest Groups
              </a></td>
              <td align=right><a href='#directory'>directory</a> | <a href='#popular'>popular</a></td>
              </table>
              </td>
              <tr><td class='lined padded-6'>
                 <table width=100% class='body'>
                     <?
                        $sql_query="select * from tribes where type!='priv' order by added desc limit 0,10";
                        $res=sql_execute($sql_query,'res');
                        while($trb=mysql_fetch_object($res)){

                             $sql_query="select name from t_categories where t_cat_id='$trb->t_cat_id'";
                             $name=sql_execute($sql_query,'get');

                             $letters=preg_split('//',$trb->description);
                             $descr='';
                             for($i=0;$i<60;$i++){
                                $descr.=$letters[$i];
                             }
                             $descr.='...';

                             echo "<tr><td>
                             <b><a href='index.php?mode=tribe&act=show&trb_id=$trb->trb_id'>$trb->name</a>
                             &nbsp</b>(";echo tribe_type($trb->trb_id,'output');echo ") ";join_tribe_link($m_id,$trb->trb_id);
                             echo "</br>
                             Category: <a href='index.php?mode=tribe&act=cat&t_cat_id=$trb->t_cat_id'>$name->name</a></br>";
                             echo "$descr</td>";
                             echo "<td valign=top align=right>$trb->mem_num members</td>";
                             echo "<tr><td>&nbsp</td>";

                        }//while

                     ?>
                 </table>
              </td>
              <tr><td class='lined'>
              <table width=100% class='body'>
              <tr><td class='title'>
              <a name='popular'>
              Most Popular Groups
              </a></td>
              <td align=right><a href='#directory'>directory</a> | <a href='#newest'>newest</a></td>
              </table>
              </td>
              <tr><td class='lined padded-6'>
                 <table width=100% class='body'>
                     <?
                        $sql_query="select * from tribes where type!='priv' order by mem_num desc limit 0,10";
                        $res=sql_execute($sql_query,'res');
                        while($trb=mysql_fetch_object($res)){

                             $sql_query="select name from t_categories where t_cat_id='$trb->t_cat_id'";
                             $name=sql_execute($sql_query,'get');

                             $letters=preg_split('//',$trb->description);
                             $descr='';
                             for($i=0;$i<60;$i++){
                                $descr.=$letters[$i];
                             }
                             $descr.='...';

                             echo "<tr><td>
                             <b><a href='index.php?mode=tribe&act=show&trb_id=$trb->trb_id'>$trb->name</a>
                             &nbsp</b>(";echo tribe_type($trb->trb_id,'output');echo ") ";join_tribe_link($m_id,$trb->trb_id);
                             echo "</br>
                             Category: <a href='index.php?mode=tribe&act=cat&t_cat_id=$trb->t_cat_id'>$name->name</a></br>";
                             echo "$descr</td>";
                             echo "<td valign=top align=right>$trb->mem_num members</td>";
                             echo "<tr><td>&nbsp</td>";

                        }//while

                     ?>
                 </table>
              </td>
              </table>

       </td>
       <td valign=top>

            <table width=100% class='body'>
               <tr><td class='lined padded-6' align=center><input type=button value='Create A Group' onClick='window.location="index.php?mode=tribe&act=create"'></td>
               <tr><td class='lined title'>Search Groups</td>
               <tr><td class='padded-6 lined'>
               <form action="index.php" method='post'>
               <input type=hidden name="mode" value="search">
			   <input type=hidden name="act" value="tribe">
			   <input type=hidden name="type" value="normal">
               Keywords</br>
               <input type='text' name='keywords'></br>
               <input type='submit' value='Search'></form>
               </td>
            </table>
       </td>
   </table>
<?
show_footer();
}//function

//showing tribes of one category
function show_t_cat_list(){
$m_id=cookie_get("mem_id");
//$m_pass=cookie_get("mem_pass");
//login_test($m_id,$m_pass);

$sql_query="select tribes from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');

$tribes2=split("\|",$mem->tribes);
$tribes2=if_empty($tribes);

$t_cat_id=form_get("t_cat_id");
$sql_query="select name from t_categories where t_cat_id='$t_cat_id'";
$c_name=sql_execute($sql_query,'get');

$sql_query="select trb_id from tribes where t_cat_id='$t_cat_id' and type!='priv'";
$res=sql_execute($sql_query,'res');

$tribes=array();
while($trb=mysql_fetch_object($res)){
array_push($tribes,$trb->trb_id);
}//while

show_header();
?>
   <table width=100%>
       <tr><td width=75% valign=top>

              <table width=100% class=body>
              <? if($tribes2!=''){
              echo "<tr><td class='lined title'>My Groups</td>
              <tr><td class='padded-6 lined'>";
              foreach($tribes as $trb){
                 $sql_query="select name,mem_num from tribes where trb_id='$trb'";
                 $name=sql_execute($sql_query,'get');
                 echo "<b><a href='index.php?mode=tribe&act=show&trb_id=$trb'>$name->name</a></b></br>";
                 echo "$name->mem_num members, ".tribe_new_posts($m_id,$trb)."</br></br>";
              }
              echo "</td>";
              }
              ?>
              <tr><td class='lined title'>Group Category: <? echo $c_name->name; ?></td>
              <tr><td class='lined padded-6'>
              <table class='body' width=100%>
                        <?
                        foreach($tribes as $trb_id){

                        $sql_query="select * from tribes where trb_id='$trb_id'";
                        $trb=sql_execute($sql_query,'get');

                             $letters=preg_split('//',$trb->description);
                             $descr='';
                             for($i=0;$i<60;$i++){
                                $descr.=$letters[$i];
                             }
                             $descr.='...';

                             echo "<tr><td>
                             <b><a href='index.php?mode=tribe&act=show&trb_id=$trb->trb_id'>$trb->name</a>
                             &nbsp</b>(";echo tribe_type($trb->trb_id,'output');echo ") ";join_tribe_link($m_id,$trb->trb_id);
                             echo "</br>";
                             echo "$descr</td>";
                             echo "<td valign=top align=right>$trb->mem_num members</td>";
                             echo "<tr><td>&nbsp</td>";


                        }//foreach
                        ?>
                  </table>
              </td>
              </table>

       </td>
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
       </td>
   </table>
<?
show_footer();

}//function

function create_tribe(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$pro=form_get("pro");

if($pro==''){
   show_header();
   ?>
   <table width=100% class='body'>
      <tr><td class="lined title">Create A New Group</td>
      <tr><td class="lined padded-6">

<P>The description you create will appear in the Group directory so others who share your interests can find you easily. Select keywords that relate closely to your Group's topic.</p>
<p>As Group moderator, you'll be able to edit this information at any time; click the "Manage Group" link on the right side of your Group's main page.</p>
<p class='orangebody'>all fields marked with an * are required</p>
</br>
<table class='body'>
<form action='index.php' method='post' enctype='multipart/form-data'>
<input type='hidden' name='mode' value='tribe'>
<input type='hidden' name='act' value='create'>
<input type='hidden' name='pro' value='done'>
  <tr><td>Group Name <span class='orangebody'>*</span></td><td><input type='text' name='name'></td>
  <tr><td>Group Category <span class='orangebody'>*</span></td><td><select name='t_cat_id'><? drop_t_cats(''); ?></select></td>
  <tr><td>Group Description <span class='orangebody'>*</span></td><td><textarea name='description' cols=45 rows=5></textarea></td>
  <tr><td valign=top>Group Type <span class='orangebody'>*</span></td>
  <td>
  <input type=radio checked name=type value='pub'>Public - anyone may join</br>
  <input type=radio name=type value='mod'>Moderated - joining requires approval by moderator</br>
  <input type=radio name=type value='priv'>Private - Group is only visible to members, and membership is by invitation only
  </td>
  <tr><td>Group URL </td><td>
  <table class='body'><tr><td><? global $main_url,$tribes_folder;echo $main_url."/".$tribes_folder."/"; ?>
  </td><td><input type='text' size=10 name='url'></td>
  <tr><td></td><td><span class='form-comment'>Lower case text only allowed</span></td></table></td>
  <tr><td>ZIP/Postal Code </td><td><input type='text' name='zip'></td>
  <tr><td>Country </td><td><select name='country'><? country_drop(); ?></select></td>
  <tr><td>Photo </td><td><input type='file' name='photo'></td>
  <tr><td colspan=2 align=right><input type='submit' value='Create Group'></td>
</form>
</table>

      </td>
   </table>
   <?
   show_footer();

}//if
elseif($pro=='done'){
global $_FILES,$main_url,$base_path;
$form_data=array('name','t_cat_id','description','type','url','zip','country');
while (list($key,$val)=each($form_data)){
${$val}=form_get("$val");
}//while

//checkin required fields
if(($name=='')||($t_cat_id=='')||($description=='')||($type=='')||($type=='')||($url=='')){
   error_screen(21);
}//if

//checkin if url value is already used
$url=strtolower($url);
$url=ereg_replace("[^A-Za-z|0-9]","",$url);
$sql_query="select trb_id from tribes where url='$url'";
$num=sql_execute($sql_query,'num');
if($num>0){
  error_screen(22);
}
//checkin if name is used
$sql_query="select trb_id from tribes where name='$name' and $t_cat_id='$t_cat_id'";
$num=sql_execute($sql_query,'num');
if($num>0){
  error_screen(27);
}

$tmpfname=$_FILES['photo']['tmp_name'];
$ftype=$_FILES['photo']['type'];
$fsize=$_FILES['photo']['size'];

//if photo uploaded making thumbnails
if($tmpfname!=''){
	if(($ftype=='image/jpeg')||($ftype=='image/pjpeg')){
	  $p_type=".jpeg";
	}//elseif
	elseif($ftype=='image/gif'){
	  $p_type=".gif";
	}//elseif
	else {
	  error_screen(9);
	}//else

    $rand=rand(0,10000);
	$newname=md5($m_id.time().$rand);
	$newname_th=$newname."th";
	$newname_b_th=$newname."bth";
	$old=$base_path."/photos/".$newname.$p_type;
	$thumb1=$base_path."/photos/".$newname_th.".jpeg";
	$thumb2=$base_path."/photos/".$newname_b_th.".jpeg";

	move_uploaded_file($tmpfname,$base_path."/photos/".$newname.$p_type);

    	//creating thumbnails
	    if($p_type==".jpeg"){
	    $srcImage = ImageCreateFromJPEG( $old );
	    }//elseif
	    elseif($p_type==".gif"){
	    $srcImage = ImageCreateFromGIF( $old );
	    }//elseif

	    $sizee=getimagesize($old);
	    $srcwidth=$sizee[0];
	    $srcheight=$sizee[1];


	    //landscape
	    if($srcwidth>$srcheight){
	    $destwidth1=65;
	    $rat=$destwidth1/$srcwidth;
	    $destheight1=(int)($srcheight*$rat);
	    $destwidth2=150;
	    $rat2=$destwidth2/$srcwidth;
	    $destheight2=(int)($srcheight*$rat2);
	    }
	    //portrait
	    elseif($srcwidth<$srcheight){
	    $destheight1=65;
	    $rat=$destheight1/$srcheight;
	    $destwidth1=(int)($srcwidth*$rat);
	    $destheight2=150;
	    $rat=$destheight2/$srcheight;
	    $destwidth2=(int)($srcwidth*$rat);
	    }
	    //quadro
	    elseif($srcwidth==$srcheight){
	    $destwidth1=65;
	    $destheight1=65;
	    $destwidth2=150;
	    $destheight2=150;
	    }

	    $destImage1 = ImageCreateTrueColor( $destwidth1, $destheight1);
	    $destImage2 = ImageCreateTrueColor( $destwidth2, $destheight2);
	    ImageCopyResized( $destImage1, $srcImage, 0, 0, 0, 0, $destwidth1, $destheight1, $srcwidth, $srcheight );
	    ImageCopyResized( $destImage2, $srcImage, 0, 0, 0, 0, $destwidth2, $destheight2, $srcwidth, $srcheight );
	    ImageJpeg($destImage1, $thumb1, 80);
	    ImageJpeg($destImage2, $thumb2, 80);
	    ImageDestroy($srcImage);
	    ImageDestroy($destImage1);
	    ImageDestroy($destImage2);

	$photo="photos/".$newname.$p_type;
	$photo_b_thumb="photos/".$newname_b_th.".jpeg";
	$photo_thumb="photos/".$newname_th.".jpeg";


}//if
else {
	$photo="no";
	$photo_b_thumb="no";
	$photo_thumb="no";
}//else

$now=time();

//updating db
$sql_query="insert into tribes (mem_id,name,t_cat_id,description,type,url,zip,country,photo,photo_thumb,photo_b_thumb,added,members)
values('$m_id','$name','$t_cat_id','$description','$type','$url','$zip','$country','$photo','$photo_thumb','$photo_b_thumb','$now','$m_id')";
sql_execute($sql_query,'');

$sql_query="select max(trb_id) as maxid from tribes";
$trb=sql_execute($sql_query,'get');

$sql_query="insert into tribe_photo(trb_id) values('$trb->maxid')";
sql_execute($sql_query,'');

$sql_query="update members set tribes=concat(tribes,'|$trb->maxid') where mem_id='$m_id'";
sql_execute($sql_query,'');

global $main_url,$base_path, $tribes_folder;
$subdomain=$base_path."/".$tribes_folder."/".$url;

//the next text is if you'd like subdomain to be created for each tribe. Just specify
//subdomain value in data.inc and uncomment the next lines
$link=$main_url."/index.php?mode=tribe&act=show&trb_id=$trb->maxid";
$out="<? Header(\"Location: $link\"); ?>";

if(!file_exists("$subdomain")){
  mkdir("$subdomain",0777);
  $f=fopen("$subdomain/index.php","w");
  fwrite($f,$out);
  fclose($f);
}
  //redirect
$link=$main_url."/index.php?mode=tribe&act=inv&trb_id=$trb->maxid";
show_screen($link);

}//elseif

}//function

//invite user to tribe
function invite(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$trb_id=form_get("trb_id");
$sql_query="select * from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');

$pro=form_get("pro");
if($pro==''){
  show_header();
  ?>
  <table width=100% class='body'>
  <form action='index.php' method=post>
  <input type='hidden' name='mode' value='tribe'>
  <input type='hidden' name='act' value='inv'>
  <input type='hidden' name='pro' value='done'>
  <input type='hidden' name='trb_id' value='<? echo $trb_id; ?>'>
  <tr><td colspan=2 class="lined title">Invite People to Join <? echo $trb->name; ?></td>
  <tr><td class='lined padded-6'>
  <table class='body' width=100%>
  <tr><td>Your friends</td><td><select name='rec_id[]'>
   <? drop_friends($m_id); ?>
   </select></br>
   <select name='rec_id[]'>
   <? drop_friends($m_id); ?>
   </select></br>
   <select name='rec_id[]'>
   <? drop_friends($m_id); ?>
   </select>
   </td>
   <tr><td>Subject</td><td><input type='text' name='subject' value='Invitation to join a group'></td>
   <tr><td>Your message</td><td><textarea rows=5 cols=45 name='body'></textarea></td>
   <tr><td></td><td><input type='button' onClick='window.location="index.php?mode=tribe&act=show&trb_id=<? echo $trb_id; ?>"' value='Skip'><input type='submit' value='Send'></td></form>
  </table></td></table>
  <?
  show_footer();

}//if
elseif($pro=='done'){
global $main_url;
$subject=form_get("subject");
$body=form_get("body");
$rec_id=form_get("rec_id");
$rec_id=if_empty($rec_id);
$now=time();
$sql_query="select mem_id from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');

if(($rec_id=='')||($subject=='')||($body=='')){
  error_screen(3);
}//if

        if($rec_id!=''){
        //if user is creator of tribe
        if($m_id==$trb->mem_id){
        foreach($rec_id as $rid){

        $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date,special)
        values('$rid','$m_id','$subject','$body','trb_inv','inbox','$now','$trb_id')";
        sql_execute($sql_query,'');

        }//foreach
        }//if
        else{
        //if this is not a creator of tribe
        foreach($rec_id as $rid){
        $join=$main_url."/index.php?mode=tribe&act=join&trb_id=$trb_id";
        $body.="\n"."<a href=$join>join</a>";
        $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date,special)
        values('$rid','$m_id','$subject','$body','message','inbox','$now','$trb_id')";
        sql_execute($sql_query,'');
        }//foreach
        }//else
        }//if
 //redirect
 $link=$main_url."/index.php?mode=tribe&act=show&trb_id=$trb_id";
 show_screen($link);

}//elseif
}//function

//main tribe page
function tribe_main(){
global $main_url,$cookie_url,$tribes_folder;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$trb_id=form_get("trb_id");
tribe_access_test($m_id,$trb_id);
//updating history of user's surfing the site
if($m_id!=''){
  $sql_query="select history from members where mem_id='$m_id'";
  $mem=sql_execute($sql_query,'get');
  $hist=split("\|",$mem->history);
  $hist=if_empty($hist);
  if($hist==''){
    $hist[]='';
  }
  $adding="index.php?mode=tribe&act=show&trb_id=$trb_id";
  if(!in_array($adding,$hist)){
  $sql_query="select name from tribes where trb_id='$trb_id'";
  $trb=sql_execute($sql_query,'get');
  $addon="|$adding|".$trb->name;
  if(count($hist)>=10){
     for($i=2;$i<count($hist);$i++){
         $line.=$hist[$i]."|";
     }//for
     $line.=$addon;
     $sql_query="update members set history='$line' where mem_id='$m_id'";
  }//if
  else {
  $sql_query="update members set history=concat(history,'$addon') where mem_id='$m_id'";
  }//else
  sql_execute($sql_query,'');
  }//if
}//if
$now=time();
global $cookie_url;
SetCookie("$trb_id","$now",time()+60*60*24*365,"/",$cookie_url);
$sql_query="select * from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
$members=split("\|",$trb->members);
$members=if_empty($members);
show_header();
?>
  <table width=100%>
     <tr><td>

        <table class=lined>
        <tr><td width=30%>
            <table class='body' width=100%>
            <tr><td class="lined" align=center>
            <? show_tribe_photo($trb_id); ?>
            </br>
            <b><? echo $trb->name; ?></b>&nbsp<? join_tribe_link($m_id,$trb_id); ?></br>
            <? tribe_photo_link($trb_id); ?></br>
            </td>
            <tr><td class=lined align=center>
            <? tribe_members_link($trb_id); ?></br>
            <? echo tribe_type($trb_id,"output"); ?></br>
            <input type='button' value='Invite a Friend' onClick='window.location="index.php?mode=tribe&act=inv&trb_id=<? echo $trb_id; ?>"'>
            </td>
            </table>
        </td>
        <td>
            <table class='body' align=center>
            <tr><td class="orangeheader"><? echo $trb->name; ?></td>
            <tr><td>A <? echo tribe_category($trb_id); ?> group.</td>
            <tr><td><span class='maingray'>Moderator</span></td>
            <tr><td>
            <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($trb->mem_id); ?></br>
               <? show_online($trb->mem_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$trb->mem_id); ?></td>
               <tr><td class='padded-6'>Network: <a href='index.php?mode=people_card&act=friends&p_id=<? echo $trb->mem_id; ?>'><? echo count_network($trb->mem_id,"1","num"); ?> friends</a> in a
               <a href='index.php?mode=people_card&act=network&p_id=<? echo $trb->mem_id; ?>'>network of <? echo count_network($trb->mem_id,"all","num"); ?></a>
               </td>
            </table>
            </td>
            <tr><td><span class='maingray'>Description</span></td>
            <tr><td><? echo $trb->description; ?></td>
            <tr><td><span class='maingray'>Public URL</span></td>
            <tr><td><? echo "<a href='$main_url/$tribes_folder/$trb->url'>$main_url/$tribes_folder/$trb->url</a>"; ?></td>
            </table>
        </td>
        	<tr><td valign=top>
                <table width=100% class='body'>
                <tr><td class="lined title">Members</td>
                <tr><td class='lined'><table><? show_members($trb_id,"6","2","1"); ?></table></td>
                </table>
        	</td>
            <td valign=top>
                <table width=100% class='body'>
                <tr><td class="lined title">Listings from <? echo $trb->name; ?></td>
                <tr><td class="lined"><? show_listings("tribe",$trb_id,''); ?></td>
                <tr><td class="lined" align=center><input type=button value='Create a Group Listing' onClick='window.location="index.php?mode=listing&act=create&trb_id=<? echo $trb_id; ?>"'></td>
                <tr><td>&nbsp</td>
                <tr><td class="lined title">Discussion Board</td>
                <tr><td>
                <table class='body padded-6 lined' width=100%>
                <? show_board($trb_id); ?>
                </table>
                </td>
                <tr><td align=center class="lined"><input type='button' value='Post New Topic' onClick='window.location="index.php?mode=tribe&act=board&pro=new&trb_id=<? echo $trb_id; ?>"'></td>
                <tr><td>&nbsp</td>
                <tr><td class="lined title">Events</td>
                <tr><td class='lined padded-6'><? show_events($trb_id); ?></td>
                <tr><td class='lined' align=center><input type='button' value='Add An Event' onClick='window.location="index.php?mode=tribe&act=event&pro=add&trb_id=<? echo $trb_id; ?>"'></td>
                <tr><td>&nbsp</td>
                </table>
            </td>
    	</table>

     </td>
     <td valign=top>
     <table class="body">
    <tr><td><table class="lined body">
    <tr><td class=lined><? show_photo($m_id); ?></br>
    <? show_online($m_id); ?>
    </td>
    <td>Member Since <? echo member_since($m_id); ?>
    </br></br>
    <a href='index.php?mode=people_card&act=friends&p_id=<? echo $m_id; ?>'><? echo count_network($m_id,"1","num"); ?> Friends</a></br>
    <a href='index.php?mode=people_card&act=network&p_id=<? echo $m_id; ?>'><? echo count_network($m_id,"all","num"); ?> in my Network</a></br>&nbsp
    </td>
    </table></td>
    <tr><td>
        <table class="shade lined body" width=100%>
        <tr><td bgcolor=white class="bodygray bold">WHAT CAN I DO NOW?</td>
        <? if($m_id==$trb->mem_id){
        //if user is owner of a tribe
        ?>
           <tr><td><img src="images/medicon_tribe.gif"><a href="index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>">
           Manage Group
           </a></td>
        <? }
        else { ?>
        <?
        $sql_query="select members from tribes where trb_id='$trb_id'";
	    $trb=sql_execute($sql_query,'get');

	    $members=split("\|",$trb->members);
	    $members=if_empty($members);
	    $link="<tr><td><img src='images/medicon_tribe.gif'><a href='index.php?mode=tribe&act=join&trb_id=$trb_id'>
           Join Group
           </a></td>";
        $link2="<tr><td><img src='images/medicon_tribe.gif'><a href='index.php?mode=tribe&act=unjoin&trb_id=$trb_id'>
           Unsubscribe To This Group
           </a></td>";
	    if($members==''){
	      echo $link;
	    }//if
	    else {
	    $flag=0;
	      foreach($members as $mem){

	          if($mem==$m_id){
	             $flag=1;
	             break;
	          }//if

	      }//foreach
	    if($flag==0){
	       echo $link;
	    }//if
        else {
           echo $link2;
        }//else
	    }//else
        }//else
        ?>
           <tr><td><img src="images/medicon_tribe.gif"><a href="index.php?mode=tribe&act=board&pro=new&trb_id=<? echo $trb_id; ?>">
           Post To Discussion Board
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=tribe&act=inv&trb_id=<? echo $trb_id; ?>">
           Invite a Friend to Group
           </a></td>
           <tr><td><img src="images/medicon_tribe.gif"><a href="index.php?mode=tribe&act=event&pro=add&trb_id=<? echo $trb_id; ?>">
           Create a Group Event
           </a></td>
           <tr><td><img src="images/medicon_tribe.gif"><a href="index.php?mode=listing&act=create&trb_id=<? echo $trb_id; ?>">
           Create a Group Listing
           </a></td>
           <? $sql_query="select bmr_id from bmarks where mem_id='$m_id' and type='tribe'
           and sec_id='$trb_id'";
           $num=sql_execute($sql_query,'num');
           if($num==0){
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $trb_id; ?>&type=tribe">
           Bookmark this Group
           </a></td>
           <?
           }
           else {
             $bmr=sql_execute($sql_query,'get');
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>">
           Un-Bookmark this Group
           </a></td>
           <?
           }
           ?>
        </table></td>
          <?
     $sql_query="select * from bmarks where mem_id='$m_id'";
     $num=sql_execute($sql_query,'num');
     if($num==0){
     }
     else {
        echo "<tr><td width=100%>
        <table class='td-shade lined body' width=100%>
             <tr><td bgcolor=white class='bodygray bold'>My Bookmarks</td>";
       $res=sql_execute($sql_query,'res');
       while($bmr=mysql_fetch_object($res)){

              if($bmr->type=="member"){

                  echo "<tr><td>
                  <img src='images/medicon_person.gif' border=0>
                  <a href='index.php?mode=people_card&p_id=$bmr->sec_id'>".
                  name_header($bmr->sec_id,$m_id)."</a>
                  </td>";

              }//if

              elseif($bmr->type=="listing"){

                  $sql_query="select title from listings where lst_id='$bmr->sec_id'";
                  $lst=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/icon_listing.gif' border=0>
                  &nbsp&nbsp<a href='index.php?mode=listing&act=show&lst_id=$bmr->sec_id'>".
                  $lst->title."</a>
                  </td>";

              }//elseif

              elseif($bmr->type=="tribe"){

                  $sql_query="select name from tribes where trb_id='$bmr->sec_id'";
                  $trb=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/medicon_tribe.gif' border=0>
                  <a href='index.php?mode=tribe&act=show&trb_id=$bmr->sec_id'>".
                  $trb->name."</a>
                  </td>";

              }//elseif

       }//while
     echo "</table></td>";
     }//else
             ?>




        </table></td></table>


<?
show_footer();
}//function

function event_action(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$trb_id=form_get("trb_id");
tribe_access_test($m_id,$trb_id);
$sql_query="select mem_id from tribes where trb_id='$trb_id'";
$spe=sql_execute($sql_query,'get');
if($m_id==$spe->mem_id){
  $owner=1;
}//if
else {
  $owner=0;
}//else
$pro=form_get("pro");

//add event
if($pro=='add'){

   $done=form_get("done");
   if($done==''){
          show_header();
          ?>
          <table width=100% class='body'>
             <tr><td class="lined title">Add An Event</td>
             <tr><td class="lined">
                 <table align=center class='body'>
                 <form action='index.php' method='post'>
                 <input type='hidden' name='mode' value='tribe'>
                 <input type='hidden' name='act' value='event'>
                 <input type='hidden' name='pro' value='add'>
                 <input type='hidden' name='done' value='done'>
                 <input type='hidden' name='trb_id' value='<? echo $trb_id; ?>'>
                     <tr><td>Event Title</td><td><input type='text' name='title'></td>
                     <tr><td>Description</td><td><textarea rows=5 cols=45 name='description'></textarea></td>
                     <tr><td>Start Date</td><td>
                     <select name='month'>
                     <?
                     $m=date("m");
                     $d=date("j");
                     month_drop("$m"); ?>
                     </select>
                     <select name='day'>
                     <? day_drop("$d"); ?>
                     </select>
                     <select name='year'>
                     <? year_drop('now'); ?>
                     </select>
                     </td>
                     <tr><td>Start Time</td><td>
                     <select name='hour'>
                     <option value=''>Hour
                     <option value='1'>1
                     <option value='2'>2
                     <option value='3'>3
                     <option value='4'>4
                     <option value='5'>5
                     <option value='6'>6
                     <option value='7'>7
                     <option value='8'>8
                     <option value='9'>9
                     <option value='10'>10
                     <option value='11'>11
                     <option value='12'>12
                     </select>
                     <select name='min'>
                     <option value=''>Minute
                     <option value='0'>0
                     <option value='15'>15
                     <option value='30'>30
                     <option value='45'>45
                     </select>
                     <select name='ap'>
                     <option value=''>AM/PM
                     <option value='am'>AM
                     <option value='pm'>PM
                     </select>
                     </td>
                     <tr><td>End Date</td><td>
                     <select name='month_e'>
                     <option value=''>Month
                     <? month_drop(""); ?>
                     </select>
                     <select name='day_e'>
                     <option value=''>Day
                     <? day_drop(""); ?>
                     </select>
                     <select name='year_e'>
                     <option value=''>Year
                     <? year_drop('now'); ?>
                     </select>
                     </td>
                     <tr><td colspan=2 align=right><input type=submit value='Add An Event'></td>
                 </table>
             </td>
          </table>
          <?
          show_footer();

   }//if
   elseif($done=='done'){
         $form_data=array('title','description','day','month',
         'year','day_e','month_e','year_e','min','hour','ap');
         while (list($key,$val)=each($form_data)){
	     	${$val}=form_get("$val");
	     }//while

         if(($title=='')||($description=='')){
            error_screen(3);
         }//if

         $start_time='';
         $end_date='';

         //making unix time for each date and time values
         $start_date=mktime(0,0,0,$month,$day,$year);
         if(($min!='')&&($hour!='')){

           if($ap==''){
             error_screen(19);
           }
           if($ap=='pm'){
              $hour=$hour+12;
           }//if
           $start_time=mktime($hour,$min,0,$month,$day,$year);

         }//if

         if(($month_e!='')&&($day_e!='')&&($year!='')){
           $end_date=mktime(0,0,0,$month_e,$day_e,$year_e);
         }//if

         //updating db and redirect
         $sql_query="insert into events (trb_id,mem_id,title,description,start_date,start_time,end_date)
         values('$trb_id','$m_id','$title','$description','$start_date','$start_time','$end_date')";
         sql_execute($sql_query,'');

         global $main_url;
         $link=$main_url."/index.php?mode=tribe&act=show&trb_id=$trb_id";
         show_screen($link);

   }//elseif

}//if
//view event
elseif($pro=='view'){
$evn_id=form_get("evn_id");

$sql_query="select * from events where evn_id='$evn_id'";
$evn=sql_execute($sql_query,'get');

$start_date=date("m/d/Y", $evn->start_date);
$start_time=date("h:i A",$evn->start_time);
$end_date=date("m/d/Y",$evn->end_date);
show_header();
?>
    <table width=100%>
           <tr><td class="lined padded-6 title">View Event</td>
           <tr><td class="lined padded-6">
        <table width=100% class='body'>
            <tr><td align=right class="title">From</td>
            <td>
            <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($evn->mem_id); ?></br>
               <? show_online($evn->mem_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$evn->mem_id); ?></td>
               <tr><td class='padded-6'>Network: <a href='index.php?mode=people_card&act=friends&p_id=<? echo $evn->mem_id; ?>'><? echo count_network($evn->mem_id,"1","num"); ?> friends</a> in a
               <a href='index.php?mode=people_card&act=network&p_id=<? echo $evn->mem_id; ?>'>network of <? echo count_network($evn->mem_id,"all","num"); ?></a>
               </td>
            </table>
            </td>
            <tr><td align=right class="title">Event</td>
            <td>
            <? echo $evn->title; ?>
            </td>
            <tr><td align=right class="title">Description</td>
            <td>
            <? echo $evn->description; ?>
            </td>
            <tr><td align=right class="title">Starts</td>
            <td>
            <? echo $start_date;
            if($evn->start_time!='0'){
              echo ", at $start_time";
            }//if
            if($evn->end_date!='0'){
            ?>
            </td>
            <tr><td align=right class="title">Ends</td>
            <td>
            <?

              echo $end_date;
            }//if
            ?>
            </td>
            <?
            if(($evn->mem_id==$m_id)||($owner==1)){
            ?>
            <tr><td colspan=2 class='td-shade lined' align=center>
            <input type='button' value='Delete'
            onclick='window.location="index.php?mode=tribe&act=event&pro=del&evn_id=<? echo $evn->evn_id; ?>&trb_id=<? echo $trb_id; ?>"'></td>
            <?
            }//if
            ?>
        </table>
      </td>
  </table>
<?
show_footer();
}//elseif
//delete event only if user is creator of tribe or event
elseif($pro=='del'){
$home=form_get("home");
$evn_id=form_get("evn_id");
$sql_query="delete from events where evn_id='$evn_id'";
sql_execute($sql_query,'');
if($home!=''){
  global $main_url;
  $link=$main_url."/index.php?mode=login&act=home";
  show_screen($link);
}//if
else {
tribe_main();
}//else
}//elseif
}//function

function board_action(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$trb_id=form_get("trb_id");
tribe_access_test($m_id,$trb_id);

$pro=form_get("pro");

//post new topic
if($pro=='new'){

    $done=form_get("done");
    if($done==''){
    show_header();
      ?>
      <table width=100% class='body'>
         <tr><td class="lined title">Post New Topic</td>
         <tr><td class=lined>
                 <table align=center class='body'>
                 <form action='index.php' method='post'>
                 <input type='hidden' name='mode' value='tribe'>
                 <input type='hidden' name='act' value='board'>
                 <input type='hidden' name='pro' value='new'>
                 <input type='hidden' name='done' value='done'>
                 <input type='hidden' name='trb_id' value='<? echo $trb_id; ?>'>
                     <tr><td>Subject</td><td><input type=text name='subject'></td>
                     <tr><td>Post</td><td><textarea name='post' rows=5 cols=45></textarea></td>
                     <tr><td></td><td><input type='submit' value='Post New Topic'></td>
                 </form>
                 </table>
         </td>
      </table>
      <?
      show_footer();
    }//if
    elseif($done=='done'){
       $subject=form_get("subject");
       $post=form_get("post");
       $now=time();

       if(($subject=='')||($post=='')){
         error_screen(3);
       }

       $sql_query="insert into board (trb_id,topic,post,mem_id,added)
       values('$trb_id','$subject','$post','$m_id','$now')";
       sql_execute($sql_query,'');

       tribe_main();

    }//elseif


}//if
//reply to the post
elseif($pro=='reply'){
$top_id=form_get("top_id");
$sql_query="select * from board where top_id='$top_id'";
$brd=sql_execute($sql_query,'get');

    $done=form_get("done");
    if($done==''){
    show_header();
      ?>
      <table width=100%>
         <tr><td class="lined title">Post a Reply</td>
         <tr><td class=lined>
                 <table align=center class='body'>
                 <form action='index.php' method='post'>
                 <input type='hidden' name='mode' value='tribe'>
                 <input type='hidden' name='act' value='board'>
                 <input type='hidden' name='pro' value='reply'>
                 <input type='hidden' name='done' value='done'>
                 <input type='hidden' name='trb_id' value='<? echo $trb_id; ?>'>
                 <input type='hidden' name='top_id' value='<? echo $top_id; ?>'>
                     <tr><td>Subject</td><td><input type=text name='subject' value='Re: <? echo $brd->topic; ?>'></td>
                     <tr><td>Original Message</td><td><? echo $brd->post; ?></td>
                     <tr><td>Your Reply</td><td><textarea rows=5 cols=45 name='post'></textarea></td>
                     <tr><td></td><td><input type='submit' value='Post Reply'></td>
                 </form>
                 </table>
         </td>
      </table>
      <?
      show_footer();
    }//if
    elseif($done=='done'){
       $subject=form_get("subject");
       $post=form_get("post");
       $now=time();

       $sql_query="insert into replies (top_id,subject,post,mem_id,added)
       values('$top_id','$subject','$post','$m_id','$now')";
       sql_execute($sql_query,'');

       tribe_main();

    }//elseif
}//elseif
//view post and replies
elseif($pro=='view'){
   $top_id=form_get("top_id");

   $sql_query="select * from board where top_id='$top_id'";
   $brd=sql_execute($sql_query,'get');
   $date=date("d/m/Y",$brd->added);
   show_header();
   ?>
     <table width=100%>
          <tr><td class="lined title">Group Discussion</td>
          <tr><td class=lined>
              <table class='body'>
              <tr><td vasilek class=lined-right><? show_photo($brd->mem_id); ?></br>
               <? show_online($brd->mem_id); ?>
               </td>
               <td valign=top><? echo $date; ?></br>
               <span class="maingray"><? echo $brd->topic; ?></br></span>
               <? echo $brd->post; ?></br>
               <span class='action'><a href='index.php?mode=tribe&act=board&pro=reply&top_id=<? echo $top_id; ?>&trb_id=<? echo $trb_id; ?>'>reply to this post</a></span>
               </td>
               </table>
               <?
                   $sql_query="select * from replies where top_id='$top_id' order by added asc";
                   $res=sql_execute($sql_query,'res');
                   while($rep=mysql_fetch_object($res)){
                   $rep_date=date("m/d/Y",$rep->added);
                   ?>
              <table class='body'>
              <tr><td width=10>&nbsp</td>
              <td vasilek class=lined-right><? show_photo($rep->mem_id); ?></br>
               <? show_online($rep->mem_id); ?>
               </td>
               <td valign=top><? echo $rep_date; ?></br>
               <span class="maingray"><? echo $rep->subject; ?></br></span>
               <? echo $rep->post; ?></br>
               <span class='action'><a href='index.php?mode=tribe&act=board&pro=reply&top_id=<? echo $top_id; ?>&trb_id=<? echo $trb_id; ?>'>reply to this post</a></span>
               </td>
               </table>
                   <?
                   }//while

               ?>
          </td>
     </table>
   <?
   show_footer();


}//elseif
}//function

function join_tribe(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$trb_id=form_get("trb_id");

$type=tribe_type($trb_id,'get');

//error if user is already a member of a tribe
$members=tribe_members($trb_id);
if($members!=''){
   if(in_array($m_id,$members)){
      error_screen(20);
   }//if
}//if

//if public - member immediatly becomes tribe member
if($type=='pub'){

       $sql_query="update members set tribes=concat(tribes,'|$trb_id') where mem_id='$m_id'";
       sql_execute($sql_query,'');
       $sql_query="update tribes set members=concat(members,'|$m_id'),mem_num=mem_num+1 where trb_id='$trb_id'";
       sql_execute($sql_query,'');

       tribe_main();

}//if
//if moderated - request is sending
elseif($type=='mod'){

        $sql_query="select mem_id from tribes where trb_id='$trb_id'";
        $trb=sql_execute($sql_query,'get');
        $now=time();

        $sql_query="select mes_id from messages_system
        where mem_id='$trb->mem_id' and frm_id='$m_id' and type='trb_req'";

        $num=sql_execute($sql_query,'num');
        if($num==0){
        $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date,special)
        values('$trb->mem_id','$m_id','','','trb_req','inbox','$now','$trb_id')";
        sql_execute($sql_query,'');
        }//if

        complete_screen(4);

}//elseif
//if private - access denied
elseif($type=='priv'){
   error_screen(13);
}//elseif

}//function

function manage_tribe(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$trb_id=form_get("trb_id");

manage_tribe_test($m_id,$trb_id);

$pro=form_get("pro");
//basic manage of tribe
if(($pro=='')||($pro=='basic')){
global $main_url;
$sql_query="select * from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');

      show_header();
      ?>
           <table width=100% class='body'>
                <tr><td colspan=4 class='lined'>
                    <table width=100% class='body'>
                        <tr><td class='title'>Edit Group</td>
                        <td align=right><a href='index.php?mode=tribe&act=show&trb_id=<? echo $trb_id; ?>'>&lt;&lt; back</a></td>
                    </table>
                </td>
                <tr><td width=200 class='lined-top lined-left lined-right'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=basic'>Basic</a></td>
                <td width=200 class='lined'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=membership'>Membership</a></td>
                <td width=200 class='lined'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=photos'>Photos</a></td>
                <td width=200 class='lined'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=delete'>Delete</a></td>
                <tr><td colspan=4>

                      <table width=100% class='lined body'>
                      <form action='index.php' method=post>
                      <input type=hidden name='mode' value='tribe'>
                      <input type=hidden name='act' value='save'>
                      <input type=hidden name='trb_id' value='<? echo $trb_id; ?>'>
                      <input type=hidden name='pro' value='basic'>
                          <tr><td>Group Name</td><td><input type='text' name='name' value='<? echo $trb->name; ?>'></td>
                          <tr><td>Group Category</td><td><select name='t_cat_id'>
                          <? drop_t_cats("$trb->t_cat_id");?></select></td>
                          <tr><td>Group Description</td><td><textarea name='description' rows=5 cols=45><? echo $trb->description; ?></textarea></td>
                          <tr><td>Group Type</td><td><input type='radio' name='type' <? checked($trb->type,"pub"); ?> value='pub'>Public
                          &nbsp<input type='radio' name='type' <? checked($trb->type,"mod"); ?> value='mod'>Moderated
                          &nbsp<input type='radio' name='type' <? checked($trb->type,"priv"); ?> value='priv'>Private
                          </td>
                          <tr><td>Group URL</td><td><input type='text' name='url' value='<? echo "$trb->url"; ?>'></td>
                          <tr><td colspan=2 align=right><input type=button value='Cancel' onClick='window.location="index.php?mode=tribe&act=show&trb_id=<? echo $trb_id; ?>"'>
                          &nbsp<input type='submit' value='Submit'></td>
                          </form>
                      </table>

                </td>
           </table>
      <?
      show_footer();

}//basic
//membership manage
elseif($pro=='membership'){
$sql_query="select members from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
$members=split("\|",$trb->members);
$members=if_empty($members);
	  show_header();
      ?>
           <table width=100% class='body'>
                <tr><td colspan=4 class='lined'>
                    <table width=100% class='body'>
                        <tr><td class='title'>Edit Group</td>
                        <td align=right><a href='index.php?mode=tribe&act=show&trb_id=<? echo $trb_id; ?>'>&lt;&lt; back</a></td>
                    </table>
                </td>
                <tr><td width=200 class='lined-top lined-left lined-right'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=basic'>Basic</a></td>
                <td width=200 class='lined'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=membership'>Membership</a></td>
                <td width=200 class='lined'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=photos'>Photos</a></td>
                <td width=200 class='lined'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=delete'>Delete</a></td>
                <tr><td colspan=4>

                      <table width=100% class='lined body'>
<?
if($members==''){
  echo "<tr><td align=center>No members.</td>";
}//if
else {

     ?>
                      <form action='index.php' method=post>
                      <input type=hidden name='mode' value='tribe'>
                      <input type=hidden name='act' value='save'>
                      <input type=hidden name='trb_id' value='<? echo $trb_id; ?>'>
                      <input type=hidden name='pro' value='membership'>
                      <tr><td><table align=center class='body'><tr>
                          <?
                          $i=1;
                          foreach($members as $mem_id){
                     if($i%6){echo "<tr>";}
                     echo "<td>
                     <table class='table-photo'>
                     <tr><td vasilek align=center>";
                     show_photo($mem_id);
                     echo "</td>
                     <tr><td align=center>";
                     show_online($mem_id);
                     echo "</td>
                     <tr><td align=center><input type=checkbox name='mem_id[]' value='$mem_id'></td>
                     </table>
                     </td>";
                     $i++;
                          }//foreach
                          ?>
                      </table></td>
                          <tr><td align=right><input type=button value='Cancel' onClick='window.location="index.php?mode=tribe&act=show&trb_id=<? echo $trb_id; ?>"'>
                          &nbsp<input type='submit' value='Delete Members'></td>
                          </form>

<?
}//else
?>
               </table>

                </td>
           </table>
      <?
      show_footer();

}//membership
//photos manage
elseif($pro=='photos'){
$sql_query="select name from tribes where trb_id='$trb_id'";
$name=sql_execute($sql_query,'get');

              show_header();
              ?>
			  <table class="body" width=100%>
              <tr><td class='lined'>
                    <table width=100% class='body'>
                        <tr><td class='title'>Edit Group: Photo Album</td>
                        <td align=right><a href='index.php?mode=tribe&act=show&trb_id=<? echo $trb_id; ?>'>&lt;&lt; back</a></td>
                    </table>
                </td>
              <tr><td class="lined"><table align=center>
              <? tribe_photo_album($trb_id,"1"); ?>
              </table></td>
              <tr><td class="lined title">Upload a Photo <span class="maingray">Upload your images in .JPG or .GIF format. The size limit per photo is 500K.</span>
              <tr><td class="lined">
              <form action="index.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="mode" value="tribe">
              <input type="hidden" name="act" value="upload">
              <input type="hidden" name="trb_id" value="<? echo $trb_id; ?>">
              <table class="body" width=100% align=center>
              <tr><td align=right>Photo</td><td><input type="file" name="photo"></td>
              <tr><td align=right>Caption</td><td><input type="text" name="capture"></td>
              <tr><td></td><td><input type="checkbox" name="main" value="1">Set As Main Photo</td>
              <tr><td colspan=2>&nbsp</td>
              <tr><td colspan=2 align=right><input type="submit" value="Upload Photo"></td>
              </table>
              <?
              show_footer();

}//photos
elseif($pro=='delete'){
show_header();
      ?>
           <table width=100% class='body'>
                <tr><td colspan=4 class='lined'>
                    <table width=100% class='body'>
                        <tr><td class='title'>Edit Group: Delete</td>
                        <td align=right><a href='index.php?mode=tribe&act=show&trb_id=<? echo $trb_id; ?>'>&lt;&lt; back</a></td>
                    </table>
                </td>
                <tr><td width=200 class='lined'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=basic'>Basic</a></td>
                <td width=200 class='lined'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=membership'>Membership</a></td>
                <td width=200 class='lined'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=photos'>Photos</a></td>
                <td width=200 class='lined-top lined-left lined-right'><a href='index.php?mode=tribe&act=manage&trb_id=<? echo $trb_id; ?>&pro=delete'>Delete</a></td>
                <tr><td colspan=4>

                      <table width=100% class='lined body'>
                      <form action='index.php' method=post>
                      <input type=hidden name='mode' value='tribe'>
                      <input type=hidden name='act' value='save'>
                      <input type=hidden name='trb_id' value='<? echo $trb_id; ?>'>
                      <input type=hidden name='pro' value='delete'>
                      <tr><td align=center class='padded-6'>
                      By Pushing Button "Delete" you are going to delete this group with
                      all members, events, discussion board and group listings.</br>
                      </br>
                      <input type='submit' value='Delete Group'>
                      </td>
                          </form>
                      </table>

                </td>
           </table>
      <?
      show_footer();
}//delete

}//function

//function checks if user is creator of a tribe
function manage_tribe_test($mem_id,$trb_id){
$sql_query="select mem_id from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');

if($trb->mem_id!=$mem_id){
   error_screen(14);
}//if

}//function

//save changes to tribe (when managing)
function save(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$trb_id=form_get("trb_id");

manage_tribe_test($m_id,$trb_id);

$pro=form_get("pro");

if($pro=='basic'){
$name=form_get("name");
$t_cat_id=form_get("t_cat_id");
$description=form_get("description");
$type=form_get("type");
$url=form_get("url");

$sql_query="select trb_id from tribes where url='$url' and trb_id!='$trb_id'";
$num=sql_execute($sql_query,'num');
if($num>0){
  error_screen(22);
}

$sql_query="select url from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');

if($trb->url!=$url){
global $base_path,$tribes_folder;
$sql_query="select url from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
$f=fopen("$base_path/$tribes_folder/$trb->url/index.php","r");
$content=fread($f,filesize("$base_path/$tribes_folder/$trb->url/index.php"));
fclose($f);
mkdir("$base_path/$tribes_folder/$url",0777);
$f=fopen("$base_path/$tribes_folder/$url/index.php","w");
fwrite($f,$content);
fclose($f);
unlink("$base_path/$tribes_folder/$trb->url/index.php");
rmdir("$base_path/$tribes_folder/$trb->url");
}//if

$sql_query="update tribes set name='$name',t_cat_id='$t_cat_id',description='$description',type='$type',url='$url' where trb_id='$trb_id'";
sql_execute($sql_query,'');

manage_tribe();
}//basic
elseif($pro=='membership'){
$mem_id=form_get("mem_id");

$sql_query="select members from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
$members=split("\|",$trb->members);
$members=if_empty($members);

$newmem=array();

foreach($mem_id as $mid){
   $newmem=array_unset($members,$mid);
   $sql_query="select tribes from members where mem_id='$mid'";
   $mem=sql_execute($sql_query,'get');
   $tribes=split("\|",$mem->tribes);
   $tribes=if_empty($tribes);
   $tribes=array_unset($tribes,$trb_id);
   $line='';
   foreach($tribes as $tribe){
     if($tribe!=$trb_id){
     $line.="|$tribe";
     }//if
   }//foreach
   $sql_query="update members set tribes='$line' where mem_id='$mid'";
   sql_execute($sql_query,'');
}//foreach

$line2='';
foreach($newmem as $n_mem){
   $line2.="|$n_mem";
}
$sql_query="update tribes set members='$line2',mem_num=mem_num-1 where trb_id='$trb_id'";
sql_execute($sql_query,'');
manage_tribe();
}//membership
elseif($pro=='delete'){
global $base_path,$tribes_folder;
$tid=$trb_id;
   $sql_query="select url from tribes where trb_id='$tid'";
   $trb=sql_execute($sql_query,'get');
   $folder=$base_path."/$tribes_folder/".$trb->url;
   unlink("$folder/index.php");
   rmdir("$folder");
   $sql_query="select members from tribes where trb_id='$tid'";
   $trb=sql_execute($sql_query,'get');
   $members=split("\|",$trb->members);
   $members=if_empty($members);
   if($members!=''){
     foreach($members as $mid){
          $sql_query="select tribes from members where mem_id='$mid'";
          $mem=sql_execute($sql_query,'get');
          $tribes=split("\|",$mem->tribes);
          $tribes=if_empty($tribes);
          $line='';
          foreach($tribes as $tr){
             if($tr!=$tid){
              $line.="|$tr";
             }
          }//foreach
          $sql_query="update members set tribes='$line' where mem_id='$mid'";
          sql_execute($sql_query,'');
     }//foreach
   }//if
   $sql_query="delete from tribes where trb_id='$tid;'";
   sql_execute($sql_query,'');
   $sql_query="delete from board where trb_id='$tid;'";
   sql_execute($sql_query,'');
   $sql_query="delete from replies where trb_id='$tid;'";
   sql_execute($sql_query,'');
   $sql_query="delete from events where trb_id='$tid;'";
   sql_execute($sql_query,'');
   complete_screen(6);
}//delete

}//function

//uploading photo
function upload_photo(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$trb_id=form_get('trb_id');
global $_FILES,$base_path,$main_url;

$tmpfname=$_FILES['photo']['tmp_name'];
$ftype=$_FILES['photo']['type'];
$fsize=$_FILES['photo']['size'];
$capture=form_get('capture');
$main=form_get('main');
if($main==''){
 $main=0;
}

//checkin filesize
if($fsize>500*1024){
 error_screen(10);
}

//checkin file type
if(($ftype=='image/jpeg')||($ftype=='image/pjpeg')){
  $p_type=".jpeg";
}
elseif($ftype=='image/gif'){
  $p_type=".gif";
}
else {
  error_screen(9);
}

$rand=rand(0,10000);
$newname=md5($m_id.time().$rand);
$newname_th=$newname."th";
$newname_b_th=$newname."bth";
$old=$base_path."/photos/".$newname.$p_type;
$thumb1=$base_path."/photos/".$newname_th.".jpeg";
$thumb2=$base_path."/photos/".$newname_b_th.".jpeg";

move_uploaded_file($tmpfname,$base_path."/photos/".$newname.$p_type);

    //creating thumbnails
    if($p_type==".jpeg"){
    $srcImage = ImageCreateFromJPEG( $old );
    }//elseif
    elseif($p_type==".gif"){
    $srcImage = ImageCreateFromGIF( $old );
    }//elseif

	$sizee=getimagesize($old);
	$srcwidth=$sizee[0];
	$srcheight=$sizee[1];


    //landscape
    if($srcwidth>$srcheight){
    $destwidth1=65;
    $rat=$destwidth1/$srcwidth;
    $destheight1=(int)($srcheight*$rat);
    $destwidth2=150;
    $rat2=$destwidth2/$srcwidth;
    $destheight2=(int)($srcheight*$rat2);
    }
    //portrait
    elseif($srcwidth<$srcheight){
    $destheight1=65;
    $rat=$destheight1/$srcheight;
    $destwidth1=(int)($srcwidth*$rat);
    $destheight2=150;
    $rat=$destheight2/$srcheight;
    $destwidth2=(int)($srcwidth*$rat);
    }
    //quadro
    elseif($srcwidth==$srcheight){
    $destwidth1=65;
    $destheight1=65;
    $destwidth2=150;
    $destheight2=150;
    }

	$destImage1 = ImageCreateTrueColor( $destwidth1, $destheight1);
    $destImage2 = ImageCreateTrueColor( $destwidth2, $destheight2);
	ImageCopyResized( $destImage1, $srcImage, 0, 0, 0, 0, $destwidth1, $destheight1, $srcwidth, $srcheight );
    ImageCopyResized( $destImage2, $srcImage, 0, 0, 0, 0, $destwidth2, $destheight2, $srcwidth, $srcheight );
	ImageJpeg($destImage1, $thumb1, 80);
    ImageJpeg($destImage2, $thumb2, 80);
	ImageDestroy($srcImage);
	ImageDestroy($destImage1);
    ImageDestroy($destImage2);

//updating db
$now=time();
$photo="photos/".$newname.$p_type;
$photo_b_thumb="photos/".$newname_b_th.".jpeg";
$photo_thumb="photos/".$newname_th.".jpeg";
$sql_query="update tribe_photo set photo=concat(photo,'|$photo'),photo_b_thumb=concat(photo_b_thumb,'|$photo_b_thumb'),
photo_thumb=concat(photo_thumb,'|$photo_thumb'),capture=concat(capture,'|$capture') where trb_id='$trb_id'";
sql_execute($sql_query,'');

//if set as main - updating tribe db
if($main=='1'){
   $sql_query="update tribes set photo='$photo',photo_thumb='$photo_thumb',photo_b_thumb='$photo_b_thumb'
   where trb_id='$trb_id'";
   sql_execute($sql_query,'');
}

manage_tribe();
}//function

function unjoin_tribe(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$trb_id=form_get("trb_id");

$sql_query="select members from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
$members=split("\|",$trb->members);
$members=if_empty($members);

$newmem=array();

   $newmem=array_unset($members,$m_id);
   $sql_query="select tribes from members where mem_id='$m_id'";
   $mem=sql_execute($sql_query,'get');
   $tribes=split("\|",$mem->tribes);
   $tribes=if_empty($tribes);
   $tribes=array_unset($tribes,$trb_id);
   $line='';
   foreach($tribes as $tribe){
     if($tribe!=$trb_id){
     $line.="|$tribe";
     }//if
   }//foreach
   $sql_query="update members set tribes='$line' where mem_id='$m_id'";
   sql_execute($sql_query,'');

$line2='';
foreach($newmem as $n_mem){
   $line2.="|$n_mem";
}
$sql_query="update tribes set members='$line2',mem_num=mem_num-1 where trb_id='$trb_id'";
sql_execute($sql_query,'');
global $main_url;
$link=$main_url."/index.php?mode=tribe&act=show&trb_id=$trb_id";
show_screen($link);
}//function

?>