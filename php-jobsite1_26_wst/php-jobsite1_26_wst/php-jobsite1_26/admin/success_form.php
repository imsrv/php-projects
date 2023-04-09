<table width="100%" cellspacing="0" cellpadding="2" border="0">
      <tr>
          <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Admin Message</b></font></td>
      </tr>
      <tr>
         <td bgcolor="#000000">
         <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
            <tr>
                <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php
				if ($success_message) {
				    echo $success_message;
				}
				else {
					echo "Successfull update.";    
				}
				?></b></font></td>
            </tr>
            <tr>
                <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_INDEX;?>">Home</a></font></td>
            </tr>
			<tr>
                <td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><a href="javascript: history.go(-1);" onmouseover="window.status='Back'; return true;" onmouseout="window.status=''; return true;">Back</a></font></td>
            </tr>
         </table>
         </td>
      </tr>
</table>