
<h1>{L_SE_LOG_ADMIN}</h1>

<P>{L_SE_LOG_ADMIN_EXPLAIN}</p>


<table width="25%" align="center">
     <tr>
          <th colspan="2" width="50%">Logs</th>
     </tr>
     <tr width="100%" align="center">
            <td width="50%" align="center">GoogleBot</td>
            <td width="50%" align="center">{GOOGLE_COUNT}</td>
    </tr>
</table>
</br>
</br>

<span class="gensmall"><a href="{U_SE_LOG_DELETE}">{L_SE_LOG_DELETE}</a></span>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
    <tr>
        <th class="thCornerL">{L_SE_LOG_TIME}</th>
        <th class="thTop">{L_SE_LOG_NAME}</th>
        <th class="thCornerR">{L_SE_LOG_URL}</th>
    </tr>
    <!-- BEGIN se_log_row -->
    <tr>
        <td class="{styles.ROW_CLASS}">{se_log_row.SE_LOG_TIME}</td>
        <td class="{styles.ROW_CLASS}">{se_log_row.SE_LOG_NAME}</td>
        <td class="{styles.ROW_CLASS}"><a href="{se_log_row.U_SE_LOG_URL}">{se_log_row.SE_LOG_URL}</a></td>
    </tr>
    <!-- END se_log_row -->
</table>

<table align="center">
<tr>
<td>
<span class="gensmall"><a href="http://www.tememento.de">FR (C)</a> Powered by <a href="http://www.php-styles.com">www.php-styles.com</a></span>
</td>
</tr>
</table>