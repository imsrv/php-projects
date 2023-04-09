# E-Lists 2.2 DO NOT EDIT
print "Content-type: text/html\n\n"; print qq~
<html>
<head><meta HTTP-EQUIV="Pragma" CONTENT="no-cache"><title>E-Lists Help</title></head>
<body bgcolor="#F5F5F5" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<center>
  <form><input type="button" value="  CLOSE WINDOW to Return  " onClick="window.close();" name="button"></form>
</center>
<center>
  <table width="95%" border="0" cellspacing="1" cellpadding="8">
    <tr bgcolor="#FFFFFE"> 
      <td> 
        <p><font face="Arial, Geneva, Helvetica" size="2">E-Lists2.2+ requires 
          that subscribing to any list is &quot;allowed&quot;. Therefore the ability 
          to create a list automatically simply by placing a new form on your 
          site as in previous versions is no longer applicable:<br>
          &#149; Forms created remotely cannot be used to spam your site <u>to 
          create bogus lists</u> IF referrer checking is switched off.<br>
          &#149; Lists can now be temporarily switched off by removing the list 
          from the &quot;allowed&quot; list, without deleting the list contents.</font></p>
        <p align="center"><font face="Arial, Geneva, Helvetica" size="2">All reference 
          to &quot;allowed&quot; relates to the above description.</font></p>
        <p align="center"><font face="Arial, Geneva, Helvetica" size="3"><b>The 
          MAIN ADMIN PAGE</b></font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>ADMIN Editing PASSWORD</b><br>
          All admin editing functions are accompanied by an ADMIN editing password. 
          This password is encrypted and IS NOT the same as the set-up config 
          file ACCESS password.<br>
          &#149; when admin is first accessed there is no admin editing password. 
          CREATE a NEW ADMIN PASSWORD via the input boxes near the foot of the 
          page. Later, CHANGE this password regularly.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>VIEW ADMIN BUTTON</b> 
          and Drop Menu<br>
          If a list is found in the nominated lists directory (set-up config file 
          variable), it will be shown in the drop menu at the top of the page. 
          If a list name in that drop menu is &quot;allowed&quot; then by selecting 
          it and clicking the button another admin window will appear <u>specifically 
          for that list</u>.<br>
          &#149; TO ALLOW AN EXISTING LIST NAME, choose it from the drop menu 
          and CLICK THE LINK BELOW the drop menu to place the correctly spelt 
          name in the &quot;ADD/EDIT&quot; input boxes ready for input of the 
          other data related to that list name. This ensures you use correctly 
          spelt case sensitive list name!<br>
          &#149; The drop menu list displays the current file size in bytes for 
          each found list name.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>FORM link</b> - working 
          sample html code<br>
          IF &quot;allowed&quot; list names have been activated then the word 
          FORM will be highlighted as a link. By first selecting a link name from 
          the ALLOWED DROP MENU LIST and then CLICKING the word FORM, a new window 
          will appear containing a sample form with all suitable options for that 
          list type. At the foot of the sample html code in the new window is 
          a list of variations that can be applied to that list type. This sample 
          should be a working sample you can copy and edit to create a new form 
          at any time.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>HELP link</b> - this 
          page.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>Names of "Allowed" 
          Mail Lists</b> - First Drop Menu<br>
          This drop menu contains a list of all &quot;allowed&quot; mail lists 
          names with the following information:<br>
          &#149; List Type - 0, 1, 2, 3, 4, 5.<br>
          &#149; The actual list name - without the file name extension<br>
          &#149; A simple brief descriptor for that list - all e-mail and reporting 
          refers to this descriptor<br>
          &#149; Whether the list is nominated for &quot;Remote Confirmation&quot; 
          or is a standard subscribe list - 0, or 1.<br>
          &#149; Below the allowed drop menu is a link. Select a list name and 
          CLICK this link. The details previously saved relating to that list 
          name will appear in the &quot;ADD/EDIT&quot; boxes below.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>ADD/EDIT</b> - List 
          Type options<br>
          Originating from the first versions of E-Lists and ListMerge early '99, 
          all dtp-aus.com programs saving to mail lists can save MAIL LISTS IN 
          THE FOLLOWING PERSONALISING FORMATS:<br>
          &#149; [0] Address,Name,Date<br>
          &#149; [1] Address,Name<br>
          &#149; [2] Name,Address<br>
          &#149; [3] Address only - <i>common simple list</i><br>
          &#149; [4] Address,Date<br>
          &#149; [5] E-Lists ONLY - see separate FORMAT 5 Section below.<br>
          These <b>variations allow personalised merged mail-outs</b> via your 
          local <b>PC</b> <i>OR</i> via the <b>Web</b> using ListMerge</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>ADD/EDIT</b> - Associated 
          Allowed List Details Boxes<br>
          Each allowed list uses a &quot;list name&quot; specific file to record 
          the following data:<br>
          &#149; selected LIST TYPE for this list - <i>above</i><br>
          &#149; the LIST NAME (correctly spelt, case sensitive)<br>
          &#149; the LIST DESCRIPTION. Keep this bief and simple. It is used as 
          the reference to a list in all output. <font color="#CC0000"><b>NOTE</b>: 
          a simple option useful to a few sites is to INCLUDE A DOT at the start 
          of this description</font>. If the program detects a &quot;dot&quot; 
          fist character it will NOT CHECK THE REFERRER (a specific lists subscriber 
          forms can be made available to remote sites! <i>ie</i> &quot;<font color="#CC0000"><b>.</b></font>Bobs 
          News Letter&quot;).<br>
          &#149; whether this list uses the &quot;REMOTE CONFIRMATION&quot; option 
          OR is a STANDARD subscribe list<br>
          &#149; the receiving ADDRESS related to this list - each list can have 
          a different &quot;webmasters address&quot;<br>
          &#149; the RECEIVERS NAME related to this list - can be a personal name, 
          department name, whatever.<br>
          &#149; the RECEIVERS ORGANISATION name - optional all lists<br>
          Receivers Name, Receivers Address, Organisation, are NOT APPLICABLE 
          for list TYPE 5 - see separate FORMAT 5 Section below.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>EDIT</b> - Associated 
          Allowed List Details Boxes<br>
          To edit an already allowed lists details, select the list name and CLICK 
          the link below the &quot;allowed lists&quot; drop menu. This will place 
          that lists details in the input boxes.<br>
          &#149; You CAN CHANGE the list TYPE of an EMPTY LIST.<br>
          &#149; Once a list contains subscribers you CANNOT CHANGE the list TYPE. 
          </font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>DELETING</b> - Associated 
          Allowed List Details<br>
          There are TWO options available when REMOVING A LIST FROM THE &quot;ALLOWED&quot; 
          LIST.<br>
          &#149; simply select the list from the &quot;deleting drop menu&quot; 
          and the associated &quot;allowed lists details file&quot; will be deleted. 
          Doing this DOES NOT DELETE the actual Mail List. This first option enables 
          the reactivation of that list at a later time.<br>
          &#149; check the FILES checkbox and THE LIST WILL BE PERMANENTLY DELETED 
          ALSO.<br>
          NOTE: via the second admin window a lists contents can be deleted BUT 
          NOT the list OR associated allowed data file - see below for second 
          admin window information.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>LnkinLite URL</b> 
          - Counted Links Promo Tracking<br>
          Only necessary IF you also install &quot;LnkinLite&quot;, the counted 
          Remote / Local hyperlinks management program. Rather than imbed PROMO 
          LINK TRACKING in E-Lists only, this program can be used for hyperlink 
          click counting throughout your site AND for placing counted link tracking 
          link URLs in OTHER programs sending autoresponse mail AND in ListMerge 
          mail-outs too!<br>
          &#149; If LnkinLite is installed, ADD THE FULL URL to the program in 
          this box. Then an access button will appear in the second admin window 
          for each specific list - enabling easy access to, creation of, and simple 
          pasting of COUNTED LINKS back to your site FROM WITHIN the E-Lists auto-response 
          when subscribing.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>SITE MATCHING OUTPUT 
          PAGES</b><br>
          A list appears in the main admin page showing which primary program 
          files have been found according to the set-up config file paths.<br>
          We STRONGLY SUGGEST that various test mail list types are created first, 
          subscribed to, Un-Subscribed, errors created, etc so you can see the 
          many variations of text reporting created by the program BEFORE YOU 
          EDIT THESE PAGES - IF changes are needed.<br>
          &#149; The files responsible for reporting E-Lists responses in HTML 
          are listed AND HYPERLINKED.<br>
          &#149; click any of these links and a new window will appear enabling 
          the simple Copy, Edit, Paste, of those pages so you can change their 
          appearance to suit your site. You can even include a complete page of 
          HTML code just SO LONG AS THE ORIGINAL OUTPUT continues to make sense 
          in your layout.<br>
          &nbsp;&nbsp;&nbsp;NOTE: When changing these HTML codes, RETAIN THE IMBEDDED 
          VARIABLES. The use of some WYSIWYG editors can result in these variables 
          being removed or edited as ISO characters.<br>
          &nbsp;&nbsp;&nbsp;NOTE: you must retain the simple (not linked!) program 
          name and copyright notices, READABLE AS IS WHERE APPLICABLE in our original 
          .zip files. You will also note that unlike others we do not include 
          links back to us, and the text is faded compared to the rest. These 
          are simple limitations in your favour, in return for the continuance 
          and upgrading of quality free-to-use software.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>ELOAD.CGI - PC To 
          Site List Uploading</b> - when available<br>
          Not available when E-Lists2.2 was first re-released there is an auxiliary 
          program developed to enable the uploading from your PC, list files to 
          the lists directory. BECAUSE of the versatility of E-Lists and the list 
          type format options, &quot;MIXED&quot; LIST TYPES MUST be avoided. <br>
          &#149; When this program is also installed, and found via the set-up 
          config variable, an access button will appear on the main admin page.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>Change ACCESS PASSWORD</b><br>
          First edited in the set-up config file, you can regularly change this 
          value via the editing boxes.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>Change ADMIN PASSWORD</b> 
          - see top of this page.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b>Change GMT time zone 
          value</b><br>
          This is NOT just the difference between your local time and that of 
          your severs.<br>
          Readily available from your PCs clock set-up, <b>G</b>reenwich <b>M</b>ean 
          <b>T</b>ime is the world standard time zone reference from which your 
          local zone will be ahead of or behind - in hours. Using the <b>Perl 
          gmt function</b> and the standard/default Unix timer set-up, this method 
          should allow constant time reporting via the server EVEN if the host 
          moves lofts to another time zone.<br>
          &#149; ALL dtp-aus.com programs use this method accessed via one common 
          file - <i>ie</i> change the value here and it will change for all dtp-aus.com 
          programs! (if your host has other ideas about server times, then simply 
          adjust by the error difference, plus or minus, until correct)</font></p>
        <p align="center"><font face="Arial, Geneva, Helvetica" size="2"><b><font size="3">LIST 
          FORMAT TYPE 5</font></b><font size="2"> - a new option as yet not fully 
          supported by admin</font></font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"> E-Lists supports a 
          new list format option where ONLY THE ADDRESS is relayed to another 
          mail list system. Some sites will already have address links to these 
          simple processes and may want to use the E-Lists forms commonly throughout 
          the site. The methods this can replace are usually just an address link 
          on a page some where, and accessible to spam address harvesting robots 
          etc. <br>
          &#149; IF using list format type 5 then you have to manually create 
          (COPY FROM SUPPLIED SAMPLE) a file in the &quot;elistdat&quot; directory 
          with the EXACT same name as the relative list BUT WITH the &quot;.pl&quot; 
          file extension.<br>
          &#149; Edit/remove the sample values placing the indicated special address 
          field marker where needed. If you have such methods on your site then 
          the file set up will be easily understood.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><b><font color="#CC0000">NOTE</font></b>: 
          Feedback on this option would be appreciated. Enough interest and the 
          file set-up will be added to admin.</font></p>
        <p align="center"><font face="Arial, Geneva, Helvetica" size="3"><b>SECOND 
          ADMIN PAGE - List Specific</b></font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2">The following are brief 
          explanations of the options available when the VIEW ADMIN BUTTON is 
          used to access list specific functions.<br>
          <b>Note</b>: List Type 5 access will display a reduced page because 
          most options are not available to type 5.<br>
          &#149; If the LIST DATA file is found it will be shown with a &quot;Yes&quot; 
          (created saved on main admin page).<br>
          &#149; If the RESPONSE TEXTS file specific to this list is found it 
          will be shown with a &quot;Yes&quot; (created saved on this page).<br>
          &#149; If the REJECTION LIST file specific to this list is found it 
          will be shown with a &quot;Yes&quot; (created saved on this page). Simply 
          add each entry followed by the ENTER KEY to create a list.<br>
          &#149; If for any reason you want to Subscribe an address to this list, 
          click the SUBSCRIBE BUTTON and a pop-up window will appear for this 
          list. Note this pop-up window can be resized.<br>
          &#149; Any changes not displayed directly via this page (<i>ie</i> adding 
          a subscriber) can be shown by using the REFRESH button to refresh this 
          page.<br>
          &#149; EITHER a SINGLE ADDRESS or ALL ADDRESSES can be removed form 
          this list via the DELETE ADDRESS form.<br>
          &#149; The SEARCH AND DELETE option will generate a list, up to 200 
          at a time, of matched search criteria.(<i>ie</i> for a list type 0, 
          matches can be found in addresses, names, and dates). Check boxes appear 
          next to each match allowing selected deletions from this list.<br>
          &#149; LIST ALL via the LIST SUBSCRIBERS form. A new window will appear 
          listing 200 address at a time.<br>
          &#149; A REJECTED DOMAINS list enables rejection of not only whole addresses, 
          but partial addresses too. (<i>ie</i> complete domains OR part domains 
          if a &quot;.&quot; dot appears after the domain name portion of the 
          list item - see supplied default list.<br>
          &#149; IF the LnkinLite program is installed and the URL saved via the 
          main admin page, a LnkinLite Access Button accessing the program will 
          appear.<br>
          &#149; The AUTO RESPONSE TEXT is entered/edited and saved via the large 
          input area box at the foot of this page. This text FILE IS SPECIFIC 
          TO just this list.</font></p>
        <p><font face="Arial, Geneva, Helvetica" size="2"><i>&nbsp;&nbsp;&nbsp;enjoy!</i></font></p>
      </td>
    </tr>
  </table>
</center>
<center>
  <form><input type="button" value="  CLOSE WINDOW to Return  " onClick="window.close();" name="button"></form>
</center>
</body></html>
~;
exit(0);
1;