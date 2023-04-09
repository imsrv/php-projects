<script src="include/b4submit.js" language="JavaScript" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
function AllFieldsFilled(submittedForm) {
  var fieldsNotRequired = new Array()
  var fieldCaption = new Array()
  /* BEGIN AUTHOR SPECS */
// If you remove any form fields from below you must remove the corresponding
// entry from here.
  fieldsNotRequired['fontface'] = true
  fieldsNotRequired['music'] = true
  fieldsNotRequired['notify'] = true

  fieldCaption['to[0]'] = "Recipient\'s name"
  fieldCaption['to_email[0]'] = "Recipient\'s email address"
  fieldCaption['to[1]'] = "Recipient\'s name"
  fieldCaption['to_email[1]'] = "Recipient\'s email address"
  fieldCaption['to[2]'] = "Recipient\'s name"
  fieldCaption['to_email[2]'] = "Recipient\'s email address"
  fieldCaption['from'] = "Your name"
  fieldCaption['from_email'] = "Your email address"
  fieldCaption['message'] = "The message"

  /* END AUTHOR SPECS */

  return RequiredFieldsFilled(submittedForm,fieldsNotRequired,fieldCaption)
}
</script>

  <table width="90%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%" colspan="2">
        <div align="center">
{IMG}
<br>
          {CAPTION}<br>
          <br>
        </div>
      </td>
    </tr>
  </table>


Fill in the form below, and then click on the button to preview the card..
<!-- BEGIN num_recipients --> 
<!-- DO NOT ALTER!!! --> 
<form method="post" action="">
  How many people would you like to send this card to? (if one person,
  please skip this step)
  <select  name="num_recipients">
    <option value="1" selected>1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
  </select>  <input type="hidden" name="image" value="{IMAGE}">
  <input type="hidden" name="caption" value="{CAPTION}">
  <input type="hidden" name="des" value="{DES}">
  <input type="hidden" name="template" value="{TEMPLATE}">
  <input type="hidden" name="applet_name" value="{APPLET_NAME}">
  <input type="hidden" name="img_width" value="{IMG_WIDTH}">
  <input type="hidden" name="img_height" value="{IMG_HEIGHT}">
  <input type="hidden" name="user1" value="{USER1}">
  <input type="hidden" name="user2" value="{USER2}">
  <input type="submit" name="Submit" value="Go">
</form>
<!-- END num_recipients -->


<form method="post" action="sendcard.php" name="sc_form" onSubmit="return AllFieldsFilled(this)">
  <table width="90%" border="0" cellspacing="0" cellpadding="0">
	<!-- BEGIN recipient_block --> 
	<tr> 
	  <td width="140">To:</td>
	  <td width="80%"> 
		<input type="text" name="to[{I}]" value="{TO}">
	  </td>
	</tr>
	<!-- Leave the following line in place!!! --> {INVALIDTO_EMAIL} 
	<tr> 
	  <td width="140">Email address</td>
	  <td width="80%"> 
		<input type="text" name="to_email[{I}]" value="{TO_EMAIL}">
	  </td>
	</tr>
	<!-- END recipient_block --> <!-- BEGIN from_block --> 
	<tr> 
	  <td width="140">From:</td>
	  <td width="80%"> 
		<input type="text" name="from" value="{FROM}">
	  </td>
	</tr>
	<!-- Leave the following line in place!!! --> {INVALIDFROM_EMAIL} 
	<tr> 
	  <td width="140">Your email address:</td>
	  <td width="80%"> 
		<input type="text" name="from_email" value="{FROM_EMAIL}">
	  </td>
	</tr>
	<!-- END from_block --> <!-- If you do not want this option, DO NOT remove this row!  Edit sendcard_setup.php instead --> 
	<!-- BEGIN date_row --> 
	<tr> 
	  <td width="140">When would you like the card to be sent?:</td>
	  <td width="80%"> {DATE} </td>
	</tr>
	<!-- END date_row --> <!-- BEGIN font_face --> 
	<tr> 
	  <td width="140">Choose a font:</td>
	  <td width="80%"> 
		<select name="fontface">
		  <option value="" selected>Default</option>
		  <option value="Arial, Helvetica, sans-serif">Arial, Helvetica, sans-serif</option>
		  <option value="Georgia, Times New Roman, Times, serif">Georgia, Times 
		  New Roman, Times, serif</option>
		  <option value="Verdana, Arial, Helvetica, sans-serif">Verdana, Arial, 
		  Helvetica, sans-serif</option>
		</select>
	  </td>
	</tr>
	<!-- END font_face --> <!-- Table row for setting the background colour.  If you don't want this feature then remove it --> 
	<tr> 
	  <td width="140">Choose the background Colour:</td>
	  <td width="80%"> 
		<table width="275" border="0" cellspacing="3" cellpadding="0">
		  <tr align="center"> 
			<td><font size="-1">Default</font></td>
			<td bgcolor="#FFFFCC">&nbsp;</td>
			<td bgcolor="#CCFFCC">&nbsp;</td>
			<td bgcolor="#333399">&nbsp;</td>
			<td bgcolor="#CC0000">&nbsp;</td>
			<td bgcolor="#333333">&nbsp;</td>
		  </tr>
		  <tr align="center"> 
			<td> 
			  <input type="radio" name="bgcolor" value="#FFFFFF" checked>
			</td>
			<td> 
			  <input type="radio" name="bgcolor" value="#FFFFCC">
			</td>
			<td> 
			  <input type="radio" name="bgcolor" value="#CCFFCC">
			</td>
			<td> 
			  <input type="radio" name="bgcolor" value="#333399">
			</td>
			<td> 
			  <input type="radio" name="bgcolor" value="#CC0000">
			</td>
			<td> 
			  <input type="radio" name="bgcolor" value="#333333">
			</td>
		  </tr>
		</table>
	  </td>
	</tr>
	<!-- End table row for setting the background colour --> 
