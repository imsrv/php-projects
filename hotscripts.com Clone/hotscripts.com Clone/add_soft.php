<?
include_once "logincheck.php";
include_once "config.php";
include_once "left_mem.php";

function main()
{
?>
<script language="javascript">
   //<!--
      function category(box)
{

str="choosecategory.php?box="  + box;

window.open(str,"Category","top=5,left=30,toolbars=no,maximize=yes,resize=yes,width=550,height=450,location=no,directories=no,scrollbars=yes");


}
	  function Validate(form) {
         if(form.program_name.value == "") {
            alert('Please enter a Program name.');
            return false;
         }
         if(form.cat1.value == "") {
            alert('Please choose category for the software');
            return false;
         }

         if(form.home_page.value == "http://" || form.home_page.value == "") {
            alert('Please enter a Home page URL.');
            return false;
         }
         if(form.long_description.value == "[Enter a 1,500 maximum character description of your product]") {
            alert('Please enter a Program description.');
            return false;
         }
         return true;
      }
   //-->
</script>

</head>

<body>
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td height="25">&nbsp;<a href="index.php"  class="barlink"><font color="#000000"><strong>HOME 
      </strong></font><strong></font></strong></a> <strong><font color="#000000">&gt; 
      ADD SOFTWARE</font></font></strong>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td width="80%" valign="top"><table width="550" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td height="25" bgcolor="#003366"> 
            <div align="center"><FONT color=#000000><strong><font color="#FFFFFF" size="2" >Post 
              New Software - Step 1 of 2</font></strong></FONT></div></td>
        </tr>
        <tr> 
          <td valign="top" bgcolor="#FFFFFF"> <form name="frm1" onSubmit="return Validate(this);" action="add_soft2.php" method="post">
              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td height="85" colspan="3" bgcolor="#F0F3F5"><div align="justify">This 
                      is where you will enter all of the pertinent information 
                      about your software. You will also enter a description of 
                      your product. Please be aware that your descriptions will 
                      most likely be altered by our team of Managing Editors. 
                      We do this not because we are mean-spirited brutes attempting 
                      to spitefully punish authors, who are understandably eager 
                      to market their products well. Rather, the editorial process 
                      is designed to provide the consistency of grammar, style 
                      and objectivity. </font></div></td>
                </tr>
                <tr bgcolor="#003366"> 
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Program 
                    name:</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                  <td> <input type="text" name="program_name" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="30" value=""> </font>
                  </td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Category 
                    :</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                  <TD valign="center"> <div align="left"><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                      </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#666666"> 
                      <input style="FONT-FAMILY: courier, monospace" name = "cat_name1" type = "text" id="cat_name1"  size="30" readOnly >
                      <input name = "cat1" type = "hidden" id="cat1" readonly >
                      <input type=BUTTON name=btn_name22 value="Select A Category" onClick=category('1')>
                      &nbsp; </font> </font>&nbsp;&nbsp;<font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      </font></div></TD>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Evaluation 
                    period:</b></font></td>
                  <td>&nbsp;</font></td>
                  <td> <input type="text" name="eval_period" MAXLENGTH="120" style="font-family: courier,monospace;" SIZE="30" value=""> 
                    <br>
                    E.g. &quot;30 day trial&quot; or &quot;30 uses only&quot;</font></td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Currency:</b></font></td>
                  <td>&nbsp;</font></td>
                  <td> <select name="currency_symbol_id">
                      <option value="" selected><b>Select a Value</b> 
                      <?
			  $cats=mysql_query("select * from sbwmd_currency ");
			  while($rst=mysql_fetch_array($cats))
			  {
			  		  ?>
                      <option value="<? echo $rst["id"]; ?>"><? echo $rst["cur_name"]; ?></option>
                      <?
					}//end while
					 ?>
                    </select> </font></td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Cost:</b></font></td>
                  <td>&nbsp;</font></td>
                  <td> <input type="text" name="cost" MAXLENGTH="120" SIZE="10" style="font-family: courier,monospace;" value=""> </font>
                  </td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Home 
                    page URL:</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                  <td> <input type="text" name="home_page" MAXLENGTH="255" SIZE="30" style="font-family: courier,monospace;" value="http://"> </font>
                  </td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Major 
                    features:</b></font></td>
                  <td>&nbsp;</font></td>
                  <td> <textarea name="major_features" rows="2" COLS="25" style="font-family: courier,monospace; width: 250;"></textarea> </font>
                  </td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Additional 
                    software required:</b><br> <small>( Minimum requirements for 
                    Games )</small></font></td>
                  <td>&nbsp;</font></td>
                  <td> <textarea name="addl_required" rows="2" COLS="25" style="font-family: courier,monospace; width: 250;"></textarea> </font>
                  </td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Program 
                    description:</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                  <td> <textarea name="long_description" rows="10" cols="25" style="font-family: courier,monospace; width: 250;">[Enter a 1,500 maximum character description of your product]</textarea>
                    </font> </td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Author 
                    notes:</b></font></td>
                  <td>&nbsp;</font></td>
                  <td> <textarea name="notes" ROWS="10" COLS="25" style="font-family: courier,monospace; width: 250;">[Enter any notes for the reviewer]</textarea> </font>
                  </td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;</font></td>
                  <td>&nbsp;</font></td>
                  <td> <p align="justify"> Please be sure you filled out the form 
                      completely or it will slow or stop the submission process 
                      for your program. </font></p></td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#f4f4f4">&nbsp;</font></td>
                  <td>&nbsp;</font></td>
                  <td> <INPUT type=submit value=Submit name=submit> </font></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<?
}// end main
include "template1.php";
?>
