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
$pro=form_get("pro");
if($act=="profile"){
   if($pro=="edit"){
       edit_profile();
   }//if
}//if
elseif($act=="bmarks"){
  bookmarks_manager();
}//elseif
elseif($act=="del"){
  del_photo();
}//elseif
elseif($act=="inv"){
  invite_page();
}//elseif
elseif($act=='invite_tribe'){
  invite_to_tribe();
}
elseif($act=="ignore"){
  ignore();
}//elseif
elseif($act=="save"){
  save();
}
elseif($act=="chpass"){
  change_password();
}
elseif($act=="upload"){
  photo_upload();
}
elseif($act=='tst'){
  write_testimonial();
}
elseif($act=='friends'){
  friends_manager();
}
elseif($act=='listings'){
  view_listings();
}
elseif($act=='intro'){
  make_intro();
}
elseif($act=='inv_db'){
  $pro=form_get("pro");
  if($pro==''){
  sent_invitations();
  }
  else {
  del_inv();
  }
}
elseif($act='friends_view'){
  friends_view();
}

//delete invitation
function del_inv(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$inv_id=form_get("inv_id");
$sql_query="delete from invitations where inv_id='$inv_id'";
sql_execute($sql_query,'');
sent_invitations();
}//function

//edit profile
function edit_profile(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$m_acc=cookie_get("mem_acc");
   $type=form_get("type");
   if(($type=='')||($type=="basic")){
   show_header();
   ?>
      <table width=100%>
      <tr><td class="lined">
      <table width=100% class='body'>
      <tr><td class='title'>
      Edit Profile - Basic
      </td><td align=right><a href='index.php?mode=people_card&p_id=<? echo $m_id; ?>'>&lt;&lt; back</a></td>
      </table>
      <tr><td>&nbsp;</td>
      <tr><td>
          <table width=100% class='body'>
          <tr><td class="lined-top lined-right lined-left"><a href="javascript:formsubmit('basic')">Basics</a></td>
          <td class="lined"><a href="javascript:formsubmit('personal')">Personal</a></td>
          <td class="lined"><a href="javascript:formsubmit('professional')">Professional</a></td>
          <td class="lined"><a href="javascript:formsubmit('account')">Account</a></td>
          <td class="lined"><?php if($m_acc!=0) { ?><a href="javascript:formsubmit('photos')">Photos</a><?php } ?>&nbsp;</td>
          <tr><td colspan=5 class="lined">
              <table class="body">
              <tr><td colspan=3>Your personal profile should focus on the information you would share with friends and family.</td>
              <tr><td colspan=3 class"orangebody">Separate your entries with commas to allow others to find you based on what you write.</td>
              <form action="index.php" name="profile" method="post">
              <input type="hidden" name="mode" value="user">
              <input type="hidden" name="act" value="save">
              <input type="hidden" name="type" value="basic">
              <input type="hidden" name="redir" value="">
              <? show_profile_edit($m_id,"basic"); ?>
              <tr><td colspan=3 align=right><input type=button onClick="javascript:formsubmit('cancel')" value="Cancel">
              <input type=button value="Previous">
              <input type=button onClick="javascript:formsubmit('personal')" value="Next">
              <input type=button onClick="javascript:formsubmit('basic')" value="Save Changes">
              </td>
              </table>
          </td>
          </table>
      </td>
      </table>
   <?
   show_footer();
   }//if basic profile

   //personal profile
   elseif($type=='personal'){
   show_header();
   ?>
      <table width=100%>
      <tr><td class="lined">
      <table width=100% class='body'>
      <tr><td class='title'>
      Edit Profile - Personal
      </td><td align=right><a href='index.php?mode=people_card&p_id=<? echo $m_id; ?>'>&lt;&lt; back</a></td>
      </table>
      <tr><td>&nbsp;</td>
      <tr><td>
          <table width=100% class='body'>
          <tr><td class="lined"><a href="javascript:formsubmit('basic')">Basics</a></td>
          <td class="lined-top lined-right lined-left"><a href="javascript:formsubmit('personal')">Personal</a></td>
          <td class="lined"><a href="javascript:formsubmit('professional')">Professional</a></td>
          <td class="lined"><a href="javascript:formsubmit('account')">Account</a></td>
          <td class="lined"><?php if($m_acc!=0) { ?><a href="javascript:formsubmit('photos')">Photos</a><?php } ?>&nbsp;</td>
          <tr><td class="lined" colspan=5>
              <table class="body">
              <tr><td colspan=3>Your personal profile should focus on the information you would share with friends and family.</td>
              <tr><td colspan=3 class"orangebody">Separate your entries with commas to allow others to find you based on what you write.</td>
              <form action="index.php" method="post" name="profile">
              <input type="hidden" name="mode" value="user">
              <input type="hidden" name="act" value="save">
              <input type="hidden" name="type" value="personal">
              <input type="hidden" name="redir" value="">
              <? show_profile_edit($m_id,"personal"); ?>
              <tr><td colspan=3 align=right><input type=button onClick="javascript:formsubmit('cancel')" value="Cancel">
              <input type=button onClick="javascript:formsubmit('basic')" value="Previous">
              <input type=button onClick="javascript:formsubmit('professional')" value="Next">
              <input type=button onClick="javascript:formsubmit('personal')" value="Save Changes">
              </td>
              </table>
          </td>
          </table>
      </td>
      </table>
   <?
   show_footer();
   }//personal profile

   //professional
   elseif($type=="professional"){
   show_header();
   ?>
      <table width=100%>
      <tr><td class="lined">
      <table width=100% class='body'>
      <tr><td class='title'>
      Edit Profile - Professional
      </td><td align=right><a href='index.php?mode=people_card&p_id=<? echo $m_id; ?>'>&lt;&lt; back</a></td>
      </table>
      <tr><td>&nbsp;</td>
      <tr><td>
          <table width=100% class='body'>
          <tr><td class="lined"><a href="javascript:formsubmit('basic')">Basics</a></td>
          <td class="lined"><a href="javascript:formsubmit('personal')">Personal</a></td>
          <td class="lined-top lined-right lined-left"><a href="javascript:formsubmit('professional')">Professional</a></td>
          <td class="lined"><a href="javascript:formsubmit('account')">Account</a></td>
          <td class="lined"><?php if($m_acc!=0) { ?><a href="javascript:formsubmit('photos')">Photos</a><?php } ?>&nbsp;</td>
          <tr><td colspan=5 class="lined">
              <table class="body">
              <tr><td colspan=3>Your professional profile should focus on the information that you would share with colleagues in professional situations.</td>
              <form action="index.php" method="post" name="profile">
              <input type="hidden" name="mode" value="user">
              <input type="hidden" name="act" value="save">
              <input type="hidden" name="type" value="professional">
              <input type="hidden" name="redir" value="">
              <? show_profile_edit($m_id,"professional"); ?>
              <tr><td colspan=3 align=right><input type=button onClick="javascript:formsubmit('cancel')" value="Cancel">
              <input type=button onClick="javascript:formsubmit('personal')" value="Previous">
              <input type=button onClick="javascript:formsubmit('account')" value="Next">
              <input type=button onClick="javascript:formsubmit('professional')" value="Save Changes">
              </td>
              </table>
          </td>
          </table>
      </td>
      </table>
   <?
   show_footer();
   }//professional

   elseif($type=="photos"){
    $m_phot=cookie_get("mem_phot");
	$err_mess=form_get("err_mess");
	$row_chk=photo_album_count($m_id,"1","edi");
//	echo "Current Images : ".$row_chk;
//	echo "<br>Max image : ".$m_phot;
	$ned_ph=$m_phot-$row_chk;
	if($ned_ph<0)	$ned_ph=0;
	if($ned_ph==0)	$dia_img="disabled";
	show_header();
   ?>
      <table width=100%>
      <tr><td class="lined">
      <table width=100% class='body'>
      <tr><td class='title'>
      My Photo Album
      </td><td align=right><a href='index.php?mode=people_card&p_id=<? echo $m_id; ?>'>&lt;&lt; back</a></td>
      </table>
      <tr><td>&nbsp;</td>
      <tr><td>
          <table width=100% class='body'>
          <tr><td class="lined"><a href="javascript:formsubmit('basic')">Basics</a></td>
          <td class="lined"><a href="javascript:formsubmit('personal')">Personal</a></td>
          <td class="lined"><a href="javascript:formsubmit('professional')">Professional</a></td>
          <td class="lined"><a href="javascript:formsubmit('account')">Account</a></td>
          <td class="lined-top lined-right lined-left"><?php if($m_acc!=0) { ?><a href="javascript:formsubmit('photos')">Photos</a><?php } ?>&nbsp;</td>
          <tr><td colspan=5 class="lined">
              <table class="body" width=100%>
              <form action="index.php" method="post" name="profile">
              <input type="hidden" name="mode" value="user">
              <input type="hidden" name="act" value="save">
              <input type="hidden" name="type" value="photos">
              <input type="hidden" name="redir" value=""></form>
    		  <?php	if(!empty($err_mess))	{	?><tr><td align="center"><font color="#FF0000"><?=ucwords($err_mess)?></font></td></tr><?php	}	?>
              <tr><td class="lined title">My Photo Album</td>
              <tr><td class="lined"><table align=center class="body">
              <? photo_album($m_id,"1","edi"); ?>
              </table></td>
              <tr><td class="lined title">Upload a Photo <span class="maingray">Upload your images in .JPG or .GIF. The size limit per photo is 500K. <?php if($ned_ph==0) { ?>Your maximum limit reached.<?php } else { ?>You can upload <?=$ned_ph?> more photo(s).<?php } ?></span>
              <tr><td class="lined">
              <form action="index.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="mode" value="user">
              <input type="hidden" name="act" value="upload">
			  <input type="hidden" name="m_phot" value="<?=$m_phot?>">
              <table class="body" width=100% align=center>
              <tr><td align=right>Photo</td><td><input type="file" name="photo"></td>
              <tr><td align=right>Caption</td><td><input type="text" name="capture"></td>
              <tr><td></td><td><input type="checkbox" name="main" value="1">Set As Main Photo</td>
              <tr><td colspan=2>&nbsp;</td>
              <tr><td colspan=2 align=right><input type="submit" value="Upload Photo" <?=$dia_img?>></td>
              <tr><td colspan=2 align=right><input type=button onClick="javascript:formsubmit('cancel')" value="Cancel">
              <input type=button onClick="javascript:formsubmit('account')" value="Previous">
              <input type=button value="Next">
              <input type=button value="Save Changes">
              </td>
              </table>
              </td>
              </td>
              </table>
          </td>
          </table>
      </td>
      </table>
   <?
   show_footer();
   }//photos

   //account
   elseif($type="account"){
   show_header();
   ?>
      <table width=100%>
      <tr><td class="lined">
      <table width=100% class='body'>
      <tr><td class='title'>
      Edit Profile - Account
      </td><td align=right><a href='index.php?mode=people_card&p_id=<? echo $m_id; ?>'>&lt;&lt; back</a></td>
      </table>
      <tr><td>&nbsp;</td>
      <tr><td>
          <table width=100% class='body'>
          <tr><td class="lined"><a href="javascript:formsubmit('basic')">Basics</a></td>
          <td class="lined"><a href="javascript:formsubmit('personal')">Personal</a></td>
          <td class="lined"><a href="javascript:formsubmit('professional')">Professional</a></td>
          <td class="lined-top lined-right lined-left"><a href="javascript:formsubmit('account')">Account</a></td>
          <td class="lined"><?php if($m_acc!=0) { ?><a href="javascript:formsubmit('photos')">Photos</a><?php } ?>&nbsp;</td>
          <tr><td colspan=5 class="lined">
              <table class="body">
              <form action="index.php" method="post" name="profile">
              <input type="hidden" name="mode" value="user">
              <input type="hidden" name="act" value="save">
              <input type="hidden" name="type" value="account">
              <input type="hidden" name="redir" value="">
              <? show_profile_edit($m_id,"account"); ?>
              <tr><td colspan=3 align=right><input type=button onClick="javascript:formsubmit('cancel')" value="Cancel">
              <input type=button onClick="javascript:formsubmit('professional')" value="Previous">
              <?php if($m_acc==0) { ?><input type=button value="Next"><?php } else { ?><input type=button onClick="javascript:formsubmit('photos')" value="Next"><?php } ?>
              <input type=button onClick="javascript:formsubmit('account')" value="Save Changes">
              </td>
              </table>
          </td>
          </table>
      </td>
      </table>
   <?
   show_footer();
   }//account

}

