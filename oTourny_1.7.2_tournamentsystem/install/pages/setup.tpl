Please fill out the setup for your site. All these options can be modified later through the config.inc.php file.
<br>
<form action="install.php?page=verify" method="POST">
 <table width="600" class="setup">
  <tr>
   <th width="40%">
   </th>
   <th width="60%">
   </th>
  </tr>
  <tr>
   <td colspan="2" align="right">
    <input type="submit" name="{FIELD_SUBMIT}" value="Submit">
   </td>
  </tr>
  <tr>
   <td>
    Site Name:
    <br>
    <span class="requiredtxt">
     This is your site name. Only include the text for the name, no special characters. It will be used as the reference in all emails and in the layout.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_SITE_NAME}" value="{FIELD_SITE_NAME_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Site DNS:
    <br>
    <span class="requiredtxt">
     This is your site dns. This is the master dns location for your site, do not include 'www'.
     <br>
     Example: sf.net or yahoo.com
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_SITE_DNS}" value="{FIELD_SITE_DNS_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Site URL:
    <br>
    <span class="requiredtxt">
     This is your site URL. This is the exact location of your site in the w3 standard. All links will use this location.
     <br>
     Example: http://www.sf.net or http://www.yahoo.com
    </span>
   </td>
   <td>
     <input type="text" maxlength="255" size="30" name="{FIELD_SITE_URL}" value="{FIELD_SITE_URL_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Admin Email:
    <br>
    <span class="requiredtxt">
     This is the public email to the site admin. This email will be used in all emails and every location specifing support for the site.
     <br>
     Example: admin@yoursite.com
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_SITE_EMAIL}" value="{FIELD_SITE_EMAIL_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Database Type:
    <br>
    <span class="requiredtxt">
     This is the database server that will be used to host the site. Only the database listed are currently supported. You must use the same database to host the tournament site and the forum.
    </span>
   </td>
   <td>
    <select size="1" name="{FIELD_SQL_SRV}">
     <option value="mysql">
      MySQL
     </option>
     <option value="msql">
      Msql
     </option>
     <option value="oracle">
      Oracle
     </option>
     <option value="postgresql">
      PostgreSQL
     </option>
    </select>
   </td>
  </tr>
  <tr>
   <td>
    Database Host:
    <br>
    <span class="requiredtxt">
     This is the location of the database. Is usually 'localhost' unless database is servered on a different server.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_DB_HOST}" value="{FIELD_DB_HOST_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Tournament Engine Database Name:
    <br>
    <span class="requiredtxt">
     This is the name of the database for the site to use. This can be the same as the forum.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_DB_NAME}" value="{FIELD_DB_NAME_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Tournament Engine User Name:
    <br>
    <span class="requiredtxt">
     This is the name of the user for the site to use. This can be the same as the forum.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_DB_USER}" value="{FIELD_DB_USER_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Tournament Engine User Password:
    <br>
    <span class="requiredtxt">
     This is the password of the user for the site to use.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_DB_PASS}" value="{FIELD_DB_PASS_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Forum Type:
    <br>
    <span class="requiredtxt">
     This is the type of Forum you have installed on the site. You must have a forum installed for the site to work.
    </span>
   </td>
   <td>
    <select size="1" name="{FIELD_FORUM_TYPE}">
     <template name="FORUMS">
      <option value="{CLASS}">
       {NAME}
      </option>
     </template name="FORUMS">
    </select>
   </td>
  </tr>
  <tr>
   <td>
    Forum Database Name:
    <br>
    <span class="requiredtxt">
     This is the name of the database the forum is currently using.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_DBF_NAME}" value="{FIELD_DBF_NAME_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Forum User Name:
    <br>
    <span class="requiredtxt">
     This is the name of the user the forum is currently using.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_DBF_USER}" value="{FIELD_DBF_USER_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Forum User Password:
    <br>
    <span class="requiredtxt">
     This is the password of the user the forum is currently using.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_DBF_PASS}" value="{FIELD_DBF_PASS_VALUE}">
   </td>
  </tr>
  <tr>
   <td>
    Forum Table Prefixs:
    <br>
    <span class="requiredtxt">
     This is the Prefix to all the forum table name's.
    </span>
   </td>
   <td>
    <input type="text" maxlength="255" size="30" name="{FIELD_DBF_PRE}" value="{FIELD_DBF_PRE_VALUE}">
   </td>
  </tr>
  <tr>
   <td colspan="2" align="right">
    <input type="submit" name="{FIELD_SUBMIT}" value="Submit">
   </td>
  </tr>
 </table>
</form> 