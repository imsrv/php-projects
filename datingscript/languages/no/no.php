<?php
############################################################
# \-\-\-\-\-\-\     AzDG  - S C R I P T S    /-/-/-/-/-/-/ #
############################################################
# AzDGDatingLite          Version 2.0.3                    #
# Writed by               AzDG (support@azdg.com)          #
# Created 03/01/03        Last Modified 11/01/03           #
# Scripts Home:           http://www.azdg.com              #
############################################################
# File name               no.php                           #
# File purpose            Norwegian language file          #
# File created by         Knut Saglien <knut@witoweb.com>  #
############################################################

define('C_HTML_DIR','ltr'); // HTML direction for this language
define('C_CHARSET', 'iso-8859-1'); // HTML charset for this language

### !!!!! Please read it: RULES for translate!!!!! ###
### 1. Be carefull in translate - don`t use ' { } characters
###    You can use them html-equivalent - &#39; &#123; &#125;
### 2. Don`t translate {some_number} templates - you can only replace it - 
###    {0},{1}... - is not number - it templates
###################################

$w=array(
'<font color=red size=3>*</font>', //0 - Symbol for requirement field
'Sikkerhetsfel - #', //1
'Denne email er allerede i databasen. Velg en annen!', //2
'Feil fornavn. Fornavn skal v�re {0} - {1} tegn', //3 - Endrer {0} og {1} - se regel 2 !!!
'Feil etternavn. Etternavn skal v�re {0} - {1} tegn', //4
'Feil f�dselsdato', //5
'Feil passord. Passord skal v�re {0} - {1} tegn', //6
'Velg ditt kj�nn', //7
'Velg hva du s�ker etter', //8
'Hvilket forhold s�ker du etter', //9
'Velg ditt land', //10
'Ugyldig email', //11
'Feil webside', //12
'Feil ICQ nummer', //13
'Feil AIM', //14
'Ditt telefonnummer', //15
'Din by', //16
'Velg din n�v�rende status', //17
'Har du barn', //18
'Din h�yde', //19
'Din vekt', //20
'Velg h�yde p� den du s�ker etter', //21
'Velg vekt p� den du s�ker etter', //22
'Velg h�rfarge', //23
'Velg �yenfarge', //24
'Velg etnisk opprinnelse', //25
'Velg religion', //26
'Velg den etniske opprinnelse du s�ker etter', //27
'Velg den religion du s�ker etter', //28
'R�ker du', //29
'Drikker du', //30
'Velg utdannelse', //31
'Hva jobber du med', //32
'Hvilken alder s�ker du', //33
'Hvordan fant du oss', //34
'Hva er din hobby', //35
'Ugyldig hobby beskrivelse. Hobby feltet skal v�re mer enn {0} tegn', //36
'Ugyldig hobby antall tegn m� ikke v�re mer enn {0} tegn', //37
'Beskriv deg selv', //38
'Ugyldig. Beskrivelse m� ikke v�re mer enn {0} tegn', //39
'Ugyldig. Beskrivelse m� ikke v�re mer enn {0} tegn', //40
'Foto er p�krevd!', //41
'Lykke til! <br>Din aktiveringskode er sendt til din email. <br>Du skal bekrefte registrering p� email!', //42 - Message after register if need confirm by email

'Bekreft registrering', //43 - Mail bekr�ftelse
'Takk for du registrerte deg p� v�r side...
Klikk her for � bekrefte din registrering:

', //44 - Confirm message
'Takk for registreringen. Din profil vil bli godkjent om kort tid. Kom snart igjen...', //45 - Message after registering if admin allowing is needed
'Lykke til! <br>Din profil er n� lagret i databasen!<br><br>Din ID:', //46
'<br>Ditt passord:', //47
'Bekreft passord', //48
'Passordene stemmer ikke med hverandre', //49
'Registrer bruker', //50
'Ditt fornavn', //51
'tegn', //52
'Ditt etternavn', //53
'Passord', //54
'Bekreft passord', //55
'F�dselesdag', //56
'Kj�nn', //57
'Type forhold du s�ker', //58
'Land', //59
'Email', //60
'Webside', //61
'ICQ', //62
'AIM', //63
'Telefon', //64
'By', //65
'Din sivile status', //66
'Barn', //67
'H�jde', //68
'Vekt', //69
'H�rfarge', //70
'�yenfarge', //71
'Etnisk opprinnelse', //72
'Religion', //73
'R�ker', //74
'Drikker', //75
'Utdannelse', //76
'Jobb', //77
'Hobby', //78
'Beskriv deg selv og den du s�ker etter.', //79
'S�ker etter', //80
'S�ker etter f�lgende etnisk opprinnelse', //81
'S�ker etter person med f�lgende religion', //82
'S�ker etter alder', //83
'S�ker etter h�yde', //84
'S�ker etter vekt', //85
'Hvordan fant du oss?', //86
'Foto', //87
'Hjem', //88
'Registrere', //89
'Medlemsomr�de', //90
'S�k', //91
'Tilbakemelding', //92
'FAQ', //93
'Statistikker', //94
'Medlems menuID#', //95
'Se beskjeder', //96
'Mitt soverom', //97
'Min profil', //98
'Endre profil', //99
'Endre passord', //100
'Slett profil', //101
'Avslutt', //102
'Siden lastet p�:', //103
'sek.', //104
'Brukere online:', //105
'S�kning online:', //106
'Powered by <a href="http://www.azdg.com" target="_blank" class="desc">AzDG</a>', //107 - Don`t change link - only for translate - read GPL!!!
'Kun registrerte brukere kan bruke avansert s�k', //108
'Feil, "Alder fra" skal v�re mindre enn "Alder til"', //109
'Ditt s�k ga dessverre ingen resultat', //110
'Ingen', //111 Billeder tilg�ngelig?
'Ja', //112 Billede tilg�ngeligt?
'Kan ikke koble til server<br>Dit mysql login eller mysql kodeord er feil.<br>Kontroller det i config fil', //113
'Kan ikke koble til server<br>Databasen eksisterer ikke<br>Eller endre database navn i config', //114
'Sider :', //115
'S�keresultater', //116
'Total : ', //117 
'Brukernavn', //118
'Form�l', //119
'Alder', //120
'Land', //121
'By', //122
'Siste logginn', //123
'Registreringsdato', //124
'Avansert s�k', //125
'Bruker ID#', //126
'Fornavn', //127
'Etternavn', //128
'Stjernetegn', //129
'H�yde', //130
'Vekt', //131
'Kj�nn', //132
'Type bekjentskap', //133
'Sivil status', //134
'Barn', //135
'H�rfarge', //136
'�yenfarge', //137
'Etnisk opprinnelse', //138
'Religion', //139
'R�ker', //140
'Drikker', //141
'Utdannelse', //142
'S�k etter bruker med', //143
'Webside', //144
'ICQ', //145
'AIM', //146
'Telefon', //147
'Registreret i', //148
'Sorter resultat etter', //149
'Resultater p� side', //150
'Enkelt s�k', //151
'Adgang kun for medlemmer', //152
'Adgang lukket for � sende d�rlige profiler', //153
'Bruker er allerede i d�rlig profil database', //154
'Takk, Bruker er lagt til d�rlige profiler og vil bli undes�kt av admin om kort tid', //155
'Adgang lukket til soverom', //156
'Bruker er allerede i soverom', //157
'Takk, Bruker er lagt til i soverom', //158
'Din profil er blitt lagt til admin unders�kelse!', //159
'Din profil er lagret i databasen', //160
'Profil aktiveringsfeil. Er kanskje allerede aktiv', //161
'FAQ database er tom', //162
'FAQ svar#', //163
'Alle felter mp� fylles ut', //164
'Din beskjed er sendt', //165
'Skriv emne', //166
'Skriv beskjed', //167
'emne', //168
'beskjed', //169
'Send beskjed', //170
'For medlemmer', //171
'Login ID', //172
'Glemt passord', //173
'Anbefal oss', //174
'Venn-{0} email', //175
'F�dselsdag idag', //176
'Ingen f�dselsdager', //177
'Velkommen til Partners�k', //178 Welcome message header
'Partners�k - Er en fin m�te � finne enn venn eller partne for selskap, dating og langvarige forhold. � m�te hverandre her og l�re hverandre � kjenne her kan v�re en god m�te � starte ett forhold p�. Men bruk sunn fornuft og ikke legg ut for mange personlige opplysninger s� som adresse og telefonnummer.<br><br>Du kan ogs� m�te nye venner gjennem v�rt eget email system. Gjennem dette kan du kommunisere med andre medlemmer og l�re dem � kjenne og utvikle nye bekjentskper.<br>Husk at vi ikke kan godta annonser som henviser til kj�p/salg av<br>
seksuell tjenester', //179 Welcome message
'Siste {0} registrerte brukere', //180
'Hurtigs�k', //181
'Avansert s�k', //182
'Dagens foto', //183
'Statistiker', //184
'Din ID skal v�re ett nummer', //185
'Feil Login ID# eller passord', //186
'Adgang lukket for � sende beskjeder til email', //187
'Send beskjed til email bruker ID#', //188
'Ingen brukere online', //189
'Anbefal side er ikke telgjengelig', //190
'Hilsner fra {0}', //191 "Recommend Us" subject, {0} - username
'Hallo fra {0}!

Hvordan har du det:)