function save(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
global $main_url;

$now=time();
$sql_query="update profiles set updated='$now' where mem_id='$m_id'";
sql_execute($sql_query,'');

$red=array(

   "basic",
   "personal",
   "professional",
   "photos",
   "account"

);

    //getting type and redirect if cancel,next or previous
    $type=form_get("type");
    $redirect=form_get("redir");
    if($redirect=="cancel"){

          $location=$main_url."/index.php?mode=login&act=home";
          show_screen($location);

    }
    elseif($redirect=='next'){
          $location=$main_url."/index.php?mode=user&act=profile&pro=edit&type=";
          for($i=0;$i<count($red);$i++){
             if($type==$red[$i]){
                 $location.=$red[$i+1];
                 break;
             }//if
          }//for
          show_screen($location);
    }//elseif
    elseif($redirect=='prev'){
          $location=$main_url."/index.php?mode=user&act=profile&pro=edit&type=";
          for($i=0;$i<count($red);$i++){
             if($type==$red[$i]){
                 $location.=$red[$i-1];
                 break;
             }//if
          }//for
          show_screen($location);
    }//elseif

    //basic
    if($type=="basic"){

              //getting values
              $vals=array(
              	  "here_for"   ,
	              "gender"     ,
	              "showloc"    ,
	              "showage"    ,
	              "showgender" ,
	              "country"   ,
	              "zip"        ,
	              "interests"  ,
	              "month"      ,
	              "day"        ,
	              "year"       ,
	              "occupation" ,
	              "showonline"
                  );
              foreach($vals as $val){
                ${$val}=form_get("$val");
              }
              $birthday=maketime(0,0,0,$month,$day,$year);
              if($showloc==''){
                $showloc='1';
              }
              if($showage==''){
                $showage='1';
              }
              if($showgender==''){
                $showgender='1';
              }
              if($showonline==''){
                $showonline='1';
              }

              $sql_query="update members set birthday='$birthday'";
              foreach($vals as $val){
                 if(($val!="occupation")&&($val!='here_for')&&($val!='interests')&&
                 ($val!="month")&&($val!="day")&&($val!="year")){
                 $sql_query.=",$val='${$val}'";
                 }//if
              }//foreach
              $sql_query.=" where mem_id='$m_id'";
              sql_execute($sql_query,'');
              $sql_query="update profiles set occupation='$occupation',here_for='$here_for',interests='$interests' where mem_id='$m_id'";
              sql_execute($sql_query,'');
    }//basic

    //personal
    elseif($type=="personal"){

             //getting values
             $vals=array(
             "hometown"   ,
             "schools"    ,
             "languages"  ,
             "website"    ,
             "books"      ,
             "music"      ,
             "movies"     ,
             "travel"     ,
             "clubs"      ,
             "about"      ,
             "meet_people",
             );

             foreach($vals as $val){
                ${$val}=form_get("$val");
              }
			$sub_cat_id=form_get("sub_cat_id");
			if($sub_cat_id!=''){
				foreach($sub_cat_id as $sid){
					$ans.=$sid."|";
				}
			}
              $sql_query="update profiles set ";
              foreach($vals as $val){
                 $sql_query.="$val='${$val}',";
              }//foreach
              $sql_query=rtrim($sql_query,',');
              $sql_query.=",answers='$ans' where mem_id='$m_id'";
              sql_execute($sql_query,'');


    }//personal

    //professional
    elseif($type=="professional"){

              //getting vals
              $vals=array(
              "position"     ,
              "company"      ,
              "industry"     ,
              "specialities" ,
              "skills"       ,
              "overview"     ,
              "p_positions"  ,
              "p_companies"  ,
              "assotiations"
              );

              foreach($vals as $val){
                ${$val}=form_get("$val");
              }

              $sql_query="update profiles set ";
              foreach($vals as $val){
                 $sql_query.="$val='${$val}',";
              }//foreach
              $sql_query=rtrim($sql_query,',');
              $sql_query.=" where mem_id='$m_id'";
              sql_execute($sql_query,'');


    }//professional

    //account
    elseif($type=="account"){

               //getting vals
			   $pack=form_get("pack");
               $pack_old=form_get("pack_old");
               $email=form_get("email");
               $fname=form_get("fname");
               $lname=form_get("lname");
               $notifications=form_get("notifications");
               $password=form_get("password");
               if($notifications==''){
                  $notifications=0;
               }
			    $sql="select * from member_package where package_id=$pack";
				$res=mysql_query($sql);
				$row=mysql_fetch_object($res);
				$package_amt=$row->package_amt;

			   if(($pack==0) or ($package_amt=="0.00"))	$mem_st="F";
			   else	$mem_st="P";
               $sql_query="select * from members where mem_id='$m_id'";
               $mem=sql_execute($sql_query,'get');

               $sql_query="update members set fname='$fname',lname='$lname',notifications='$notifications',mem_acc='$pack',pay_stat='N'
               where mem_id='$m_id'";
               sql_execute($sql_query,'');

               if($email!=$mem->email){
                  $crypass=md5($password);
                  if($crypass!=$mem->password){
                    error_screen(0);
                  }//if
                  else {

                    $sql_query="update members set email='$email' where mem_id='$m_id'";
                    sql_execute($sql_query,'');
                    $data[0]=$email;
                    $data[1]=$password;
                    messages($email,"3",$data);

                  }//else


               }//if
			if($pack!=$pack_old)	{
				if(($pack!=0) and ($package_amt!='0.00'))	{
			  		global $main_url;
					$redirect=$main_url."/index.php?mode=update_paypal&pack=$pack&mem_id=$m_id";
					show_screen($redirect);
				}
			}
    }//account

    //photos
    elseif($type=="photos"){

    }//photos

    						////redirecting////
                            $location=$main_url."/index.php?mode=user&act=profile&pro=edit&type=";
                            if($redirect==''){
                               $location.=$type;
                            }//if
                            else {
                               $location.=$redirect;
                            }//else

                            show_screen($location);

}//function

