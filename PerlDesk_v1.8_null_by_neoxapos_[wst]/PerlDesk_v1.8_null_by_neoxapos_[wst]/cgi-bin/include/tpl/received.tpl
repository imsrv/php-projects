<!-- {{ The user views this page after logging a support request }} -->

<style type="text/css">
 .tbox {
	FONT-SIZE: 11px;
	FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif;
	COLOR: #000000;
	BACKGROUND-COLOR: #ffffff
}
</style> 
<form action="{mainfile}" method=post>
  <table width="100%" border="0" cellspacing="1" align="center">
    <tr> 
      <td> 
        <div align="center"> 
          <table width="482" border="0" cellpadding="0" cellspacing="0">
            <tr> 
              <td> {usernav} </td>
            </tr>
            <tr> 
              <td> 
                <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <a href="{mainfile}?do=logout&lang={lang}"><font color="#666666">%logout%, 
                  {name}</font></a></font></div>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr> 
      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">%thankyou%<br>
        <br>
        %subrec% <a href=$template{'mainfile'}?do=main>$LANG{'subrec2'}</a>&nbsp;</font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <table width="80%" border="0" cellpadding="1" align="center">
          <tr>
            <td width="43%">%callid%</td>
            <td width="57%">{callid}</td>
          </tr>
          <tr>
            <td width="43%">&nbsp;</td>
            <td width="57%">&nbsp;</td>
          </tr>
          <tr>
            <td width="43%">&nbsp;</td>
            <td width="57%">&nbsp;</td>
          </tr>
          <tr>
            <td width="43%">&nbsp;</td>
            <td width="57%">&nbsp;</td>
          </tr>
          <tr>
            <td width="43%">&nbsp;</td>
            <td width="57%">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>

