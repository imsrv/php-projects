<?
/********************************************************
        lang/dk/search.inc
        (C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

        This file is part of IlohaMail, and released under GPL.
        See COPYING, or http://www.fsf.org/copyleft/gpl.html

    Translated by Torben Rybner, Ziberex (try@ziberex.dk)

********************************************************/

        $fields=array("v&aelig;lg"=>"-", "Fra"=>"FROM", "Til"=>"TO", "Emne"=>"SUBJECT","Meddelelsestekst"=>"BODY");
        while (list($key, $value) = each ($fields)) {
                $fieldOptions.="<option value=\"$value\">$key\n";
        }
        
        $dates=array("er ligegyldig"=>"ignore", "er"=>"ON", "er efter"=>"SINCE", "er f&oslash;r"=>"BEFORE");
        while (list($key, $value) = each ($dates)) {
                $dateOptions.="<option value=\"$value\">$key\n";
        }
?>
<h2>S&oslash;g</h2>
<form method="POST" action="main.php">
        <input type="hidden" name="user" value="<? echo $sid; ?>">
        S&oslash;g i folder
        <select name="folder">
                        <? 
                                include("../lang/".$my_prefs["lang"]."defaultFolders.inc");
                                $conn = iil_Connect($host, $loginID, $password);
                                if ($conn){
                                        $folderlist=iil_C_ListMailboxes($conn, $my_prefs["rootdir"], "*");
                                        iil_Close($conn);
                                }
                                FolderOptions3($folderlist, $defaults);
                        ?>
        </select>
        <br>   hvor feltet
        <select   name="field">
                <?   echo   $fieldOptions;?>
        </select>
         indeholder 
        <input type="text"  name="string" >
        <br> og datoen
        <select name="date_operand">
                <? echo $dateOptions; ?>
        </select>
        <input type="text" name="day" value="DD" size=2>/
        <input type="text" name="month" value="MM" size=2>-
        <input type="text" name="year" value="ееее" size=4>
        <p><input type="submit" name="search" value="S&oslash;g">
</form>