function show_profile_edit($mem_id,$type){
    $sql_query="select * from profiles where mem_id='$mem_id'";
    $pro=sql_execute($sql_query,'get');
    $sql_query="select * from members where mem_id='$mem_id'";
    $mem=sql_execute($sql_query,'get');

				//basic profile
                if($type=="basic"){
					$sql_accc="select * from member_package order by package_amt";
					$res_accc=mysql_query($sql_accc);
                      $here_for=$pro->here_for;
                      $gender=$mem->gender;
                      $showloc=$mem->showloc;
                      $showage=$mem->showage;
                      $showgender=$mem->showgender;
                      $location=$mem->country;
                      $zip=$mem->zip;
                      $interests=$pro->interests;
                      $birthday=$mem->birthday;
                      $month=date("m",$birthday);
                      $day=date("j",$birthday);
                      $year=date("Y",$birthday);
                      $occupation=$pro->occupation;
                      $showonline=$mem->showonline;
                      $country=$mem->country;
					  $acc=$mem->mem_acc;
					  
                      echo "<tr><td>Occupation</td><td><input type='text' name='occupation' value='$occupation'></td><td></td>";
                      echo "<tr><td>Country</td><td><select name='country'>
                      <option selected value='$country'>$country";
                      country_drop();
                      echo "</select></td><td class='lined form_tip'><input type='checkbox' name='showonline' value='0'";
                      checked($showonline,"0");
                      echo ">Don't show my online status</td>";
                      echo "<tr><td>Zip</td><td><input type='text' name='zip' value='$zip'></td><td class='lined form_tip'>
                      <input type='checkbox' name='showloc' value='0'";
                      checked($showloc,"0");
                      echo ">Don't show my location</td>";
                      echo "<tr><td>Gender</td><td>
                      <input type='radio' name='gender'";checked($gender,"m"); echo "value='m'>Male
                      <input type='radio' name='gender'";checked($gender,"f"); echo "value='f'>Female</br>
                      <input type='radio' name='gender'";checked($gender,"n"); echo "value='n'>I'd prefer not to say
                      </td><td class='lined form_tip'>
                      <input type='checkbox' name='showgender' value='0'";
                      checked($showgender,"0");
                      echo ">Don't show my gender</td>";
                      echo "<tr><td>Birthday</td><td>";
                      ?>
                      <select name='month'>
                      <? month_drop("$month"); ?>
                      </select>
                      <select name='day'>
                      <? day_drop("$day"); ?>
                      </select>
                      <select name='year'>
                      <? year_drop("$year"); ?>
                      </select>
                      <?
                      echo "</td><td class='lined form_tip'>
                      <input type='checkbox' name='showage' value='0'";
                      checked($showgender,"0");
                      echo ">Don't show my age</td>";
                      echo "<tr><td>Here For</br><span class='orangebody'>what are you looking for?</span></td><td colspan=2><input type='text' name='here_for' value='$here_for'></td>";
                      echo "<tr><td>Interests</br><span class='orangebody'>separate with commas</span></td><td colspan=2><textarea name='interests' cols=40 rows=5>$interests</textarea></td>";

                }//basic

                //personal
                elseif($type=="personal"){
                      $hometown=$pro->hometown;
                      $schools=$pro->schools;
                      $languages=$pro->languages;
                      $website=$pro->website;
                      $books=$pro->books;
                      $music=$pro->music;
                      $movies=$pro->movies;
                      $travel=$pro->travel;
                      $clubs=$pro->clubs;
                      $about=$pro->about;
                      $meet_people=$pro->meet_people;
					  $answers=split("\|",$pro->answers);

					$sql_query="select * from questions";
					$res_que=mysql_query($sql_query);
                      echo "<tr><td>Hometown</td><td colspan=2><input type='text' name='hometown' value='$hometown'></td>";
                      echo "<tr><td>Schools</td><td colspan=2><input type='text' name='schools' value='$schools'></td>";
                      echo "<tr><td>Languages</td><td colspan=2><input type='text' name='languages' value='$languages'></td>";
                      echo "<tr><td>Personal Website</td><td colspan=2><input type='text' name='website' value='$website'></td>";
                      echo "<tr><td>Favorite Books</td><td colspan=2><input type='text' name='books' value='$books'></td>";
                      echo "<tr><td>Favorite Music</td><td colspan=2><input type='text' name='music' value='$music'></td>";
                      echo "<tr><td>Favorite Movies/TV</td><td colspan=2><input type='text' name='movies' value='$movies'></td>";
                      echo "<tr><td>I've traveled to</td><td colspan=2><input type='text' name='travel' value='$travel'></td>";
                      echo "<tr><td>Clubs & Organizations</td><td colspan=2><input type='text' name='clubs' value='$clubs'></td>";
                      echo "<tr><td>About me</td><td colspan=2><textarea name='about'>$about</textarea></td>";
                      echo "<tr><td>I want to meet people for</td><td colspan=2><textarea name='meet_people'>$meet_people</textarea></td>";
					while($que=mysql_fetch_object($res_que))	{
						echo "<tr><td>".$que->q_que."</td>";
						echo "<td colspan=2>";
						$sql_query="select * from answers where a_qid=$que->q_id";
						$res_ans=mysql_query($sql_query);
						while($ans=mysql_fetch_object($res_ans))	{
							for($i=0; $i<count($answers)-1; $i++)	{
								if($ans->a_id==$answers[$i]){
									$chk="checked";
									break;
									}
								else	$chk="";
							}
							echo "<input type=checkbox name='sub_cat_id[]' value='$ans->a_id' $chk>$ans->a_ans<br>";
						}
						echo "</td></tr>";
					}
                }//personal

                //professional
                elseif($type=="professional"){
                      $position=$pro->position;
                      $company=$pro->company;
                      $industry=$pro->industry;
                      $specialities=$pro->specialities;
                      $skills=$pro->skills;
                      $overview=$pro->overview;
                      $p_positions=$pro->p_positions;
                      $p_companies=$pro->p_companies;
                      $assotiations=$pro->assotiations;

                      echo "<tr><td>Position/Title</td><td colspan=2><input type='text' name='position' value='$position'></td>";
                      echo "<tr><td>Company</td><td colspan=2><input type='text' name='company' value='$company'></td>";
                      echo "<tr><td>Industry</td><td colspan=2><select name='industry'>
                    <option value='' >Please select ...</option>";
                    industry_drop("$industry");
                    echo "</select>
                      </td>";
                      echo "<tr><td>Specialities in Industries</br><span class='orangebody'>separate with commas</span></td><td colspan=2><textarea name='specialities'>$specialities</textarea></td>";
                      echo "<tr><td>Skills</br><span class='orangebody'>separate with commas</span></td><td colspan=2><textarea name='skills'>$skills</textarea></td>";
                      echo "<tr><td>Overview</td><td colspan=2><textarea name='overview'>$overview</textarea></td>";
                      echo "<tr><td>Past Positions</br><span class='orangebody'>separate with commas</span></td><td colspan=2><input type='text' name='p_positions' value='$p_positions'></td>";
                      echo "<tr><td>Past Companies</br><span class='orangebody'>separate with commas</span></td><td colspan=2><input type='text' name='p_companies' value='$p_companies'></td>";
                      echo "<tr><td>Assotiations</br><span class='orangebody'>separate with commas</span></td><td colspan=2><input type='text' name='assotiations' value='$assotiations'></td>";

                }//professional

                //account
                elseif($type=="account"){
                      $email=$mem->email;
                      $fname=$mem->fname;
                      $lname=$mem->lname;
					  $acc=$mem->mem_acc;
                      $notifications=$mem->notifications;
					  $sql_accc="select * from member_package order by package_amt";
					  $res_accc=mysql_query($sql_accc);
                      echo "<tr><td>E-mail</br><span class='orangebody'>this is your login</span></td>
                      <td><input type=text name='email' value='$email'>
                      </br><span class='orangebody'>enter new e-mail</span></td>
                      <td><input type=password name='password'>
                      </br><span class='orangebody'>password required to change e-mail</span></td>";
                      echo "<tr><td>First Name</td><td colspan=2><input type=text name='fname' value='$fname'></td>";
                      echo "<tr><td>Last Name</td><td colspan=2><input type=text name='lname' value='$lname'></td>";
                      echo "<tr><td>Password</td><td colspan=2><a href='index.php?mode=user&act=chpass'>change password</a></td>";
					  echo "<tr><td colspan=2>&nbsp;</td></tr>";
					                        echo "<tr><td valign='top'>Membership</td><td valign='top'>";
                      ?>
					  <?php
						$sql="select * from member_package where package_id=".$acc;
						$res=mysql_query($sql);
						$row=mysql_fetch_object($res);
						$package_amt=$row->package_amt;
						$sql_max="select max(package_amt) as amt_max from member_package";
						$res_max=mysql_query($sql_max);
						$row_max=mysql_fetch_object($res_max);
						if($row_max->amt_max==$package_amt)	{
							echo $row->package_nam."<input name='pack' type='hidden' value='$acc'>";
						}	else	{
							if(mysql_num_rows($res_accc)) {
								$ssco=0;
								while($row_accc=mysql_fetch_object($res_accc)) {
									if($package_amt<=$row_accc->package_amt)	{
										if($ssco==0)	{
											$dis="<input type='radio' name='pack' value='$row_accc->package_id' checked>&nbsp;".$row_accc->package_nam."&nbsp;&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
											$ssco=1;
										}	else	{
											$dis="<input type='radio' name='pack' value='$row_accc->package_id'>&nbsp;".$row_accc->package_nam."&nbsp;&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
											$ssco=1;
										}
									}
//									else	{
//										if($acc==$row_accc->package_id)	$dis="<input type='radio' name='pack' value='$row_accc->package_id' checked>&nbsp;".$row_accc->package_nam."&nbsp;&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
//										else	$dis="<input type='radio' name='pack' value='$row_accc->package_id'>&nbsp;".$row_accc->package_nam."&nbsp;&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
//									}
						?>
						<?=$dis?><br>
						<?php
									$dis="";
								}
							}
						}
						?>
                      <?
                      echo "</td><td>";
                      echo "<input name='pack_old' type='hidden' value='$acc'>";
					  echo "<tr><td colspan=2>&nbsp;</td></tr>";
                      echo "<tr><td>E-mail Notifications</td><td colspan=2><input type=checkbox name='notifications'";
                      checked($notifications,"1");echo "value='1'>Send me e-mail notifications about invitations,
                      friend requests and messages in my Inbox.</td>";
                }

}//function

