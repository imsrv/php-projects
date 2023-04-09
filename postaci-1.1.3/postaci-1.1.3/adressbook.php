<?
/*
   File name         : addressbook.php
   Version           : 1.1.3
   Last Modified By  : Umut Gokbayrak
   e-mail            : umut@trlinux.com
   Last modified     : 7 Nov 2000
*/

include ("includes/global.inc");
session_start();

// ID comparison between logged hash and session. If they are both the same, let the user to go on...
$dbq = $db->execute("select log_id from tblLoggedUsers where hash = '$ID'");
$log_id = $dbq->fields['log_id'];
$dbq->close();
if ($log_id == ""){

  Header("Location: index.php?error_id=1");
} else {

  function mychop($thistring,$length) {
    $result="";
    $mystring=trim($thistring);
    if (strlen($mystring)>$length) {
      $result=substr($mystring,0,$length);
      $result = "$result...";
    }else {
      $result=$mystring;
    }

    return($result);
  }

  $mbox_id = rawurldecode($mbox_id);

  include ("$postaci_directory" . "classes/imap_pop3.inc");

  // Check to see if the mbox_id is a valid one.
  $dbq = $db->execute("select user_id,username,password from tblLoggedUsers where hash='$ID'");
  $username = $dbq->fields['username'];
  $password = $dbq->fields['password'];
  $user_id = $dbq->fields['user_id'];
  $dbq->close();

  $email=new imap_pop3($default_port,$default_protocol,$default_host,$username,$password,$mbox_id);

  include ("$postaci_directory" . "includes/commonhead.inc");
  include ("$postaci_directory" . "includes/stylesheets.inc");
  include ("$postaci_directory" . "includes/javascripts.inc");
  include ("$postaci_directory" . "includes/functions.inc");

?>
  </head>

  <body bgcolor='#F3F3F3' leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" background="images/background.gif" text="#000000" link="#1F4687" vlink="#1F4687" alink="#1F4687" onLoad="MM_preloadImages('images/turkish_version2.gif','images/english_version2.gif')">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="1%" bgcolor="#273C79"><img src="images/empty.gif" width="15" height="1"></td>
      <td width="1%" bgcolor="#273C79" background="images/line_vertical_blue_back.gif"><img src="images/empty.gif" width="152" height="1"></td>
      <td width="98%" bgcolor="#273C79" background="images/line_vertical_blue_back.gif" align="right"><img src="images/postaci_webmail.jpg" width="349" height="32" alt="ver :  <? echo $postaci_version; ?>"></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="1">
    <tr>
      <td height="1" width="1%" bgcolor="#273C79"><img src="images/empty.gif" width="15" height="1"></td>
      <td height="1" width="1%"><img src="images/line_horizantal_shadow.gif" width="165" height="1"></td>
      <td height="1" width="98%"><img src="images/empty.gif" width="10" height="1"></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="400">
    <tr>
      <td width="1%"><img src="images/empty.gif" width="15" height="1"></td>
      <td width="1%" valign="top" align="left"><img src="images/company_logo2.jpg" width="152" height="152"><br>
        <table width="120" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td>
              <img src="images/dot.gif" width="10" height="10"> <a href="sendmail.php?mbox_id=<? echo $mbox_id; ?>"><? echo "$text25"; ?></a>
            </td>
          </tr>
          <tr>
            <td>
              <img src="images/dot.gif" width="10" height="10"> <a href="mailbox.php?mbox_id=INBOX"><? echo "$text26"; ?></a>
            </td>
          </tr>
          <tr>
            <td>
              <img src="images/dot.gif" width="10" height="10"> <a href="folders.php"><? echo "$text27"; ?></a>
            </td>
          </tr>
          <tr>
            <td>
              <table border="0" cellpadding="0" cellspacing="0" width="111">
                <tr>
                  <td width="8">
                    <img src="images/empty.gif" height="1" width="15">
                  </td>
                  <td width="112">
                    <?
                      if ($default_protocol == "pop3") {
                        echo "- <a href=\"mailbox.php?mbox_id=INBOX\">INBOX</a><br>";
                      }
                      $folders = $email->getMailboxes();
                      $folder_names = array();
                      $folder_counter=-1;
                      while (list($key,$val) = each($folders["name"])) {
                        $folder_counter++;
                        $folder_names[$folder_counter] = $val;
                      }
                      $ids = array();
                      $folder_counter=-1;
                      while (list($key,$val) = each($folders["id"])) {
                        $folder_counter++;
                        $ids[$folder_counter] = $val;
                      }

                      for($i=0;$i<count($ids);$i++) {
                        echo "- <a href=\"mailbox.php?mbox_id=$ids[$i]\">$folder_names[$i]</a><br>";
                      }
                    ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <img src="images/dot.gif" width="10" height="10"> <a href="preferences.php"><? echo "$text28"; ?></a>
            </td>
          </tr>
          <tr>
            <td>
              <img src="images/dot.gif" width="10" height="10"> <a href="index.php"><? echo "$text29"; ?></a>
            </td>
          </tr>
        <tr valign="bottom" align="center">
          <?
            if($show_sponsor) {
              echo "<td height=\"70\" class=\"style=\"8\">$text78</td>\n";
            } else {
              echo "<td height=\"70\" class=\"style=\"8\">&nbsp;</td>\n";
            }
          ?>
        </tr>
        <tr>
          <td>
            <div align="center">
              <table width="111" border="0" cellspacing="0" cellpadding="1" bgcolor="#333333">
                <tr>
                  <?
                    if ($show_sponsor) {
                      echo "<td><a href=\"http://www.yimpas.net.tr\"><img src=\"images/sponsor.gif\" width=\"109\" height=\"30\" border=\"0\"></a></td>\n";
                    }
                  ?>
                </tr>
              </table>
            </div>
          </td>
        </tr>
        </table>
      </td>
      <td width="98%" valign="top">

      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="150">
       <? include ($postaci_directory . "includes/headinside.inc"); ?>
        <tr>
          <td width="10" height="180" valign="top">
            <p><img src="images/empty.gif" width="1" height="180"></p>
          </td>
          <td valign="top" align="left">
            <hr size="1">&nbsp;<br>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" height="18">
              <tr bgcolor="#D1D1D1">
                <?
                  $mailadress = getMailAdress($user_id);
                ?>
                <td>&nbsp;<font color="#4E4E4E"><b> <? echo htmlspecialchars($mailadress) . " - " . $text22; ?></b></font></td>
              </tr>
            </table>&nbsp;<p>





            <table width='100%' border='0' cellspacing='2' cellpadding='0'>
              <tr>
                <td width='20%' bgcolor='#D1D1D1'><b><font color='#4E4E4E'><? echo $text61; ?></font></b></td>
                <td width='25%' bgcolor='#D1D1D1'><b><font color='#4E4E4E'><? echo $text20; ?></font></b></td>
                <td width='20%' bgcolor='#D1D1D1'><b><font color='#4E4E4E'><? echo $text62; ?></font></b></td>
                <td width='5%' bgcolor='#D1D1D1'>&nbsp;</td>
              </tr>
              <?
              $contactcount = 0;
              $dbq = $db->execute("select item_id from tblAdressbook where user_id = $user_id");
              $contactcount = $dbq->getNumOfRows();

              if ($contactcount == 0) {
                echo "          <tr>\n";
                echo "            <td nowrap colspan='4'><div align='center'>&nbsp;<br><b><font color='#304167'>$text63</font></b><hr size='1'><p></div></td>\n";
                echo "          </tr>\n";
              } else {
                $dbq = $db->execute("select * from tblAdressbook where user_id = $user_id order by real_name");
                while (!$dbq->EOF) {
                  $item_id   = $dbq->fields['item_id'];
                  $real_name = $dbq->fields['real_name'];
                  $email     = $dbq->fields['email1'];
                  $telephone = $dbq->fields['telephone'];

                  echo "          <tr bgcolor='#E3E7E8'>\n";
                  echo "            <td nowrap width='30%' nowrap><a href='contactdetails.php?item_id=$item_id'>$real_name</a>&nbsp;</td>\n";
                  echo "            <td width='40%' nowrap><a href='sendmail.php?to=$email'>$email</a>&nbsp;</td>\n";
                  echo "            <td width='20%' nowrap bgcolor='#E3E7E8' align='center'>$telephone &nbsp;</td>\n";
                  echo "            <td width='10%' nowrap align='center'><a href='deletecontact.php?item_id=$item_id'>$text57</a></td>\n";
                  echo "          </tr>\n";
                  $dbq->nextRow();
                }
                $dbq->close();
              }
              echo "        </table>\n";
              ?>

              <p align='center'><br>
              </p>
              <form method='post' action='createcontact.php'>
              <table width='550' border='0' cellspacing='0' cellpadding='0' align='center' bgcolor='#999999'>
                <tr>
                  <td>
                    <table width='550' border='0' cellspacing='1' cellpadding='0' align='center'>
                      <tr bgcolor='#D1D1D1'>
                        <td><b><font color='#4E4E4E'><? echo $text64; ?></font></b></td>
                      </tr>
                      <tr align='center' bgcolor='#F3F3F3'>
                        <td><? echo $text61; ?>
                          <input type='text' name='txtnamesurname'>
                          <? echo $text20; ?>
                          <input type='text' name='txtemail'><br>
                          <? echo $text62; ?>
                          <input type='text' name='txttelephone'>
                          <input type='submit' name='Submit' value='<? echo $text65; ?>'>
                        </td>
                      </tr>
                    </table>
                 </td>
               </tr>
              </table>
              </form>
              <p align='center'><br>












            <p>&nbsp; </p>
          </td>
          <td valign="top" width="10">&nbsp;</td>
        </tr>
        <tr>
          <td width="10" height="80" valign="top">&nbsp;</td>
          <td valign="bottom" align="right">
            <hr size="1">
            <div align="right"><span class="style8"><? echo $text84; ?></span></div>
            <p>
          </td>
          <td>&nbsp;</td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
  </body>
  </html>

<?
}
?>
