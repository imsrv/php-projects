<? include('admin/prices.inc.php'); ?>
<table width="400" border="0" cellspacing="2" cellpadding="0" align="left">
              <tr bgcolor="#006699"> 
                <td width="25%"> 
                  <div align="center"><b><font color="#FFFFFF">Credits</font></b></div>
                </td>
                <td width="25%"> 
                  <div align="center"><b><font color="#FFFFFF">CPM</font></b></div>
                </td>
                <td width="25%"> 
                  <div align="center"><b><font color="#FFFFFF">Price</font></b></div>
                </td>
                <td width="25%"> 
                  <div align="center"><b></b></div>
                </td>
              </tr>
              <tr bgcolor="EEEEEE"> 
                <td width="25%"> 
                  <div align="right"><? print number_format($c1,0,'','.'); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p1/$c1*1000,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p1,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="center">
                  <a href='https://www.paypal.com/cgibin/
webscr?amount=<? print number_format($p1,2,'.','');?>&no_shipping=1&return=<? print $path;?>/thanks.php&item_nam
e=<?print number_format($c1,0,'','.')?>+Credits&submit.x=34&submit.y=15&
business=<? print urlencode($email_pay);?>&item_number=1&undefined_quantity=0
&cancel_return=<? print $path; ?>/cancel.php
&cmd=_xclick&no_note=1'><font color=blue>Purchase</font></a>                  
                  </div>
                </td>
              </tr>
              <tr bgcolor="EEEEEE"> 
                <td width="25%"> 
                  <div align="right"><? print number_format($c2,0,'','.'); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p2/$c2*1000,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p2,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="center">
                  <a href='https://www.paypal.com/cgibin/
webscr?amount=<? print number_format($p2,2,'.','');?>&no_shipping=1&return=<? print $path;?>/thanks.php&item_nam
e=<?print number_format($c2,0,'','.')?>+Credits&submit.x=34&submit.y=15&
business=<? print urlencode($email_pay);?>&item_number=1&undefined_quantity=0
&cancel_return=<? print $path; ?>/cancel.php
&cmd=_xclick&no_note=1'><font color=blue>Purchase</font></a>                  
                  </div>
                </td>
              </tr>
              <tr bgcolor="EEEEEE"> 
                <td width="25%"> 
                  <div align="right"><? print number_format($c3,0,'','.'); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p3/$c3*1000,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p3,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="center"> <a href='https://www.paypal.com/cgibin/
webscr?amount=<? print number_format($p3,2,'.','');?>&no_shipping=1&return=<? print $path;?>/thanks.php&item_nam
e=<?print number_format($c3,0,'','.')?>+Credits&submit.x=34&submit.y=15&
business=<? print urlencode($email_pay);?>&item_number=1&undefined_quantity=0
&cancel_return=<? print $path; ?>/cancel.php
&cmd=_xclick&no_note=1'><font color=blue>Purchase</font></a>                  
                 </div>
                </td>
              </tr>
              <tr bgcolor="EEEEEE"> 
                <td width="25%"> 
                  <div align="right"><? print number_format($c4,0,'','.'); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p4/$c4*1000,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p4,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="center"> <a href='https://www.paypal.com/cgibin/
webscr?amount=<? print number_format($p4,2,'.','');?>&no_shipping=1&return=<? print $path;?>/thanks.php&item_nam
e=<?print number_format($c4,0,'','.')?>+Credits&submit.x=34&submit.y=15&
business=<? print urlencode($email_pay);?>&item_number=1&undefined_quantity=0
&cancel_return=<? print $path; ?>/cancel.php
&cmd=_xclick&no_note=1'><font color=blue>Purchase</font></a>                  
                 </div>
                </td>
              </tr>
              <tr bgcolor="EEEEEE"> 
                <td width="25%"> 
                  <div align="right"><? print number_format($c5,0,'','.'); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p5/$c5*1000,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="right">$ <? print number_format($p5,2,'.',''); ?></div>
                </td>
                <td width="25%"> 
                  <div align="center"> <a href='https://www.paypal.com/cgibin/
webscr?amount=<? print number_format($p5,2,'.','');?>&no_shipping=1&return=<? print $path;?>/thanks.php&item_nam
e=<?print number_format($c5,0,'','.')?>+Credits&submit.x=34&submit.y=15&
business=<? print urlencode($email_pay);?>&item_number=1&undefined_quantity=0
&cancel_return=<? print $path; ?>/cancel.php
&cmd=_xclick&no_note=1'><font color=blue>Purchase</font></a>                  
                 </div>
                </td>
              </tr>
            </table>
            