function change_password(){
global $cookie_url;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$pro=form_get("pro");
if($pro==''){
     show_header();
     ?>
      <table width=100%>
      <tr><td class="lined">
      <table width=100% class='body'>
      <tr><td class='title'>
      Edit Profile - Account
      </td><td align=right><a href='index.php?mode=people_card&p_id=<? echo $m_id; ?>'>&lt;&lt; back</a></td>
      </table>
      <tr><td>&nbsp;</td>
      <tr><td>
          <table width=100% class='body'>
          <tr><td class="lined"><a href="javascript:formsubmit('basic')">Basics</a></td>
          <td class="lined"><a href="javascript:formsubmit('personal')">Personal</a></td>
          <td class="lined"><a href="javascript:formsubmit('professional')">Professional</a></td>
          <td class="lined"><a href="javascript:formsubmit('photos')">Photos</a></td>
          <td class="lined-top lined-right lined-left"><a href="javascript:formsubmit('account')">Account</a></td>
          <tr><td colspan=5 class="lined">
              <table class="body" width=100%>
              <form action="index.php" method="post" name="profile">
              <input type="hidden" name="mode" value="user">
              <input type="hidden" name="act" value="chpass">
              <input type="hidden" name="pro" value="done">
              <input type="hidden" name="type" value="account">
              <input type="hidden" name="redir" value="">
              <tr><td>Old Password</td><td colspan=2><input type="password" name="oldpass"></td>
              <tr><td>New Password</td><td colspan=2><input type="password" name="newpass"></td>
              <tr><td>Confirm New Password</td><td colspan=2><input type="password" name="newpass2"></td>
              <tr><td colspan=3 align=right><input type=button onClick="javascript:formsubmit('cancel')" value="Cancel">
              <input type=button onClick="javascript:formsubmit('prev')" value="Previous">
              <input type=button value="Next">
              <input type=button onClick="javascript:formsubmit('account')" value="Save Changes">
              </td>
              </table>
          </td>
          </table>
      </td>
      </table>
   <?
   show_footer();
}
elseif($pro=='done'){
//getting values
   $oldpass=form_get("oldpass");
   $newpass=form_get("newpass");
   $newpass2=form_get("newpass");
   $type=form_get("type");
   $redirect=form_get("redir");

   //if password and confirm are not equal
   if($newpass!=$newpass2){
      error_screen(2);
   }
   //crypting old password and checkin
   $crypass=md5($oldpass);
   $sql_query="select password,email from members where mem_id='$m_id'";
   $mem=sql_execute($sql_query,'get');
   if($mem->password!=$crypass){
       error_screen(0);
   }
   //crypting new pass and updating db
   $newcrypass=md5($newpass);
   $sql_query="update members set password='$newcrypass' where mem_id='$m_id'";
   sql_execute($sql_query,'');

   //sending user new login info
   $data[0]=$mem->email;
   $data[1]=$newpass;
   messages($mem->email,"3",$data);


                            ////redirecting////
                            $time=time()+3600*24;
                            SetCookie("mem_id",$m_id,$time,"/",$cookie_url);
                            SetCookie("mem_pass",$newcrypass,$time,"/",$cookie_url);
                            $location=$main_url."/index.php?mode=user&act=profile&pro=edit&type=";
                            if($redirect==''){
                               $location.=$type;
                            }//if
                            else {
                               $location.=$redirect;
                            }//else

                            show_screen($location);

}

}//function