Bes�k denne side - den er god:
{1}', //192 "Recommend Us" message, {0} - username, {1} - site url
'Skriv navn p� ven#{0} email', //193
'Skriv navn og E-mail', //194
'Ditt passord fra {0}', //195 Reming password email subject
'Denne konto er deaktiveret eller eksisterer ikke i databasen.<br>Skriv venligst til admin om dette problemet. Inkluder ID.', //196
'Hallo!

Din ID#:{0}
Ditt passord:{1}

_________________________
{2}', //197 Remind password email message, Where {0} - ID, {1} - password, {2} - C_SNAME(sitename)
'Dit passord er sendt til din email.', //198
'Skriv inn din ID', //199
'Send passord', //200
'Adgang lukket for at sende beskjeder', //201
'Send beskjed til bruker ID#', //202
'Gi meg beskjed n�r brukeren har lest min beskjed', //203
'Ingen brukere databasen', //204
'Statistikk ikke tilgjengelig', //205
'Den ID eksisterer ikke', //206
'Profil ID#', //207
'Brukers Fornavn', //208
'Brukers Etternavn', //209
'F�dselsdag', //210
'Email', //211
'Beskjed fra Partners�k', //212 - Subject for email
'Jobb', //213
'Hobby', //214
'Om', //215
'Popularitet', //216
'Send email', //217
'Feil profil', //218
'Legg til i mitt soverom', //219
'Enten var ingen fil lastet opp, <br>eller s� var filen du pr�vde � laste opp st�rre end {0} Kb begrensningen. Din fil er {1} Kb', //220
'Bildet du ville laste opp var bredere {0} px Eller h�yere enn {1} pxl.', //221
'Fil du ville laste opp var av feil type (kun jpg, gif og png kan benyttes). Din type - ', //222
'(Max. {0} Kb)', //223
'Statistik p� lande', //224
'Du har ingen beskjeder', //225
'Total antall av beskjeder - ', //226
'Nummer', //227 Number
'Fra', //228
'Dato', //229
'Slett', //230 Delete
'<sup>Ny</sup>', //231 New messages
'Slett valgte beskjeder', //232
'Beskjed fra - ', //233
'Svar', //234
'Hallo, Du skrev {0}:\n\n_________________\n{1}\n\n_________________', //235 Reply to message {0} - date, {1} - message
'Din beskjed er n� lest', //236
'Din beskjed:<br><br><span class=dat>{0}</span><br><br>er lest av {1} [ID#{2}] in {3}', //237 {0} - message, {1} - Username, {2} - UserID, {3} - Date and Time
'{0} beskjeder slettet!', //238
'Skriv gammelt passord', //239
'Skriv nytt passord', //240
'Skriv nytt passord igjen', //241
'Endre passord', //242
'Gammelt passord', //243
'Nytt passord', //244
'Skriv nytt passord igjen', //245
'Du har ingen brukere i soverommet', //246
'Lagt inn dato', //247
'Slett valgte brukere', //248
'Er du sikker p� at du vil slette din egen profil?<br>Alle dine beskjeder, bilder vil bli fjernet fra databasen.', //249
'Bruker med ID#={0} Er slettet fra databasen', //250
'Din profil vil blitt slettet etter admin sikkerhetssjekk', //251
'{0} Brukere fjernet fra ditt soverom!', //252
'Ikke like passord eller de har feil tegn', //253
'Du har ikke adgang til � endre passord', //254
'Feil gammelt passord. G� tilbake og pr�v igjen!', //255
'Passord er n� endret!', //256
'Det er ikke mulig � fjerne alle bilder', //257
'Din profil er endret', //258
' - Slett bilde', //259
'Din session er n� avsluttet. Du kan n� trygt g� vekk herfra', //260
'Flaggbilder er ikke tilgjengelige', //261
'Spr�k', //262
'Enter', //263
'Login [3-16 chars [A-Za-z0-9_]]', //264
'Login', //265
'Your login must consist of 3-16 chars and only A-Za-z0-9_ chars is available', //266
'This is login already in database. Please select another!', //267
'Total users - {0}', //268
'The messages are not visible. You should be the privileged user see the messages.<br><br>You can purshase from <a href="'.C_URL.'/members/index.php?l=no&a=r" class=head>here</a>', //269 change l=default to l=this_language_name
'User type', //270
'Purshase date', //271
'Search results position', //272
'Price', //273
'month', //274
'Purshase Last date', //275
'Higher than', //276
'Purshase', //277
'Purshase with', //278
'PayPal', //279
'Thanks for your registration. Payment has been succesfully send and will be checked by admin in short time.', //280
'Incorrect error. Please try again, or contact with admin!', //281
'Send congratulation letter about privilegies activating', //282
'User type has successfully changed.', //283
'Email with congratulations has been send to user.', //284
'ZIP',// 285 Zip code
'Congratulations, 

Your status is changed to {0}. This privilegies will be available in next {1} month.

Now you can check your messages in your box.

__________________________________
{2}', //286 {0} - Ex:Gold member, {1} - month number, {2} - Sitename from config
'Congratulations', //287 Subject
'ZIP code must be numeric', //288
'Keywords', //289
'We are sorry, but the following error occurred:', //290
'', //291
'', //292
'', //293
'', //294
'', //295
'', //296
'', //297
'', //298
'' //299
); 
?>

