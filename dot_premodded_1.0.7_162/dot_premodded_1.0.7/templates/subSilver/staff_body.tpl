<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
  </tr>
</table>

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr>
    <th width="17%" class="thTop"><div align="left">{L_CATEGORY}</div>
	<table width="100%" cellpadding="2" cellspacing="0" border="0">
	<tr>
	<td width="100%" align="left" valign="top" class="{category.mods.users.ROW_CLASS}"><p class="gensmall">{L_FORUMS}</p></td>
	</tr>
	</table>
	</th>
	<th width="83%" class="thTop"><div align="left">{L_MODERATORS}</div>
				  <table width="100%" cellpadding="4" cellspacing="1" border="0">
  						<tr>
    						<td width="40%" align="left" valign="top" class="{category.mods.users.ROW_CLASS}"><p class="gensmall">{L_USERNAME}</p></td>
       						<td width="20%" align="center" valign="top" class="{category.mods.users.ROW_CLASS}"><p class="gensmall">{L_CONTACT}</p></td>
        					<td width="20%" align="center" valign="top" class="{category.mods.users.ROW_CLASS}"><p class="gensmall">{L_MESSENGER}</p></td>
        					<td width="20%" align="center" valign="top" class="{category.mods.users.ROW_CLASS}"><p class="gensmall">{L_WWW}</p></td>
  						</tr>
					</table>
	</th>
  </tr>
  <!-- BEGIN category -->
  
  <tr > 
        <td valign="Top" class="{category.ROW_CLASS}"><p class="gensmall"><span class="row3"><span class="nav"><b>{category.title}</b></span></span></p>
          <p class="gensmall">	 <!-- BEGIN forums -->      
      {category.forums.title}
<!-- END forums --></p></td>
		<td rowspan="2" valign="center" class="{category.ROW_CLASS}">
		 
				<table width="100%" cellpadding="2" cellspacing="0" border="0">
          <!-- BEGIN mods --> 
		  <tr>
		      <td width="100%" valign="top" class="{category.mods.ROW_CLASS}"><!--{category.mods.title}-->{category.mods.none}</td>
          </tr>
		  
		  <!-- BEGIN users --> 
		  <tr>
		      <td width="100%" valign="top" class="{category.mods.ROW_CLASS}">
			  <table width="100%" cellpadding="2" cellspacing="1" border="0">
  				<tr>
    				<td width="40%"><p class="gensmall">{category.mods.users.LINK}{category.mods.users.REAL_NAME}<br>
    				    {category.mods.users.RANK}</p></td>
        <td width="20%" class="{category.mods.users.ROW_CLASS}" valign="top" align="center">{category.mods.users.EMAIL} {category.mods.users.PM}</td>
        <td width="20%" class="{category.mods.users.ROW_CLASS}" valign="top" align="center">{category.mods.users.MSN} {category.mods.users.YIM}<br />{category.mods.users.AIM} {category.mods.users.ICQ}</td>
        <td width="20%" class="{category.mods.users.ROW_CLASS}" valign="top" align="center">{category.mods.users.WWW}</td>
  				</tr>
			</table>

			  </td>
          </tr>
		  <!-- END users --> 
		  <tr> </tr>
		  <!-- END mods --> 
        </table>		
				  
		  
	     
		  
		  </td>
  </tr>
  <tr >
    <td valign="top" class="{category.ROW_CLASS}"> 	   
 </td>
  </tr>
  
  <!-- END category -->
</table>


<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <tr><a name="Administrator"></a>
	<th width="100%" class="thTop"><div align="left">{L_ADMINISTRATOR}</div>
				  <table width="100%" cellpadding="2" cellspacing="1" border="0">
  						<tr>
    						<td width="20%" align="left" valign="top" class="{category.mods.users.ROW_CLASS}"><p class="gensmall">{L_USERNAME}</p></td>
       						<td width="20%" align="center" valign="top" class="{category.mods.users.ROW_CLASS}"><p class="gensmall">{L_CONTACT}</p></td>
        					<td width="20%" align="center" valign="top" class="{category.mods.users.ROW_CLASS}"><p class="gensmall">{L_MESSENGER}</p></td>
        					<td width="20%" align="center" valign="top" class="{category.mods.users.ROW_CLASS}"><p class="gensmall">{L_WWW}</p></td>
  						</tr>
					</table>
	</th>
		  <!-- BEGIN admin --> 
		  <tr>
		      <td width="100%" valign="top" class="{admin.ROW_CLASS}">
			  <table width="100%" cellpadding="2" cellspacing="2" border="0">
  				<tr>
    				<td width="20%"><p class="gensmall">{admin.LINK}{admin.REAL_NAME}<br>
    				    {admin.RANK}</p></td>
        <td width="20%" class="{admin.ROW_CLASS}" valign="top" align="center">{admin.EMAIL} {admin.PM}</td>
        <td width="20%" class="{admin.ROW_CLASS}" valign="top" align="center">{admin.MSN} {admin.YIM}<br />{admin.AIM} {admin.ICQ}</td>
        <td width="20%" class="{admin.ROW_CLASS}" valign="top" align="center">{admin.WWW}</td>
  				</tr>
			</table>

			  </td>
          </tr>
		  <!-- END admin -->
</table>