function photo_upload(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
$m_phot=cookie_get("mem_phot");
login_test($m_id,$m_pass);
global $_FILES,$base_path,$main_url;

$tmpfname=$_FILES['photo']['tmp_name'];
$ftype=$_FILES['photo']['type'];
$fsize=$_FILES['photo']['size'];
$capture=form_get('capture');
$main=form_get('main');
if($main==''){
 $main=0;
}

//checkin image size
if($fsize>500*1024){
 error_screen(10);
}

//checkin image type
if(($ftype=='image/jpeg')||($ftype=='image/pjpeg')){
  $p_type=".jpeg";
}
elseif($ftype=='image/gif'){
  $p_type=".gif";
}
else {
  error_screen(9);
}
$row_chk=photo_album_count($m_id,"1","edi");
if($row_chk<$m_phot)	{
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
		if(empty($capture))	$capture=" ";
		$sql_query="update photo set photo=concat(photo,'|$photo'),photo_b_thumb=concat(photo_b_thumb,'|$photo_b_thumb'),
		photo_thumb=concat(photo_thumb,'|$photo_thumb'),capture=concat(capture,'|$capture') where mem_id='$m_id'";
		sql_execute($sql_query,'');
		
		if($main=='1'){
		   $sql_query="update members set photo='$photo',photo_thumb='$photo_thumb',photo_b_thumb='$photo_b_thumb'
		   where mem_id='$m_id'";
		   sql_execute($sql_query,'');
		}
}	else	$err_mess="You can upload only upto $m_phot photo(s).<br>Your maximum limit reached.";

//redirect
$location=$main_url."/index.php?mode=user&act=profile&pro=edit&type=photos&err_mess=$err_mess";
show_screen($location);
}//function

function bookmarks_manager(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$pro=form_get("pro");
//showing bookmarks
if($pro==''){
show_header();
?>
<table width=100% class="body">
<tr><td class="lined title">Bookmarks</td>
<tr><td class=lined align=center>
<?
     $sql_query="select * from bmarks where mem_id='$m_id'";
     $num=sql_execute($sql_query,'num');
     if($num==0){
       echo "There are no bookmarks.";
     }
     else {
       $res=sql_execute($sql_query,'res');
       while($bmr=mysql_fetch_object($res)){

              if($bmr->type=="member"){

                  echo "<table class='lined body'><tr><td align=center>";show_photo($bmr->sec_id);
                  echo "</br>";show_online($bmr->sec_id);echo"</td>
                  <tr><td class=lined align=center>
                  <a href='index.php?mode=user&act=bmarks&pro=del&bmr_id=$bmr->bmr_id'>Unbookmark</a>
                  </td>
                  </table>";

              }//if

              elseif($bmr->type=="listing"){

                  $sql_query="select title from listings where lst_id='$bmr->sec_id'";
                  $lst=sql_execute($sql_query,'get');

                  echo "<table class='lined body'><tr><td align=center>
                  <a href='index.php?mode=listing&act=show&lst_id=$bmr->sec_id'>$lst->title</a>
                  </td>
                  <tr><td class=lined align=center>
                  <a href='index.php?mode=user&act=bmarks&pro=del&bmr_id=$bmr->bmr_id'>Unbookmark</a>
                  </td>
                  </table>";

              }//elseif

              elseif($bmr->type=="tribe"){

                  $sql_query="select name from tribes where trb_id='$bmr->sec_id'";
                  $trb=sql_execute($sql_query,'get');

                  echo "<table class='lined body'><tr><td align=center>
                  <a href='index.php?mode=tribe&act=show&trb_id=$bmr->sec_id'>$trb->name</a>
                  </td>
                  <tr><td class=lined align=center>
                  <a href='index.php?mode=user&act=bmarks&pro=del&bmr_id=$bmr->bmr_id'>Unbookmark</a>
                  </td>
                  </table>";

              }//elseif

       }//while

     }//else
?>
</td>
<tr><td>
<table class="bodytip" cellpadding=0 cellspacing=0 width=100%>
<tr><td class="dark" align=center>Tip</td><td align=center class="td-shade">One of the easiest ways to track someone is by bookmarking them!</td></table>
</table>
<?
show_footer();
}//if
elseif($pro=='add'){
//adding bookmark and redirect to referer
global $HTTP_REFERER;
   $sec_id=form_get("sec_id");
   $type=form_get("type");

   $sql_query="select bmr_id from bmarks where mem_id='$m_id' and sec_id='$sec_id' and
   type='$type'";

   $num=sql_execute($sql_query,'num');

   if($num>0){
     error_screen(23);
   }

   $sql_query="insert into bmarks(mem_id,sec_id,type) values('$m_id','$sec_id','$type')";
   sql_execute($sql_query,'');

   $location=$HTTP_REFERER;
   show_screen($location);
}//elseif
elseif($pro=='del'){
//deleting bookmark and redirecting to referer
global $HTTP_REFERER;

   $bmr_id=form_get('bmr_id');
   $sql_query="delete from bmarks where bmr_id='$bmr_id'";
   sql_execute($sql_query,'');

   $location=$HTTP_REFERER;
   show_screen($location);

}//elseif

}//function

