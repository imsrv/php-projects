<?
  session_start();

  include "../affconfig.php";
  include "./lang/$language";
  
  $errorMsg = '';
  
  if($_POST['commited'] == 'yes')
  {
    // form was sent
    mysql_connect($server, $db_user, $db_pass)
      or die ("Database CONNECT Error (line 8)"); 

    if($_POST['ausername'] == '')
      $errorMsg .= AFF_SI_UNAMEMISSING.'<br>'; 

    // check if user doesnt exist already
    $userid = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['ausername']); // protect against sql injection
    
    $chk_user = mysql_db_query($database, "select refid from affiliates where refid='$userid'");
    if(mysql_num_rows($chk_user) > 0)
    {
      $errorMsg .= AFF_SI_USEREXISTS.'<br>'; 
      $_POST['ausername'] = '';
    }
    
    if($_POST['apassword'] == '')
      $errorMsg .= AFF_SI_PWDMISSING.'<br>';
      
    if($_POST['aemail'] == '')
      $errorMsg .= AFF_SI_EMAILMISSING.'<br>';

    if($errorMsg == '') 
    {
      // save and send notification email
      $aemailbody = "Dear ".$_POST['afirstname'].",\n\nThank you for signing up to our affiliate program.\nYour account details are below:\n\n"
          ."Username: ".$_POST['ausername']."\nPassword: ".$_POST['apassword']."\n\n"
          ."You can log into your account and view your 'real-time' statistics by going to:\n"
          ."http://".$domain."/user/index.php\n\n"
          ."Thank you once again, and we wish you luck with your profit making!\n\n\n"
          ."Affiliate Manager\n"
          .$_POST['emailinfo']."\n\n\n\n";
      
      mysql_db_query($database, "INSERT INTO affiliates VALUES ('".$_POST['ausername']."', '".$_POST['apassword']."', '".$_POST['acompany']."', '".$_POST['atitle']."', '".$_POST['afirstname']."', '".$_POST['alastname']."', '".$_POST['awebsite']."', '".$_POST['aemail']."', '".$_POST['apayable']."', '".$_POST['astreet']."', '".$_POST['atown']."', '".$_POST['acounty']."', '".$_POST['apostcode']."', '".$_POST['acountry']."', '".$_POST['aphone']."', '".$_POST['afax']."', '".$_POST['adate']."')") 
        or die(mysql_error()); 
      
      include "thankyou.php"; 
      
      mail($_POST['aemail'], "Welcome New Affiliate!", $aemailbody, "From:".$emailinfo."\nReply-To:".$emailinfo."\n"); 
      exit;
    }     
  }
  
  
  include "header.php"; 
?>  
      <p align=center><br>
      <p align=center><font face=Arial size=2 color=#000000><b><font size=3>Affiliate Signup</font></b></font></p>
<? if($errorMsg != '')
     echo "<p align=center><font color=#ff0000>$errorMsg</font></p>";
