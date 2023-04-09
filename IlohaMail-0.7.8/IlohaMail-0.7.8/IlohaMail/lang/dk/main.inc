<?
/********************************************************
        lang/dk/main.inc
        (C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

        This file is part of IlohaMail, and released under GPL.
        See COPYING, or http://www.fsf.org/copyleft/gpl.html

        Translated by Torben Rybner, Ziberex (try@ziberex.dk)

********************************************************/

function formatStatusString($num, $folder, $type){
        $str="";
        if ($type=="delete"){
                $str = "Slet $num meddelelse".($num>1?"r":"");
        }else if ($type == "move"){
                $str = "Flyttet $num meddelelse".($num>1?"r":"")." til $folder";
        }
        
        return $str;
}

$mainStrings=array(
    0=>"Meddelelse %p af %n",
    1=>" meddelelser fundet",
    2=>"Foreg&aring;ende",
    3=>" medd.",
    4=>"N&aelig;ste",
    5=>" medd.",
    6=>"Emne",
    7=>"Til",
    8=>"Fra",
    9=>"Dato",
    10=>"Slet",
    11=>"T&oslash;m papirkurv",
    12=>"Flyt markerede til",
    13=>"S&oslash;g",
    14=>"St&oslash;rrelse",
    15=>"Ikke navngivet",
    16=>"Vis",
    17=>"Opdater",
    18=>"Slet alle",
    19=>"Afbryd"
);

$mainErrors=array(
    0=>"Ingen meddelelser fundet i denne folder",
    1=>"Ingen meddelelser i denne folder",
    2=>"Kunne ikke flytte meddelse til papirkurven.",
    3=>"Kunne ikke indikere at meddelelsen er slettet.",
    4=>"Kunne ikke flytte meddelelser.",
    5=>"Papirkurv ikke specificeret.",
    6=>"Kunne ikke &aring;bne papirkurven",
    7=>"Er du sikker p&aring; at du vil slette ALLE meddelelser i %f?"
);


?>