//send invitations outside the system
function invite_page(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$pro=form_get("pro");
if($pro==''){
show_header();
?>
<table width=100%>
<tr><td colspan=2 class="lined title">Invite More Friends to Join out site</td>
<tr><td colspan=2>&nbsp;</td>
<tr><td class="body padded-6" width=70%>
<p>Your Personal Network becomes more useful and fun each time a new person joins.</p>

<p>Use the form below to invite your Friends so you can:</p>

<li>Stay connected with people you know
<li>Tap into their knowledge and experience
<li>Create a larger audience for Listings you create
<li>Grow your personal Network of people you know and trust

</br></br>

<form action="index.php" method=post>
<input type="hidden" name="mode" value="user">
<input type="hidden" name="act" value="inv">
<input type="hidden" name="pro" value="done">

<span class='orangebody'>*required field</span>&nbsp;</br>
<table border="1" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" class="body padded-6">
  <tr>
    <td width="18%" align="left" valign="top" bgcolor="#CCCCCC">Friend's Emails <span class='orangebody'>*</span></td>
    <td width="82%">
    <p style="margin-top: 0; margin-bottom: 0"> <span class='orangebody'>separate multiple email addresses with commas</span></p>
    <p style="margin-top: 0; margin-bottom: 0">
<textarea rows=5 cols=40 name="emails"></textarea></td>
  </tr>
  <tr>
    <td width="18%" bgcolor="#CCCCCC">Subject</td>
    <td width="82%">
<input type=text size=25 name=subject value='Please join me at this site'></td>
  </tr>
  <tr>
    <td width="18%" bgcolor="#CCCCCC">Message</td>
    <td width="82%">
<textarea name=mes rows=5 cols=50>I hope you'll try out a new service I joined. You can connect with my friends, invite yours, post listings, and join
groups.  It's fun, it's easy, and it's addictive -- because it works. Let me know what you think.

To check it out, click the Web link below.  (If this link doesn't work, copy it into your browser.)
</textarea></td>
  </tr>
</table>
<p></br>
<input type="submit" value="Invite Friends">&nbsp<input type=button value='Cancel' onclick="window.location='index.php?mode=login&act=home'"></p>
</form>
</td>
<td class="body padded-6 lined" valign=top>
Looking for someone?</br></br>
Are your Friends already using our site?
Search for existing members by entering their name or email address here.</br></br>
<span class="orangebody">complete at least one field to search</span></br>
<table class=body>
<form action="index.php" method=post>
<input type=hidden name="mode" value="search">
<input type=hidden name="act" value="user">
<input type=hidden name="type" value="basic">
<tr><td>First Name</td><td><input type=text size=15 name="fname"></td>
<tr><td>Last Name</td><td><input type=text size=15 name="lname"></td>
<tr><td>E-mail</td><td><input type=text size=15 name="email"></td>
<tr><td colspan=2><input type=submit value="Search All Users"></td>
</table>
</td>
</table>
<?
show_footer();
}//if
else{
   global $main_url;
   //getting values
   $emails=form_get("emails");
   $subject=form_get("subject");
   $mes=form_get("mes");

   $emails=ereg_replace("\r","",$emails);
   $emails=ereg_replace("\n","",$emails);
   $emails=ereg_replace(" ","",$emails);

   $email=split(",",$emails);
   $email=if_empty($email);
   $data[0]=$subject;
   $now=time();
   if($email!=''){
   show_header();
   echo "<table width=100% class='body'>
   <tr><td class='lined title'>Invitation</td>
   <tr><td class='lined'>";
   foreach($email as $addr){
   //if user is site member - standart invitation
      $sql_query2="select mem_id from members where email='$addr'";
      $num=sql_execute($sql_query2,'num');
      if($num!=0){

      $fr=sql_execute($sql_query2,'get');
      $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$fr->mem_id'";
      $num2=sql_execute($sql_query,'num');
      $sql_query="select mes_id from messages_system where
      (mem_id='$m_id' and frm_id='$fr->mem_id' and type='friend') or
      (mem_id='$fr->mem_id' and frm_id='$m_id' and type='friend')";
      $num=sql_execute($sql_query,'num');

   if($m_id==$fr->mem_id){
     echo "$addr: you can't invite yourself!</br>";
   }//if
   elseif($num>0){
     echo "$addr - you already invited this user.</br>";
   }//elseif
   elseif($num2>0){
     echo "$addr - this user is already your friend.</br>";
   }//elseif
   else {

       $subj="Invitation to Join ".name_header($m_id,$fr->mem_id)."\'s Personal Network";
       $bod="After you push \"Confirm\" button user ".name_header($m_id,$fr->mem_id).
       " will be added to your friends network.";
       $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date)
        values('$fr->mem_id','$m_id','$subj','$bod','friend','inbox','$now')";
        sql_execute($sql_query,'');

        echo "$addr: Invitation is sent.</br>";
   }//else

       }//if a user
       else {
       //if user is not site member - just sending email
       $sql_query="insert into invitations (mem_id,email,date) values ('$m_id','$addr','$now')";
       sql_execute($sql_query,'');
       $sql_query="select max(inv_id) as maxid from invitations";
       $max=sql_execute($sql_query,'get');
       $data[1]=$mes."
       <a href='$main_url'>$main_url</a></br>
       <a href='$main_url/index.php?mode=join&inv_id=$max->maxid'>$main_url/index.php?mode=join&inv_id=$max->maxid</a>";
       $data[2]=name_header($m_id,"ad");
       $sql_query="select email from members where mem_id='$m_id'";
       $k=sql_execute($sql_query,'get');
       $data[3]=$k->email;
       messages($addr,"6",$data);
       echo "$addr: Invitation is sent.</br>";
       }//else
   }//foreach
   echo "</td></table>";
   }//if
   else {
      error_screen(3);
   }//else
}//else
}//function


