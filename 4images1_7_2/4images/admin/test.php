<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="ltr">
  <head>
    <title>4images - Control Panel</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link rel="stylesheet" href="./../admin/cpstyle.css">
        <script language="JavaScript">
    <!--
    var statusWin, toppos, leftpos;
    toppos = (screen.height - 401)/2;
    leftpos = (screen.width - 401)/2;
    function showProgress() {
      statusWin = window.open('progress.php','Status','height=150,width=350,top='+toppos+',left='+leftpos+',location=no,scrollbars=no,menubars=no,toolbars=no,resizable=yes');
      statusWin.focus();
    }

    function hideProgress() {
      if (statusWin != null) {
        if (!statusWin.closed) {
          statusWin.close();
        }
      }
    }
    function CheckAll() {
      for (var i=0;i<document.form.elements.length;i++) {
        var e = document.form.elements[i];
        if ((e.name != 'allbox') && (e.type=='checkbox')) {
          e.checked = document.form.allbox.checked;
        }
      }
    }

    function CheckCheckAll() {
      var TotalBoxes = 0;
      var TotalOn = 0;
      for (var i=0;i<document.form.elements.length;i++) {
        var e = document.form.elements[i];
        if ((e.name != 'allbox') && (e.type=='checkbox')) {
          TotalBoxes++;
          if (e.checked) {
            TotalOn++;
          }
        }
      }
      if (TotalBoxes==TotalOn) {
        document.form.allbox.checked=true;
      }
      else {
        document.form.allbox.checked=false;
      }
    }
    // -->
    </script>
<script type="text/javascript" language="javascript" src="browserSniffer.js"></script>
<script type="text/javascript" language="javascript" src="calendar.js"></script>
  </head>
  <body leftmargin="20" topmargin="20" marginwidth="20" marginheight="20" bgcolor="#FFFFFF" text="#0F5475" link="#0F5475" vlink="#0F5475" alink="#0F5475">
<form action="images.php" name="form" method="post">
<input type="hidden" name="action" value="findimages">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td class="tableborder">
<table cellpadding="3" cellspacing="1" border="0" width="100%">
<tr class="tableheader">
<td colspan="2"><a name=""><b><span class="tableheader">Bilder bearbeiten</span></b></a>
</td>
</tr>
<tr class="tablerow">
<td><p class="rowtitle">Bild ID enthält</p></td>
<td><p><input type="text" size="50" name="image_id" value=""></p></td>
</tr>
<tr class="tablerow2">
<td><p class="rowtitle">Bild Name enthält</p></td>
<td><p><input type="text" size="50" name="image_name" value=""></p></td>
</tr>
<tr class="tablerow">
<td><p class="rowtitle">Beschreibung enthält</p></td>
<td><p><input type="text" size="50" name="image_description" value=""></p></td>
</tr>
<tr class="tablerow2">
<td><p class="rowtitle">Keywords enthält</p></td>
<td><p><input type="text" size="50" name="image_keywords" value=""></p></td>
</tr>
<tr class="tablerow">
<td><p class="rowtitle">Kategorie</p></td>
<td>
<select name="cat_id" class="categoryselect">
<option value="0">Alle Kategorien</option>
<option value="0">-------------------------------</option>
<option value="2" class="dropdownmarker">Test2</option>
<option value="4">-- qwgweg</option>
<option value="3" class="dropdownmarker">Test3</option>
<option value="1" class="dropdownmarker">Žiema</option>
</select>
</td>
</tr>
<tr class="tablerow2">
<td><p class="rowtitle">Bild-Dateiname enthält</p></td>
<td><p><input type="text" size="50" name="image_media_file" value=""></p></td>
</tr>
<tr class="tablerow">
<td><p class="rowtitle">Thumbnail-Dateiname enthält</p></td>
<td><p><input type="text" size="50" name="image_thumb_file" value=""></p></td>
</tr>
<tr class="tablerow2">
<td><p class="rowtitle">Datum nach dem<br /><span class="smalltext">(Format: jjjj-mm-tt hh:mm:ss)</span></p></td>
<td><p><input type="text" size="50" name="dateafter" value=""> <script language="JavaScript" type="text/javascript">
    <!--
     function setDate_dateafter(day, month, year)
		 {
		     if (day < 10) {
				   day = '0' + day;
				 }

				 if (month < 10) {
				   month = '0' + month;
				 }

				 document.form.dateafter.value = year + '-' + month + '-' + day;
		 }

		 calendar_dateafter = new calendar('calendar_dateafter', 'setDate_dateafter');
    //-->
   </script></p>
