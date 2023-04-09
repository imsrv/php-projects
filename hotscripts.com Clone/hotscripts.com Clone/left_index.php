<?
function left()
{
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
$recperpage=$rs0["recinpanel"];
?>
<table width="150" border="0" cellspacing="0" cellpadding="0">
  <?
if ( isset($_SESSION["userid"]) && $_SESSION["userid"]!="" )
{
?>
  <tr> 
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><img src="images/member.gif" width="164" height="25"></strong></font></td>
  </tr>
  <tr>
    <td><div align="center">
        <table width="125" border="0" cellpadding="0" cellspacing="2" bordercolor="#000000">
          <tr> 
            <td width="134" > <table width="125" border="0" align="right" cellpadding="0" cellspacing="1">
                <tr> 
                  <td><strong>&nbsp;<font size="1" > Welcome <? echo $_SESSION["name"] ?></font></a></strong></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr> 
    <td><div align="center"> 
        <table width="125" border="0" cellpadding="0" cellspacing="2" bordercolor="#000000">
          <tr> 
            <td > <table width="125" border="0" align="right" cellpadding="0" cellspacing="1">
                <tr> 
                  <td width="119">&nbsp;<a href="userhome.php" class="sidelink"><font size="1" > 
                    Members Area</font></a></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr> 
    <td><div align="center"> 
        <table width="125" border="0" cellpadding="0" cellspacing="2" bordercolor="#000000">
          <tr> 
            <td > <table width="125" border="0" align="right" cellpadding="0" cellspacing="1">
                <tr> 
                  <td>&nbsp;<a href="logout.php" class="sidelink"><font size="1" > 
                    Logout</font></a></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <?
  }
  ?>
  <tr> 
    <td height="23"> <div align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/features.gif" width="164" height="25"></font></div></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="0" cellspacing="2">
        <?
			  $featured=mysql_query("select id,s_name from sbwmd_softwares where featured='yes'  and approved='yes'");
			  $cnt=1;
			  while( ($rst=mysql_fetch_array($featured)) & ($cnt<=$recperpage) )
			  {			  
			  ?>
        <tr> 
          <td > <table width="130" border="0" align="right" cellpadding="0" cellspacing="1">
              <tr> 
                <td>&nbsp;<a class="sidelink" href="software-description.php?id=<? echo $rst["id"];?>"><? echo $rst["s_name"];?></a></td>
              </tr>
            </table></td>
        </tr>
        <?
			 $cnt++;
			 }//end while
			  ?>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="23"><div align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/popular.gif" width="164" height="25"></font></div></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="0" cellspacing="2" bordercolor="#000000">
        <?
			  $most_pop=mysql_query("select id,hits_dev_site,downloads,page_views from sbwmd_softwares ");
			  $cnt=1;
			  $popularity=0.0;
			  while($rst=mysql_fetch_array($most_pop) )
			  {
			  	if($rst["page_views"]==0)
				$popularity=0;
				else
				$popularity=(($rst["hits_dev_site"]+$rst["downloads"])/$rst["page_views"]);
				$popularity*=50;
				if($popularity>50)
				$popularity=50;
				mysql_query("update sbwmd_softwares set popularity=".$popularity." where id=".$rst["id"]);			  
			  }
			  $most_pop=mysql_query("select id,popularity,s_name from sbwmd_softwares where  approved='yes'    order by popularity desc");
			  $cnt=1;
			  
			  while( ($rst=mysql_fetch_array($most_pop) ) && ($cnt<=$recperpage) )
			  {
			  ?>
        <tr> 
          <td ><table width="130" border="0" align="right" cellpadding="0" cellspacing="1">
              <tr> 
                <td><a  class="sidelink"  href="software-description.php?id=<? echo $rst["id"];?>">&nbsp;<? echo $rst["s_name"];?></a></td>
              </tr>
            </table></td>
        </tr>
        <?
			 $cnt++;
			 }//end while
			  ?>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td> <div align="left">
        <script language=javascript> 
<!--
function emailCheck (emailStr) {
var emailPat=/^(.+)@(.+)$/
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
var validChars="\[^\\s" + specialChars + "\]"
var quotedUser="(\"[^\"]*\")"
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
var atom=validChars + '+'
var word="(" + atom + "|" + quotedUser + ")"
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
var matchArray=emailStr.match(emailPat)
if (matchArray==null) {
	alert("Email address seems incorrect (check @ and .'s)")
	return false
}
var user=matchArray[1]
var domain=matchArray[2]
if (user.match(userPat)==null) {
    alert("The username doesn't seem to be valid.")
    return false
}
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
    // this is an IP address
	  for (var i=1;i<=4;i++) {
	    if (IPArray[i]>255) {
	        alert("Destination IP address is invalid!")
		return false
	    }
    }
    return true
}
var domainArray=domain.match(domainPat)
if (domainArray==null) {
	alert("The domain name doesn't seem to be valid.")
    return false
}
var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 || 
    domArr[domArr.length-1].length>3) {
   alert("The address must end in a three-letter domain, or two letter country.")
   return false
}
if (len<2) {
   var errStr="This address is missing a hostname!"
   alert(errStr)
   return false
}
return true;
}

  function formValidate(form) {
	if ( form.username.value == "" ) {
       	   alert('Please enter your name!');
	   return false;
	   }
   if(!form.useremail.value.match(/[a-zA-Z\.\@\d\_]/)) {
           alert('Please provide valid email address');
           return false;
           }

if (!emailCheck (form.useremail.value) )
{
	return (false);
}

	return true;
  }
// -->
</script>
        <img src="images/newsletter.gif" width="164" height="25"> </div></td>
  </tr>
  <tr> 
    <td><table width="100" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td> <FORM name=register onsubmit=return(formValidate(this)); 
                  method=post action="insert_mailinglist.php">
              <table width="125" border="0" align="center" cellpadding="2" cellspacing="0">
                <tr> 
                  <td><font color="#000000" size="2" >Name</font></td>
                </tr>
                <tr> 
                  <td> <input name="username" type="text" class="keyword" size="20"></td>
                </tr>
                <tr> 
                  <td><font color="#000000" size="2" >Email</font></td>
                </tr>
                <tr> 
                  <td> <input name="useremail" type="text"  class="keyword" size="20"></td>
                </tr>
                <tr> 
                  <td> <input type="submit" name="Submit" value="subscribe" class="input"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<?
}// end left
?>