function ignore(){
global $HTTP_REFERER;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

  $pro=form_get("pro");
  $mem_id=form_get("p_id");
  //adding to ignore list and redirect to referer
  if($pro=="add"){
      $sql_query="update members set ignore_list=concat(ignore_list,'|$mem_id') where mem_id='$m_id'";
      sql_execute($sql_query,'');
      $location=$HTTP_REFERER;
      show_screen($location);
  }//if
  elseif($pro=="del"){
  //deleting from ignore list and redirecting to referer
      $sql_query="select ignore_list from members where mem_id='$m_id'";
      $mem=sql_execute($sql_query,'get');
      $ignore=split("\|",$mem->ignore_list);
      $ignore=if_empty($ignore);
      $line="";
      if($ignore!=''){
      foreach($ignore as $ign){
          if($ign!=$mem_id){
           $line.="|".$ign;
          }
      }//foreach
      }//if
      else{
         $line='';
      }//else


      $sql_query="update members set ignore_list='$line' where mem_id='$m_id'";
      sql_execute($sql_query,'');
      $location=$HTTP_REFERER;
      show_screen($location);
  }//elseif
  //showign ignore list
  elseif($pro==''){
      show_header();
      echo "<table width=100% class=body>
      <tr><td class='lined title'>My Ignore List -- you will not receive messages from these members or see their Listings on your Home page:</td>
      <tr><td class=lined align=center>";
      $sql_query="select ignore_list from members where mem_id='$m_id'";
      $mem=sql_execute($sql_query,'get');
      $ignore=split("\|",$mem->ignore_list);
      $ignore=if_empty($ignore);
      if($ignore!=''){
      foreach($ignore as $ign){

         echo "<table class=lined>
         <tr><td vasilek class=lined>";show_photo($ign);echo "</br>";
         show_online($ign);
         echo "</td></table>
         <a href='index.php?mode=user&act=ignore&pro=del&p_id=$ign'>Remove</a>";

      }//foreach
      }//if
      else {
      echo "<p align=center>Ignore List is Empty.</p>";
      }//else
      echo "
      </td><tr><td>
      <table class='bodytip' cellpadding=0 cellspacing=0 width=100%>
      <tr><td class='dark' align=center>Tip</td><td align=center class='td-shade'>If you ignore someone, you can still see their listings and profile.</td></table>
      </td></table>";
      show_footer();

  }//elseif

}//function


function write_testimonial(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$pro=form_get("pro");
$p_id=form_get("p_id");
if($pro==''){
show_header();
?>
  <table width=100% class='body'>
      <tr><td class="lined title" colspan=2>Write a Testimonial</td>
      <tr><td class="lined" colspan=2>
		<p>How do you feel about <? echo name_header($p_id,$m_id); ?>?</p>
		<p>Use the space below to tell other members what you think of this person.
		Remember, your testimonial says as much about you as the person you're writing it for.</p>
		<p>After <? echo name_header($p_id,$m_id); ?> approves your testimonial, it'll be visible to anyone who sees <? echo name_header($p_id,$m_id); ?>'s Home page.</p>
		</br>
               <table class='body lined' cellspacing=0 cellpadding=0 align=center>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($p_id); ?></br>
               <? show_online($p_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$p_id); ?></td>
               <tr><td class='padded-6'>Network: <? echo count_network($p_id,"1","num"); ?> friends in a
               network of <? echo count_network($p_id,"all","num"); ?>
               </td>
               </table>&nbsp</td>
            <tr><td colspan=2 class="title lined">Your Testimonial</td>
            <tr><td colspan=2 align=center class=lined>
            <form action="index.php">
            <input type="hidden" name="mode" value="user">
            <input type="hidden" name="act" value="tst">
            <input type="hidden" name="pro" value="done">
            <input type="hidden" name="p_id" value="<? echo $p_id; ?>">
            <textarea name=text rows=5 cols=45></textarea>
            <p align=right><input type="submit" value="Send"></p></form>
            </td>
        </table>
      </td>
  </table>
<?
show_footer();
}//if
elseif($pro=='done'){
global $main_url;
   $refer=form_get("refer");
   $text=form_get("text");
   $now=time();
   //updating db
   $sql_query="insert into testimonials (mem_id,from_id,testimonial,added)
   values('$p_id','$m_id','$text','$now')";
   sql_execute($sql_query,'');

   //sending user a message
   $data[0]=name_header($m_id,'');
   $sql_query="select email from members where mem_id='$p_id'";
   $per=sql_execute($sql_query,'get');
   messages($per->email,"4",$data);

   $location=$main_url."/index.php?mode=people_card&p_id=$p_id";
   show_screen($location);

}//elseif
}//function

