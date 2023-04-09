<?
/********************************************************
    lang/dk/compose.inc
    (C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

    This file is part of IlohaMail, and released under GPL.
    See COPYING, or http://www.fsf.org/copyleft/gpl.html

    Translated by Torben Rybner, Ziberex (try@ziberex.dk)

********************************************************/

$composeHStrings=array(
    0=>"Emne",
    1=>"Fra",
    2=>"Til",
    3=>"CC",
    4=>"BCC",
    5=>"Dato"
);

$composeStrings=array(
    0=>"Ny meddelelse",
    1=>"Send meddelelse",
    2=>"Tilf&oslash;j bilag",
    3=>"Inds&aelig;t signatur",
    4=>"Bilag",
    5=>"Vis kontaktpersoner",
    6=>"Skjul kontaktpersoner",
    7=>"Meddelelsestekst:",
    8=>"Tilf&oslash;j",
    9=>"Den %d, skrev %s:\n",
    10=>"--- Oprindelig meddelelse ---\n",
    11=>"Luk vindue"
);

$composeErrors=array(
    0=>"Emnefeltet er tomt.  Angiv et emne for meddelelsen eller klik p&aring; \"" . $composeStrings[1] . "\" igen for at sende.",
    1=>"\"Fra\"-feltet er tomt.  Angiv din e-post adresse.",
    2=>"\"Til\"-feltet er tomt.  Angiv en eller flere modtagere.",
    3=>"Det lykkedes ikke at hente bilaget.",
    4=>"<BR>Bilaget blev ikke tilf&oslash;jet.",
    5=>"For at minimere muligheden for udsendelse af uanmodede meddelelser (spam), er det ikke tilladt at sende til mere end %1 personer (%2 ialt per meddelelse) hver %3 sekunder."
);
?>