?>      
      <form name="signupform" method="post" action="signup.php">
        <table border="0" cellspacing="3" cellpadding="1">
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Title:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <select name="atitle">
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Miss">Miss</option>
                <option value="Ms">Ms</option>
                <option value="Dr">Dr</option>
              </select>
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">First 
              Name:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="afirstname" size=20 value="<?=$_POST['afirstname']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Last 
              Name:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="alastname" size=20 value="<?=$_POST['alastname']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Company:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="acompany" size=20 value="<?=$_POST['acompany']?>">
              </font></b></td>
          </tr>
           <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Website 
              Address:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="awebsite" size=20 value="<?=$_POST['awebsite']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Email 
              Address: *</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="aemail" size=20 value="<?=$_POST['aemail']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Street 
              Address:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="astreet" size=20 value="<?=$_POST['astreet']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Town:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="atown" size=20 value="<?=$_POST['atown']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">County/State:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="acounty" size=20 value="<?=$_POST['acounty']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">PostCode/Zip:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="apostcode" size=20 value="<?=$_POST['apostcode']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Country:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
             <select name=acountry class=dropdown value="UK" >
                  <option value=AF>Afghanistan 
                  <option value=AL>Albania 
                  <option value=DZ>Algeria 
                  <option value=AS>American Samoa 
                  <option value=AD>Andorra 
                  <option value=AO>Angola 
                  <option value=AI>Anguilla 
                  <option value=AQ>Antarctica 
                  <option value=AG>Antigua and Barbuda 
                  <option value=AR>Argentina 
                  <option value=AM>Armenia 
                  <option value=AW>Aruba 
                  <option value=AU>Australia 
                  <option value=AT>Austria 
                  <option value=AZ>Azerbaidjan 
                  <option value=BS>Bahamas 
                  <option value=BH>Bahrain 
                  <option value=BD>Banglades 
                  <option value=BB>Barbados 
                  <option value=BY>Belarus 
                  <option value=BE>Belgium 
                  <option value=BZ>Belize 
                  <option value=BJ>Benin 
                  <option value=BM>Bermuda 
                  <option value=BO>Bolivia 
                  <option value=BA>Bosnia-Herzegovina 
                  <option value=BW>Botswana 
                  <option value=BV>Bouvet Island 
                  <option value=BR>Brazil 
                  <option value=IO>British Indian O. Terr. 
                  <option value=BN>Brunei Darussalam 
                  <option value=BG>Bulgaria 
                  <option value=BF>Burkina Faso 
                  <option value=BI>Burundi 
                  <option value=BT>Buthan 
                  <option value=KH>Cambodia 
                  <option value=CM>Cameroon 
                  <option value=CA>Canada 
                  <option value=CV>Cape Verde 
                  <option value=KY>Cayman Islands 
                  <option value=CF>Central African Rep. 
                  <option value=TD>Chad 
                  <option value=CL>Chile 
                  <option value=CN>China 
                  <option value=CX>Christmas Island 
                  <option value=CC>Cocos (Keeling) Isl. 
                  <option value=CO>Colombia 
                  <option value=KM>Comoros 
                  <option value=CG>Congo 
                  <option value=CK>Cook Islands 
                  <option value=CR>Costa Rica 
                  <option value=HR>Croatia 
                  <option value=CU>Cuba 
                  <option value=CY>Cyprus 
                  <option value=CZ>Czech Republic 
                  <option value=CS>Czechoslovakia 
                  <option value=DK>Denmark 
                  <option value=DJ>Djibouti 
                  <option value=DM>Dominica 
                  <option value=DO>Dominican Republic 
                  <option value=TP>East Timor 
                  <option value=EC>Ecuador 
                  <option value=EG>Egypt 
                  <option value=SV>El Salvador 
                  <option value=GQ>Equatorial Guinea 
                  <option value=EE>Estonia 
                  <option value=ET>Ethiopia 
                  <option value=FK>Falkland Isl.(Malvinas) 
                  <option value=FO>Faroe Islands 
                  <option value=FJ>Fiji 
                  <option value=FI>Finland 
                  <option value=FR>France 
                  <option value=FX>France (European Ter.) 
                  <option value=TF>French Southern Terr. 
                  <option value=GA>Gabon 
                  <option value=GM>Gambia 
                  <option value=GE>Georgia 
                  <option value=DE>Germany 
                  <option value=GH>Ghana 
                  <option value=GI>Gibraltar 
                  <option value=GB>Great Britain (UK) 
                  <option value=GR>Greece 
                  <option value=GL>Greenland 
                  <option value=GD>Grenada 
                  <option value=GP>Guadeloupe (Fr.) 
                  <option value=GU>Guam (US) 
                  <option value=GT>Guatemala 
                  <option value=GN>Guinea 
                  <option value=GW>Guinea Bissau 
                  <option value=GY>Guyana 
                  <option value=GF>Guyana (Fr.) 
                  <option value=HT>Haiti 
                  <option value=HM>Heard & McDonald Isl. 
                  <option value=HN>Honduras 
                  <option value=HK>Hong Kong 
                  <option value=HU>Hungary 
                  <option value=IS>Iceland 
                  <option value=IN>India 
                  <option value=ID>Indonesia 
                  <option value=IR>Iran 
                  <option value=IQ>Iraq 
                  <option value=IE>Ireland 
                  <option value=IL>Israel 
                  <option value=IT>Italy 
                  <option value=CI>Ivory Coast 
                  <option value=JM>Jamaica 
                  <option value=JP>Japan 
                  <option value=JO>Jordan 
                  <option value=KZ>Kazachstan 
                  <option value=KE>Kenya 
                  <option value=KG>Kirgistan 
                  <option value=KI>Kiribati 
                  <option value=KP>Korea (North) 
                  <option value=KR>Korea (South) 
                  <option value=KW>Kuwait 
                  <option value=LA>Laos 
                  <option value=LV>Latvia 
                  <option value=LB>Lebanon 
                  <option value=LS>Lesotho 
                  <option value=LR>Liberia 
                  <option value=LY>Libya 
                  <option value=LI>Liechtenstein 
                  <option value=LT>Lithuania 
                  <option value=LU>Luxembourg 
                  <option value=MO>Macau 
                  <option value=MG>Madagascar 
                  <option value=MW>Malawi 
                  <option value=MY>Malaysia 
                  <option value=MV>Maldives 
                  <option value=ML>Mali 
                  <option value=MT>Malta 
                  <option value=MH>Marshall Islands 
                  <option value=MQ>Martinique (Fr.) 
                  <option value=MR>Mauritania 
                  <option value=MU>Mauritius 
                  <option value=MX>Mexico 
                  <option value=FM>Micronesia 
                  <option value=MD>Moldavia 
                  <option value=MC>Monaco 
                  <option value=MN>Mongolia 
                  <option value=MS>Montserrat 
                  <option value=MA>Morocco 
                  <option value=MZ>Mozambique 
                  <option value=MM>Myanmar 
                  <option value=NA>Namibia 
                  <option value=NR>Nauru 
                  <option value=NP>Nepal 
                  <option value=AN>Netherland Antilles 
                  <option value=NL>Netherlands 
                  <option value=NT>Neutral Zone 
                  <option value=NC>New Caledonia (Fr.) 
                  <option value=NZ>New Zealand 
                  <option value=NI>Nicaragua 
                  <option value=NE>Niger 
                  <option value=NG>Nigeria 
                  <option value=NU>Niue 
                  <option value=NF>Norfolk Island 
                  <option value=MP>Northern Mariana Isl. 
                  <option value=NO>Norway 
                  <option value=OM>Oman 
                  <option value=PK>Pakistan 
                  <option value=PW>Palau 
                  <option value=PA>Panama 
                  <option value=PG>Papua New 
                  <option value=PY>Paraguay 
                  <option value=PE>Peru 
                  <option value=PH>Philippines 
                  <option value=PN>Pitcairn 
                  <option value=PL>Poland 
                  <option value=PF>Polynesia (Fr.) 
                  <option value=PT>Portugal 
                  <option value=PR>Puerto Rico (US) 
                  <option value=QA>Qatar 
                  <option value=RE>Reunion (Fr.) 
                  <option value=RO>Romania 
                  <option value=RU>Russian Federation 
                  <option value=RW>Rwanda 
                  <option value=LC>Saint Lucia 
                  <option value=WS>Samoa 
                  <option value=SM>San Marino 
                  <option value=SA>Saudi Arabia 
                  <option value=SN>Senegal 
                  <option value=SC>Seychelles 
                  <option value=SL>Sierra Leone 
                  <option value=SG>Singapore 
                  <option value=SK>Slovak Republic 
                  <option value=SI>Slovenia 
                  <option value=SB>Solomon Islands 
                  <option value=SO>Somalia 
                  <option value=ZA>South Africa 
                  <option value=SU>Soviet Union 
                  <option value=ES>Spain 
                  <option value=LK>Sri Lanka 
                  <option value=SH>St. Helena 
                  <option value=PM>St. Pierre & Miquelon 
                  <option value=ST>St. Tome and Principe 
                  <option value=KN>St.Kitts Nevis Anguilla 
                  <option value=VC>St.Vincent & Grenadines 
                  <option value=SD>Sudan 
                  <option value=SR>Suriname 
                  <option value=SJ>Svalbard & Jan Mayen Is 
                  <option value=SZ>Swaziland 
                  <option value=SE>Sweden 
                  <option value=CH>Switzerland 
                  <option value=SY>Syria 
                  <option value=TJ>Tadjikistan 
                  <option value=TW>Taiwan 
                  <option value=TZ>Tanzania 
                  <option value=TH>Thailand 
                  <option value=TG>Togo 
                  <option value=TK>Tokelau 
                  <option value=TO>Tonga 
                  <option value=TT>Trinidad & Tobago 
                  <option value=TN>Tunisia 
                  <option value=TR>Turkey 
                  <option value=TM>Turkmenistan 
                  <option value=TC>Turks & Caicos Islands 
                  <option value=TV>Tuvalu 
                  <option value=UM>US Minor outlying Isl. 
                  <option value=UG>Uganda 
                  <option value=UA>Ukraine 
                  <option value=AE>United Arab Emirates 
                  <option value=UK>United Kingdom 
                  <option value=US>United States 
                  <option value=UY>Uruguay 
                  <option value=UZ>Uzbekistan 
                  <option value=VU>Vanuatu 
                  <option value=VA>Vatican City State 
                  <option value=VE>Venezuela 
                  <option value=VN>Vietnam 
                  <option value=VG>Virgin Islands (British) 
                  <option value=VI>Virgin Islands (US) 
                  <option value=WF>Wallis & Futuna Islands 
                  <option value=EH>Western Sahara 
                  <option value=YE>Yemen 
                  <option value=YU>Yugoslavia 
                  <option value=ZR>Zaire 
                  <option value=ZM>Zambia 
                  <option value=ZW>Zimbabwe 
                </select>
              
              </font></b></td>
          </tr>

          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Phone:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="aphone" size=20 value="<?=$_POST['aphone']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Fax:</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="text" name="afax" size=20 value="<?=$_POST['afax']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Choose 
              Username: *</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">
              <input type="text" name="ausername" maxlength="12" size=20 value="<?=$_POST['ausername']?>">
              </font></b></td>
          </tr>
          <tr> 
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Choose 
              Password: *</font></b></td>
            <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"> 
              <input type="password" name="apassword" size="20" maxlength="12" >
              </font></b></td>
          </tr>
         
          <tr> 
            <td colspan=2> 
              <p>&nbsp;</p>
            </td>
           </tr>
          <tr> 
            <td colspan="2"> 
              <div align="center"> 
                <input type=hidden name=commited value=yes>
                <input type="submit" value="Submit Application" name="submit" >
              </div>
            </td>
          </tr>
        </table>
      </form>
      <br>
      
<?PHP include "footer.php"; ?> 