function friends_view(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$pro=form_get("pro");
if($pro=='1'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'>Friends</td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","1");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
elseif($pro=='2'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'>Friends</td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","2");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends2","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
elseif($pro=='3'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'>Friends</td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","3");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends3","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
elseif($pro=='4'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'>Friends</td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","4");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends4","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
elseif($pro=='all'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'>Friends</td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","all");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friendsall","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
}//function

function friends_manager(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
    $pro=form_get("pro");
    if($pro=='add'){
       add_friend();
    }//if
    elseif($pro=='remove'){
       remove_friend();
    }//elseif
    elseif($pro==''){
    //showing friends list
    $page=form_get("page");
    if($page==''){
      $page=1;
    }
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'>Friends</td>
       <tr><td><table align=center>";
       show_friends($m_id,"10","5","$page");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends","$page","10");
       echo "</td>
       </table>";
       show_footer();
    }//elseif

}//function

function add_friend(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

   $add=form_get("add");
   $frd_id=form_get("frd_id");

   $sql_query="select mes_id from messages_system where
   (mem_id='$m_id' and frm_id='$frd_id' and type='friend') or
   (mem_id='$frd_id' and frm_id='$m_id' and type='friend')";

   $num=sql_execute($sql_query,'num');
   //if user already invited another user to be friends
   if($num>0){
     error_screen(18);
   }//if

   $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$fr->mem_id'";
   $num=sql_execute($sql_query,'num');
   if($num>0){
     error_screen(18);
   }//if

   if($add==''){

   show_header();
   ?>
       <table width=100%>
           <tr><td class="lined padded-6 title">Add <? echo name_header($frd_id,$m_id); ?> as a Friend</td>
           <tr><td class="lined padded-6">
        <table width=100%>
            <tr><td align=right class="title">To</td>
            <td>
            <table class='lined body' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($frd_id); ?></br>
               <? show_online($frd_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$frd_id); ?></td>
               <tr><td class='padded-6'>Network: <? echo count_network($frd_id,"1","num"); ?> in a
               network of <? echo count_network($frd_id,"all","num"); ?>
               </td>
            </table>
            </td>
            <form action="index.php" method=post>
            <input type="hidden" name="mode" value="user">
            <input type="hidden" name="act" value="friends">
            <input type="hidden" name="pro" value="add">
            <input type="hidden" name="add" value="done">
            <input type="hidden" name="frd_id" value="<? echo $frd_id; ?>">
            <tr><td align=right class="title">Subject</td>
            <td>
            <input type=text size=25 name=subject value="Invitation to Join <? echo name_header($m_id,$frd_id); ?>'s Personal Network">
            </td>
            <tr><td align=right class="title">Message</td>
            <td>
            <textarea name=mes rows=5 cols=45></textarea>
            </td>
            <tr><td colspan=2 align=right><input type="submit" value="Send"></form></td>
        </table>
      </td>
  </table>
   <?
   show_footer();
   }//if
   elseif($add=='done'){
        $mes=form_get("mes");
        $subject=form_get("subject");
        $now=time();

        //updating db (putting request to user inbox)
        $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date)
        values('$frd_id','$m_id','$subject','$mes','friend','inbox','$now')";
        sql_execute($sql_query,'');

        $sql_query="select email from members where mem_id='$frd_id'";
        $frd=sql_execute($sql_query,'get');

        //sending a message
        $data[0]=$subject;
        $data[1]=$mes;
        messages($frd->email,"5",$data);

        global $main_url;
        $link=$main_url."/index.php?mode=people_card&p_id=$frd_id";

        show_screen($link);

   }//elseif

}//function

function remove_friend(){
//deleting user from friends and redirect to referer
global $HTTP_REFERER;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$frd_id=form_get("frd_id");

          $sql_query="delete from network where mem_id='$m_id' and frd_id='$frd_id'";
          sql_execute($sql_query,'');
          $sql_query="delete from network where mem_id='$frd_id' and frd_id='$m_id'";
          sql_execute($sql_query,'');

          show_screen($HTTP_REFERER);

}//function

//view user's listings
function view_listings(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

show_header();
?>
<table width=100%>
<tr><td class="lined title">My Listings</td>
<tr><td class='lined padded-6'><? show_listings("my",$m_id,''); ?></td>
</table>
<?
show_footer();

}//function

//making intro
function make_intro(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$pro=form_get("pro");
$p_id=form_get("p_id");
if($pro==''){
show_header();
?>
   <table width=100% class='body'>
   <tr><td class="lined title">Make An Introduction</td>
   <tr><td class='lined padded-6'>
   <p>Do you have Friends in your Network who don't know each other, but have similar interests? Make an Introduction – you'll help them build their Networks, and they may discover that they have something in common.</p>
   <p align=center>
	   <table align=center class='body lined' cellspacing=0 cellpadding=0>
	   <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($p_id); ?></br>
	   <? show_online($p_id); ?>
	   </td>
	   <td class='td-lined-bottom padded-6'><? connections($m_id,$p_id); ?></td>
	   <tr><td class='padded-6'>Network: <? echo count_network($p_id,"1","num"); ?> friends in a
	   network of <? echo count_network($p_id,"all","num"); ?>
	   </td>
	   </table>
   </p>
   </td>
   <tr><td class="lined title">Which friend would you like to introduce to <? echo name_header($p_id,$m_id); ?></td>
   <tr><td class='lined padded-6'>
   <form action="index.php" method='post'>
   <input type=hidden name='mode' value='user'>
   <input type=hidden name='act' value='intro'>
   <input type=hidden name='p_id' value='<? echo $p_id; ?>'>
   <input type=hidden name='pro' value='done'>
        <?
        $friends=count_network($m_id,"1","ar");
        if($friends!=''){
            foreach($friends as $friend){

                echo " <table class='body' class='lined'>
                <tr><td vasilek>";show_photo($friend);echo "</br>
                <input type=radio name='rec_id' value='$friend'>";show_online($friend);
                echo "</td></table>";

        }//foreach
        }//if
        ?>
   </td>
   <tr><td class=lined align=right><input type=submit value='Select Friend'></form></td>
   </table>
<?
show_footer();
}//if
elseif($pro=='done'){
global $main_url;

$rec_id=form_get("rec_id");
//redirecting to messages system->compose message with selected recipients
$link=$main_url."/index.php?mode=messages&act=compose&rec_id[]=$rec_id&rec_id[]=$p_id&intro=1";
show_screen($link);

}//elseif
}//function

//showing sent invitations
function sent_invitations(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

show_header();
?>
       <table width=100%>
       <tr><td class='lined title'>Invite History</td>
       <tr><td class='lined'>
           <table class=body>

                 <?

                    $sql_query="select * from invitations where mem_id='$m_id'";
                    $res=sql_execute($sql_query,'res');
                    $num=sql_execute($sql_query,'num');
                    if($num==0){
                        echo "<tr><td align=center>No invitations were sent by you.</td>";
                    }//if
                    else {
                    echo "<tr><td>Sent To</td><td>Date</td><td>Status</td><td>Action</td>";
                       while($inv=mysql_fetch_object($res)){
                       $date=date("m/d/Y",$inv->date);
                       if($inv->stat=='p'){
                         $stat='Pending';
                       }//if
                       elseif($inv->stat=='r'){
                         $stat='User Registered';
                       }//elseif
                       elseif($inv->stat=='f'){
                         $stat='User is your friend';
                       }//elseif

                           echo "<tr><td>$inv->email</td><td>$date</td><td>$stat</td><td><a href='index.php?mode=user&act=inv_db&pro=del&inv_id=$inv->inv_id'>Delete</a></td>";
                       }//while


                    }//else


                 ?>
           </table></td>
       <tr><td class=lined align=right><input type=button value='Back' onClick='window.location="index.php?mode=login&act=home"'></td>
       </table>

<?
show_footer();
}//function

function invite_to_tribe(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$p_id=form_get("p_id");

$pro=form_get("pro");
if($pro==''){
  show_header();
  ?>
  <table width=100% class='body'>
  <form action='index.php' method=post>
  <input type='hidden' name='mode' value='user'>
  <input type='hidden' name='act' value='invite_tribe'>
  <input type='hidden' name='pro' value='done'>
  <input type='hidden' name='p_id' value='<? echo $p_id; ?>'>
  <tr><td colspan=2 class="lined title">Invite <? echo name_header($p_id,$m_id); ?> to Join <? echo $trb->name; ?></td>
  <tr><td colspan=2 class=lined><table width=100% class='body'>
  <tr><td align=right class="title">To</td>
  <td><table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 class='lined-right padded-6'><? show_photo($p_id); ?></br>
               <? show_online($p_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$p_id); ?></td>
               <tr><td class='padded-6'>Network: <? echo count_network($p_id,"1","num"); ?> friends in a
               network of <? echo count_network($p_id,"all","num"); ?>
               </td>
            </table></td>
   <tr><td align=right class="title">Group</td><td><select name=tribe>
                     <option value=''>select group
                     <? drop_mem_tribes($m_id,''); ?>
                     </select></td>
   <tr><td align=right class="title">Message</td><td><textarea rows=5 cols=45 name='body'></textarea></td>
   <tr><td></td><td><input type='submit' value='Send'></td></form>
  </table></td></table>
  <?
  show_footer();

}//if
elseif($pro=='done'){
global $main_url;
$body=form_get("body");
$now=time();
$tribe=form_get("tribe");
$p_id=form_get("p_id");
$subject=name_header($p_id,$m_id)." invites you to join tribe.";

        if($tribe!=''){
        $join=$main_url."/index.php?mode=tribe&act=join&trb_id=$tribe";
        $body.="\n"."<a href=$join>join</a>";
        $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date,special)
        values('$p_id','$m_id','$subject','$body','message','inbox','$now','$trb_id')";
        sql_execute($sql_query,'');
        $data[0]=$subject;
        $data[1]=$body;
        $data[2]=name_header($m_id,$p_id);
        $sql_query="select email from members where mem_id='$m_id'";
        $k=sql_execute($sql_query,'get');
        $data[3]=$k->email;
        $sql_query="select email from members where mem_id='$p_id'";
        $t=sql_execute($sql_query,'get');
        messages($t->email,"7",$data);
        }//if

 $link=$main_url."/index.php?mode=people_card&p_id=$p_id";
 show_screen($link);

}//elseif
}//function
function del_photo()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	global $main_url;
	$page=form_get("page");
	$pho_id=form_get("pho_id");
	del_album($m_id,"1","del",$pho_id);
	$link=$main_url."/index.php?mode=user&act=profile&pro=edit&type=photos";
	show_screen($link);
}
?>