<table align="center" width="100%" border="0" cellspacing="2" cellpadding="0">
     <tr>
             <td>
             <table border="0" width="100%" cellspacing="0" cellpadding="0" align="center" bgcolor="#EFEFEF" style="border: 1px solid #000000;">
             <tr>
                 <td bgcolor="#BBBBBB"><font color="#FF0000">&nbsp;<b>Admin Tips!</b></font></td>
             </tr>
             <?php if(!$rand_num || $rand_num==1){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Site Title - Site Name</font></td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Site Title and Site Name (used in email messages) by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>" style="color: #FF0000; font-size: 14px;">Script Settings</a> Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. The First 2 lines are the <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>#SITE_NAME" style="color: #FF0000; font-size: 14px;">Site Name</a> and <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>#SITE_TITLE" style="color: #FF0000; font-size: 14px;">Site Title</a>.</font></td>
             </tr>       
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==2){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Admin Email Address</font></td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Admin Email Address by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>" style="color: #FF0000; font-size: 14px;">Script Settings</a> Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. The 4-th line is the <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_SETTINGS;?>#SITE_MAIL" style="color: #FF0000; font-size: 14px;">Admin Email Address</a>.</font></td>
             </tr>       
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==3){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Email Signature</font></td>
             </tr>             
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Email Signature by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%" class="smalltext">&nbsp;<b>Note:</b> The Email Signature is language based, so you need to change it to all languages, not only for the default language!</td>
             </tr>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto Edit Language Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. Select a &lt;language&gt; (e.g. english)</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;3. In the Edit Files Section edit &lt;language&gt;.php file (e.g. english.php)</font></td>
             </tr>    
              <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;4. The Email Signature is at the end of the file.</font></td>
             </tr> 
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==4){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Comapny Information - Invoice generation</font></td>
             </tr>             
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Company Information by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%" class="smalltext">&nbsp;<b>Note:</b> The Comapny Information is language based, so you need to change it to all languages, not only for the default language!</td>
             </tr>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto Edit Language Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. Select a &lt;language&gt; (e.g. english)</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;3. In the Edit Files Section edit &lt;language&gt;.php file (e.g. english.php)</font></td>
             </tr>    
              <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;4. The Comapny Information is the third text from the bottom.</font></td>
             </tr> 
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;5. Edit and Save the file.</font></td>
             </tr> 
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==5){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Payment Information - Manual Invoicing (Wire transfer information, check or other information)</font></td>
             </tr>             
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Payemnt Information by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%" class="smalltext">&nbsp;<b>Note:</b> The Payment Information is language based, so you need to change it to all languages, not only for the default language!</td>
             </tr>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto Edit Language Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. Select a &lt;language&gt; (e.g. english)</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;3. In the Edit Files Section edit &lt;language&gt;.php file (e.g. english.php)</font></td>
             </tr>    
              <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;4. The Payment Information box is the second text from the bottom.</font></td>
             </tr> 
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;5. Edit and Save the file.</font></td>
             </tr> 
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==6){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Job/Resume Categories</font></td>
             </tr>             
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Job/Resume Categories by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%" class="smalltext">&nbsp;<b>Note:</b> The Job/Resume categories are language based, so you need to change it to all languages, not only for the default language, you need to add only for one language, but after that you need to translate in the other languages!</td>
             </tr>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto Edit Language Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. Select a &lt;language&gt; (e.g. english)</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;3. Select Edit Jobcategories on the top menu</font></td>
             </tr>    
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;4. You can type the jobcategories in the "JobCategory List" one/line or you can add one by one with the "Add" button.</font></td>
             </tr> 
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;5. You can translate the jobcategories also in the "JobCategory List" by selecting the "Translating Mode" or you can update one by one with the "Update" button.</font></td>
             </tr> 
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==7){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Location Box</font></td>
             </tr>             
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Location Box values by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%" class="smalltext">&nbsp;<b>Note:</b> The Location Box is language based, so you need to change it to all languages, not only for the default language, you need to add only for one language, but after that you need to translate in the other languages!</td>
             </tr>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto Edit Language Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. Select a &lt;language&gt; (e.g. english)</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;3. Select Edit Locations on the top menu</font></td>
             </tr>    
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;4. You can type the locations in the " Location List" one/line or you can add one by one with the "Add" button.</font></td>
             </tr> 
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;5. You can translate the locations also in the "Location List" by selecting the "Translating Mode" or you can update one by one with the "Update" button.</font></td>
             </tr>
             
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==8){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Header/Footer</font></td>
             </tr>             
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Header/Footer layout by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%" class="smalltext">&nbsp;<b>Note:</b> The Header/Footer is language based, so you need to change it to all languages, not only for the default language!</td>
             </tr>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto Edit HTML Files Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. Select a &lt;language&gt; (e.g. english)</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;3. Select header.html (or footer.html) an editbox will appear with the content of those files</font></td>
             </tr>    
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;4. You can copy/paste the html source code for the layout (Note you have to use absolute paths for images to work correctly, e.g http://www.yourjobsite.com/images/imgheader.gif or /images/imgheader.gif).</font></td>
             </tr> 
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;5. Press the Save button to save the changes!</font></td>
             </tr>
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==9){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Left/Right Navigation</font></td>
             </tr>             
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Left/Right navigation layout by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%" class="smalltext">&nbsp;<b>Note:</b> The Left/Right Navigation is language based, so you need to change it to all languages, not only for the default language!</td>
             </tr>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto Edit HTML Files Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. Select a &lt;language&gt; (e.g. english)</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;3. Select e.g. left_navigation_notlogged.html (the jobseeker is not logged in) an editbox will appear with the content of those files</font></td>
             </tr>    
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;4. You can change the template as you wish, add your links or leave the old one (Note you have to use absolute paths for images to work correctly, e.g http://www.yourjobsite.com/images/imgheader.gif or /images/imgheader.gif).</font></td>
             </tr> 
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;5. Press the Save button to save the changes!</font></td>
             </tr>
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==10){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Terms Conditions for Employers/Jobseekers</font></td>
             </tr>             
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Terms Conditions text by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%" class="smalltext">&nbsp;<b>Note:</b> The Terms Conditions is language based, so you need to change it to all languages, not only for the default language!</td>
             </tr>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto Edit HTML Files Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. Select a &lt;language&gt; (e.g. english)</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;3. Select e.g. lterms_conditions_employer.html an editbox will appear with the content of this file</font></td>
             </tr>    
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;4. You can copy/paste the text for the terms conditions (employer or jobseeker).</font></td>
             </tr> 
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;5. Press the Save button to save the changes!</font></td>
             </tr>
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <?php }?>
             <?php if(!$rand_num || $rand_num==11){?>
             <tr>
                 <td width="100%">&nbsp;&nbsp;<font style="color: #FF0000; font-size: 13px; font-weight: bold; text-decoration: underline">Email Messages</font></td>
             </tr>             
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;You can change the Email Messages sent by the system to employers - jobseekers by following these steps:</font></td>
             </tr>
             <tr>
                 <td width="100%" class="smalltext">&nbsp;<b>Note:</b> The Email Messages is language based, so you need to change it to all languages, not only for the default language!</td>
             </tr>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;1. Goto Edit Email Messages Section</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;2. Select a &lt;language&gt; (e.g. english)</font></td>
             </tr>       
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;3. Select e.g. an email message file, an editbox will appear with the content of this file and the variables wich can be replaced with information from database</font></td>
             </tr>    
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;4. You can change the format, text, etc..for the email message.</font></td>
             </tr> 
             <tr>
                 <td width="100%"><font color="#FF0000">&nbsp;5. Press the Save button to save the changes!</font></td>
             </tr>
             <?php }
             if(!$rand_num){?>
             <tr>
                 <td width="100%">&nbsp;</td>
             </tr>       
             <tr>
                 <td>&nbsp;</td>
             </tr>
             <?php }else{?>        
             <tr>
                 <td align="right">&nbsp;<a href="<?php echo HTTP_SERVER_ADMIN."admin_tips.php"?>" style="font-weight: bold; font-size: 12px;">More Tips...</a>&nbsp;&nbsp;</td>
             </tr>
             <tr>
                 <td width="100%" align="center">Click <a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_INDEX?>?showtips=no" style="color: #FF0000; font-size: 14px;">here</a> if you Don't want to see tips like this here again!</td>
             </tr>    
             <?php }?>
            </table>
            </td>
     </tr>
</table>