</td>
</tr>
<tr class="tablerow">
<td><p class="rowtitle">Datum vor dem<br /><span class="smalltext">(Format: jjjj-mm-tt hh:mm:ss)</span></p></td>
<td><p><input type="text" size="50" name="datebefore" value=""></p></td>
</tr>
<tr class="tablerow2">
<td><p class="rowtitle">Anzahl Downloads größer als</p></td>
<td><p><input type="text" size="50" name="downloadsupper" value=""></p></td>
</tr>
<tr class="tablerow">
<td><p class="rowtitle">Anzahl Downloads kleiner als</p></td>
<td><p><input type="text" size="50" name="downloadslower" value=""></p></td>
</tr>
<tr class="tablerow2">
<td><p class="rowtitle">Bewertung höher als</p></td>
<td><p><input type="text" size="50" name="ratingupper" value=""></p></td>
</tr>
<tr class="tablerow">
<td><p class="rowtitle">Bewertung niedriger als</p></td>
<td><p><input type="text" size="50" name="ratinglower" value=""></p></td>
</tr>
<tr class="tablerow2">
<td><p class="rowtitle">Anzahl Bewertungen größer als</p></td>
<td><p><input type="text" size="50" name="votesupper" value=""></p></td>
</tr>
<tr class="tablerow">
<td><p class="rowtitle">Anzahl Bewertungen kleiner als</p></td>
<td><p><input type="text" size="50" name="voteslower" value=""></p></td>
</tr>
<tr class="tablerow2">
<td><p class="rowtitle">Anzahl Hits größer als</p></td>
<td><p><input type="text" size="50" name="hitsupper" value=""></p></td>
</tr>
<tr class="tablerow">
<td><p class="rowtitle">Anzahl Hits kleiner als</p></td>
<td><p><input type="text" size="50" name="hitslower" value=""></p></td>
</tr>
<tr class="tableseparator">
<td colspan="2"><a name=""><b><span class="tableseparator">Anzeige Optionen</span></b></a></td>
</tr>
  <tr class="tablerow"><td><p><b>Sortieren nach</b></p></td><td><p>
  <select name="orderby">
  <option value="i.image_name" selected>Bild Name</option>
  <option value="i.cat_id">Kategorie</option>
  <option value="i.image_date">Datum</option>
  <option value="i.image_downloads">Anzahl Downloads</option>
  <option value="i.image_rating">Bewertung</option>
  <option value="i.image_votes">Anzahl Stimmen</option>
  <option value="i.image_hits">Anzahl Aufrufe</option>
  </select>
  <select name="direction">
  <option selected value="ASC">Aufsteigend</option>
  <option value="DESC">Absteigend</option>
  </select>
  </p></td></tr>
  <tr class="tablerow2">
<td><p class="rowtitle">Ergebnisse pro Seite</p></td>
<td><p><input type="text" size="50" name="limitnumber" value="50"></p></td>
</tr>
<tr class="tablefooter">
<td colspan="2" align="center">
&nbsp;<input type="submit" value="   Suchen   " class="button">
<input type="reset" value="   Zurücksetzen   " class="button">
&nbsp;
</td>
</tr>
</table>
</td>
</tr>
</table>
</form>
  </body>
</html>
