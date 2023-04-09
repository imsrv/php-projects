<?php
include ('admin_design.php');
include ('../application_config_file.php');
include ('admin_auth.php');
include("header.php");
?>

         <table width="100%" cellspacing="0" cellpadding="2" border="0">
         <tr>
             <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Scriptdemo.com News</b></font></td>
         </tr>
         <tr>
           <td bgcolor="#000000">
             <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
                    <tr>
                        <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><br>
							<?php
                            if (!@include("http://www.scriptdemo.com/scriptdemo_news_all.php"))
                            {
                                echo "<table align=center border=0 cellspacing=0 cellpadding=0 bgcolor=#efefef><tr><td align=center><font size='".TEXT_FONT_SIZE."'><br>Unable to open remote file on Scriptdemo.com<br><br></font></td></tr></table>";}
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_INDEX;?>">Home</a></font></td>
                    </tr>
             </table>
          </td>
         </tr>
        </table>
<?php
include("footer.php");
?>