<br> 
<form action="admin.php" method="post">
 <table>
   <tr>

        <td colspan=2><center><? echo translate("Message de bienvenue envoyé après la confirmation de l'abonné"); ?></center></td>
   </tr>

   <tr>
     <td><? echo translate("Sujet du message de bienvenue"); ?>  </td>
     <td> <input type="text" name="welcome_subj" value="<? echo stripslashes("$news->welcome_s"); ?>"> </td>
   </tr>
   <tr>
     <td valign="top"> <? echo translate("Corps du message de bienvenue"); ?>  </td>
     <td> <textarea name="welcome_msg" rows=10 cols=40><?echo stripslashes($news->bienvenue);?></textarea> </td>
   </tr>
  <tr>
     <td>&nbsp;  </td>
     <td>  </td>
   </tr>
   <tr>
     <td valign="top"><? echo translate("Message de demande de confirmation"); ?>  </td>
     <td> <textarea name="sub_msg" rows=10 cols=40><?echo stripslashes($news->sub_msg);?></textarea> </td>
   </tr>
  <tr>
     <td>&nbsp;  </td>
     <td>  </td>
   </tr>
   <tr>
     <td valign="top"><? echo translate("Pied des messages"); ?>  </td>
     <td> <textarea name="pied" rows=5 cols=40><?echo stripslashes($news->pied); ?></textarea> </td>
   </tr>
   <tr>
     <td>  </td>
     <td>  </td>
   </tr>


</table>
<input type="hidden" name="ok" value="1">
 <input type="hidden" name="mode" value="config">
 <input type="hidden" name="op" value="msg">

<p align="center"><input type="submit" value="<?echo translate("Mettre à jour"); ?>" ><input type="reset" value="<?echo translate("Réinitialiser"); ?>"></p>
</form>