<!-- BEGIN fontcolor_block --> 
	<tr> 
	  <td width="140">Choose the font colour:</td>
	  <td width="80%"> 
		<table width="275" border="0" cellspacing="3" cellpadding="0">
		  <tr align="center"> 
			<td bgcolor="#000000"><font color="#FFFFFF" size="-1">Default</font></td>
			<td bgcolor="#660066">&nbsp;</td>
			<td bgcolor="#333333">&nbsp;</td>
			<td bgcolor="#006699">&nbsp;</td>
			<td bgcolor="#006600">&nbsp;</td>
			<td bgcolor="#660000">&nbsp;</td>
		  </tr>
		  <tr align="center"> 
			<td> 
			  <input type="radio" name="fontcolor" value="#000000" checked>
			</td>
			<td> 
			  <input type="radio" name="fontcolor" value="#660066">
			</td>
			<td> 
			  <input type="radio" name="fontcolor" value="#333333">
			</td>
			<td> 
			  <input type="radio" name="fontcolor" value="#006699">
			</td>
			<td> 
			  <input type="radio" name="fontcolor" value="#006600">
			</td>
			<td> 
			  <input type="radio" name="fontcolor" value="#660000">
			</td>
		  </tr>
		</table>
	  </td>
	</tr>
<!-- END fontcolor_block --> 
<!-- BEGIN layout_block -->
	<tr>
	  <td width="140">Arrangement of the card:</td>
	  <td width="80%"> 
		<table width="160" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>
			  <div align="center"><img src="images/layout-top.gif" width="67" height="36"></div>
			</td>
			<td>
			  <div align="center"><img src="images/layout-left.gif" width="67" height="36"></div>
			</td>
		  </tr>
		  <tr>
			<td>
			  <div align="center">
				<input type="radio" name="template" value="message" checked>
			  </div>
			</td>
			<td>
			  <div align="center">
				<input type="radio" name="template" value="message-left">
			  </div>
			</td>
		  </tr>
		</table>
		
	  </td>
	</tr>
<!-- END layout_block -->
<!-- BEGIN music_row --> 
	<tr> 
	  <td width="140">Music?:</td>
	  <td width="80%"> 
		<select name="music">
		  <option value="" selected>None</option>
		  <option value="autumnleaves.mid">Autumn Leaves</option>
		  <option value="OverTheRainbow.mid">Over The Rainbow</option>
		  <option value="Pomp_and_Circumstance.mid">Pomp and Circumstance</option>
		</select>
	  </td>
	</tr>
	<!-- END music_row --> 
	<tr> 
	  <td width="140">Message:</td>
	  <td width="80%"> If you want to include a hyperlink, please insert &lt;&gt; 
		around it. If you don't then it will be treated as text.<br>
		<textarea name="message" cols="50" rows="8" wrap="VIRTUAL">{MESSAGE}</textarea>
	  </td>
	</tr>
  </table>
  Receive notification when the card is viewed (you will only be notified once,
  no matter how many times the card is viewed)
  <input type="checkbox" name="notify" checked>
  <br>
{FOOTER}
  <input type="submit" name="preview" value="Preview the card">
  <br>
</form>
<p align="center"><i>Powered by</i> <a href="http://www.sendcard.f2s.com/" target="_blank">sendcard</a>.</p>