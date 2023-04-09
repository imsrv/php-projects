<?php include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);?>
<?php
if ($HTTP_GET_VARS['company']=="yes")
{
?>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="comp_email">
 <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
    <tr>
      <TD align="center"> <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_COMPANY_EMAIL;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
      <TD align="center">
        <INPUT TYPE="text" name="comp_email" size="40" maxlength="50">
      </TD>
     </tr>
     <tr>
      <td align="center">
          <input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>">
      </td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
 </td></tr>
</table>
</form>
 <form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="comp_name">
 <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_COMPANY_NAME;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
       <INPUT TYPE="text" name="comp_name" size="40" maxlength="50">
     </TD>
     </tr>
     <tr>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td>
</tr>
</table>
</form>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="comp_location">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
 <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_LOCATION;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
      <SELECT name="location" size="1">
         <option value="000"><?php echo TEXT_ALL_LOCATIONS;?></option>
         <?php
          $country_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          while ($country_result=bx_db_fetch_array($country_query))
          {
          echo '<option value="'.$country_result['locationid'].'"';
          if ($company_result['locationid']==$country_result['locationid']) {echo "selected";}
          echo '>'.$country_result['location'].'</option>';
          }
          ?>
         </SELECT>
      </TD>
     </tr>
     <tr>
      <TD align="center"><INPUT TYPE="checkbox" name="show" value="all" class="radio">&nbsp;&nbsp;<font class="smalltext"><?php echo TEXT_SHOW_ALL;?></font></TD>
     </tr>
     <tr>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td>
</tr>
</table>
</form>
<?php
}//end if ($HTTP_GET_VARS['company']=="yes")
if ($HTTP_GET_VARS['jobs']=="yes")
{
?>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
<input type="hidden" name="type" value="job_title">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
    <tr>
      <TD align="center"> <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_JOB_TITLE;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
      <TD align="center">
        <INPUT TYPE="text" name="job_title" size="40" maxlength="50">
      </TD>
      </tr>
      <tr>
      <td align="center">
          <input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>">
      </td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td>
</tr>
</table>
</form>

<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="job_employer">
 <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_EMPLOYERS;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
           <SELECT name="compid" size="1">
           <option value="000"><?php echo TEXT_ALL_EMPLOYERS;?></option>
        <?php
        $employer_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_companies");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($employer_result=bx_db_fetch_array($employer_query))
        {
        echo '<option value="'.$employer_result['compid'].'">'.$employer_result['company'].'</option>';
        }
        ?>
        </SELECT>
      </TD>
      </TR>
      <tr>
      <TD align="center"><INPUT TYPE="checkbox" name="show" value="all" class="radio">&nbsp;&nbsp;<font class="smalltext"><?php echo TEXT_SHOW_ALL;?></font></TD>
     </tr>
     <TR>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td></tr></table>
</form>

<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="job_category">
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_CATEGORY_NAME;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
           <SELECT name="jobcategoryid" size="1">
           <option value="000"><?php echo TEXT_ALL_CATEGORIES;?></option>
        <?php
        $title_query=bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($title_result=bx_db_fetch_array($title_query))
        {
        echo '<option value="'.$title_result['jobcategoryid'].'"';
        if (strstr($job_result['jobcategoryid'],$title_result['jobcategoryid'])) {echo "selected";}
        echo '>'.$title_result['jobcategory'].'</option>';
        }
        ?>
        </SELECT>
      </TD>
    </tr>
    <tr>
      <TD align="center"><INPUT TYPE="checkbox" name="show" value="all" class="radio">&nbsp;&nbsp;<font class="smalltext"><?php echo TEXT_SHOW_ALL;?></font></TD>
    </tr>
    <TR>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td></tr></table>
</form>
<?php
}//end if ($HTTP_GET_VARS['jobs']=="yes")
if ($HTTP_GET_VARS['invoices']=="yes")
{
?>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="invoice_id">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
     <tr>
      <TD align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_OPERATIONID;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
      <TD align="center">
        <INPUT TYPE="text" name="invoice_id" size="10" maxlength="20">
      </TD>
      </tr>
     <TR>
       <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
    </tr>
    <TR>
     <td>&nbsp;</td>
    </tr>
 </table>
</td></tr></table>
</form>

<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="invoice_employer">
 <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_EMPLOYERS;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
           <SELECT name="compid" size="1">
           <option value="000"><?php echo TEXT_ALL_EMPLOYERS;?></option>
        <?php
        $employer_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_companies");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($employer_result=bx_db_fetch_array($employer_query))
        {
        echo '<option value="'.$employer_result['compid'].'">'.$employer_result['company'].'</option>';
        }
        ?>
        </SELECT>
      </TD>
      </TR>
      <tr>
      <TD align="center"><INPUT TYPE="checkbox" name="show" value="all" class="radio">&nbsp;&nbsp;<font class="smalltext"><?php echo TEXT_SHOW_ALL;?></font></TD>
     </tr>
     <TR>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td></tr></table>
</form>

<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="invoice_pricing">
 <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_PRICING_TYPE;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
           <SELECT name="pricingid" size="1">
           <option value="000"><?php echo TEXT_ALL_PRICING_TYPE;?></option>
        <?php
        $pricing_query=bx_db_query("SELECT * FROM ".$bx_table_prefix."_pricing_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($pricing_result=bx_db_fetch_array($pricing_query))
        {
        echo '<option value="'.$pricing_result['pricing_id'].'">'.$pricing_result['pricing_title'].'</option>';
        }
        ?>
        </SELECT>
      </TD>
      </TR>
      <tr>
      <TD align="center"><INPUT TYPE="checkbox" name="show" value="all" class="radio">&nbsp;&nbsp;<font class="smalltext"><?php echo TEXT_SHOW_ALL;?></font></TD>
     </tr>
     <TR>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td></tr></table>
</form>
<?php
}//end if ($HTTP_GET_VARS['jobs']=="invoices")

if ($HTTP_GET_VARS['jobseekers']=="yes")
{
?>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="pers_email">
 <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
    <tr>
      <TD align="center"> <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_JOBSEEKER_EMAIL;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
      <TD align="center">
        <INPUT TYPE="text" name="pers_email" size="40" maxlength="50">
      </TD>
     </tr>
     <tr>
      <td align="center">
          <input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>">
      </td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
 </td></tr>
</table>

</form>
 <form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="pers_name">
 <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_JOBSEEKER_NAME;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
       <INPUT TYPE="text" name="pers_name" size="40" maxlength="50">
     </TD>
     </tr>
     <tr>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td>
</tr>
</table>
</form>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="pers_location">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
 <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_LOCATION;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
      <SELECT name="location" size="1">
         <option value="000"><?php echo TEXT_ALL_LOCATIONS;?></option>
         <?php
          $country_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng);
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          while ($country_result=bx_db_fetch_array($country_query))
          {
          echo '<option value="'.$country_result['locationid'].'"';
          if ($company_result['locationid']==$country_result['locationid']) {echo "selected";}
          echo '>'.$country_result['location'].'</option>';
          }
          ?>
         </SELECT>
      </TD>
     </tr>
     <tr>
      <TD align="center"><INPUT TYPE="checkbox" name="show" value="all" class="radio">&nbsp;&nbsp;<font class="smalltext"><?php echo TEXT_SHOW_ALL;?></font></TD>
     </tr>
     <tr>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td>
</tr>
</table>
</form>
<?php
}//end if ($HTTP_GET_VARS['jobseeker']=="yes")
if ($HTTP_GET_VARS['resumes']=="yes")
{
?>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
<input type="hidden" name="type" value="resume_title">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
    <tr>
      <TD align="center"> <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_RESUME_TITLE;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
      <TD align="center">
        <INPUT TYPE="text" name="resume_title" size="40" maxlength="50">
      </TD>
      </tr>
      <tr>
      <td align="center">
          <input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>">
      </td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td>
</tr>
</table>
</form>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="resume_persid">
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_RESUME_JOBSEEKER_NAME;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
           <SELECT name="persid" size="1">
           <option value="000"><?php echo TEXT_ALL_JOBSEEKERS;?></option>
        <?php
        $persons_query=bx_db_query("select * from ".$bx_table_prefix."_resumes,".$bx_table_prefix."_persons where ".$bx_table_prefix."_resumes.persid = ".$bx_table_prefix."_persons.persid");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($persons_result=bx_db_fetch_array($persons_query))
        {
        echo '<option value="'.$persons_result['persid'].'"';
        echo '>'.$persons_result['name'].'</option>';
        }
        ?>
        </SELECT>
      </TD>
    </tr>
    <tr>
      <TD align="center"><INPUT TYPE="checkbox" name="show" value="all" class="radio">&nbsp;&nbsp;<font class="smalltext"><?php echo TEXT_SHOW_ALL;?></font></TD>
     </tr>
    <TR>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td></tr></table>
</form>
<form action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SEARCH;?>" method="post">
 <input type="hidden" name="type" value="resume_category">
  <table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
   <td bgcolor="#000000">
  <table width="100%" cellspacing="0" cellpadding="2" border="0" bgcolor="#00CCFF">
   <tr>
     <TD align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_SEARCH_RESUME_CATEGORY_NAME;?>:</B></FONT>
      </TD>
     </tr>
     <tr>
     <TD align="center">
           <SELECT name="jobcategoryid" size="1">
           <option value="000"><?php echo TEXT_ALL_CATEGORIES;?></option>
        <?php
        $title_query=bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($title_result=bx_db_fetch_array($title_query))
        {
        echo '<option value="'.$title_result['jobcategoryid'].'"';
        if (strstr($job_result['jobcategoryid'],$title_result['jobcategoryid'])) {echo "selected";}
        echo '>'.$title_result['jobcategory'].'</option>';
        }
        ?>
        </SELECT>
      </TD>
    </tr>
    <tr>
      <TD align="center"><INPUT TYPE="checkbox" name="show" value="all" class="radio">&nbsp;&nbsp;<font class="smalltext"><?php echo TEXT_SHOW_ALL;?></font></TD>
     </tr>
    <TR>
     <td align="center"><input type="submit" name="search" value="<?php echo TEXT_SEARCH;?>"></td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
 </table>
</td></tr></table>
</form>
<?php
}//end if ($HTTP_GET_VARS['resumes']=="yes")
?>