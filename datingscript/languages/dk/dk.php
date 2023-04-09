<?php
############################################################
# \-\-\-\-\-\-\     AzDG  - S C R I P T S    /-/-/-/-/-/-/ #
############################################################
# AzDGDatingLite          Version 2.0.3                    #
# Writed by               AzDG (support@azdg.com)          #
# Created 03/01/03        Last Modified 11/01/03           #
# Scripts Home:           http://www.azdg.com              #
############################################################
# File name               dk.php                           #
# File purpose            Danish language file             #
# File created by         S�ren Egelund <sde@tdcadsl.dk>   #
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
'Sikkerhedsfejl - #', //1
'Denne email er allerede i databasen. V�lg en anden!', //2
'Forkert fornavn. Fornavn skal v�re {0} - {1} karakterer', //3 - �ndrer {0} og {1} - se regl 2 !!!
'Forkert efternavn. Efternavn skal v�re {0} - {1} karakterer', //4
'Forkert f�dselsdato', //5
'Forkert kodeord. Kodeord skal v�re {0} - {1} karakterer', //6
'V�lg venligst dit k�n', //7
'V�lg k�n du s�ger efter', //8
'Enter your type of relation', //9
'V�lg venligst dit land', //10
'Forkert eller tom email', //11
'Forkert webside', //12
'Forkert ICQ nummer', //13
'Forkert AIM', //14
'Indtast telefonnummer', //15
'Indtast din by', //16
'V�lg din �gteskabelige status', //17
'V�lg venligst sp�rgsm�let omkring dine b�rn', //18
'V�lg din h�jde', //19
'V�lg din v�gt', //20
'V�lg den h�jde du s�ger efter', //21
'V�lg den v�gt du s�ger efter', //22
'V�lg h�rfarve', //23
'V�lg �jenfarve', //24
'V�lg etniskeoprindelse', //25
'V�lg religion', //26
'V�lg den etniskeoprindelse du s�ger efter', //27
'V�lg den religion du s�ger efter', //28
'Ryger du', //29
'Drikker du', //30
'V�lg uddannelse', //31
'Hvad er dit arbejde', //32
'Hvilken alder s�ger du', //33
'Hvordan fandt du os', //34
'Hvad er din hoppy', //35
'Ugyldig hobby beskrivelse. Hobby feltet skal v�re st�rre end {0} karakterer', //36
'Ugyldig hobby ordst�rrelse m� ikke v�re st�rre end {0} karakterer', //37
'Beskriv dig selv', //38
'Ugyldig. Beskrivelse m� ikke v�re st�rre end {0} karakterer', //39
'Ugyldig. Beskrivelse m� ikke v�re st�rre end {0} karakterer', //40
'Foto er p�kr�vet!', //41
'Tillykke! <br>Din aktiveringskode er sendt til din din email. <br>Du skal bekr�ft registrering p� email!', //42 - Message after register if need confirm by email

'Bekr�ft registrering', //43 - Mail bekr�ftelse
'Tak for du registrede dig p� vores side...
Tryk venligst her for at bekr�ft din registrering:

', //44 - Confirm message
'Thar for registreringen. din profil vil blive godkent om kort tid. Kom snart forbi igen...', //45 - Message after registering if admin allowing is needed
'Tillykke! <br>Din profil er blevet tilf�jet databasen!<br><br>Your login id:', //46
'<br>dit kodeord:', //47
'Genindtast kodeord', //48
'Kodeordene er ikke ens', //49
'Registrer bruger', //50
'Dit fornavn', //51
'karakterer', //52
'Dit efternavn', //53
'kodeord', //54
'Genindtast kodeord', //55
'F�dselesdag', //56
'K�n', //57
'Typen af bekendtskab', //58
'Land', //59
'Email', //60
'Webside', //61
'ICQ', //62
'AIM', //63
'Telefon', //64
'By', //65
'�gteskabelig status', //66
'B�rn', //67
'H�jde', //68
'V�gt', //69
'H�rfarve', //70
'�jenfarve', //71
'Etniskoprindelse', //72
'Religion', //73
'Ryger', //74
'Drikker', //75
'Uddannelse', //76
'Job', //77
'Hobby', //78
'Beskriv dig selv og den person du s�ger som potientiel partner.', //79
'S�ger efter', //80
'S�ger efter f�lgende etniskeoprindelse', //81
'S�ger efter person med f�lgende religion', //82
'S�ger efter alder', //83
'S�ger efter h�jde', //84
'S�ger efter v�gt', //85
'Hvordan fandt du os?', //86
'Foto', //87
'Hjem', //88
'Registrer', //89
'Medlemsomr�de', //90
'S�g', //91
'Tilbagemelding', //92
'FAQ', //93
'Statistiker', //94
'Medlems menuID#', //95
'Se beskeder', //96
'Mit sovev�relse', //97
'Min profil', //98
'�ndre profil', //99
'�ndre kodeord', //100
'Fjern profil', //101
'Afslut', //102
'Bearbejdelses tid:', //103
'sek.', //104
'Brugere online:', //105
'S�gning online:', //106
'Powered by <a href="http://www.azdg.com" target="_blank" class="desc">AzDG</a>', //107 - Don`t change link - only for translate - read GPL!!!
'Kun registrerede brugere kan bruge avanceret s�gning', //108
'Fejl, "Alder fra" skal v�re mindre end "Alder til"', //109
'Din s�gningen gav desv�rre intet resultat', //110
'Ingen', //111 Billeder tilg�ngelig?
'Ja', //112 Billede tilg�ngeligt?
'Kan ikke tilkoble server<br>Dit mysql login eller mysql kodeord er forkert.<br>Kontroller det i config fil', //113
'Kan ikke tilkoble server<br>Database eksisterer ikke<br>Eller �ndrer Database navn i config', //114
'Sider :', //115
'S�ge resultater', //116
'Total : ', //117 
'Brugernavn', //118
'Form�l', //119
'Alder', //120
'Land', //121
'By', //122
'Sidste login', //123
'Registreringsdato', //124
'Avanceret s�gning', //125
'Bruger ID#', //126
'Fornavn', //127
'Efternavn', //128
'Stjernetegn', //129
'H�jde', //130
'V�gt', //131
'K�n', //132
'Typen af bekendtskab', //133
'�gteskabelig status', //134
'B�rn', //135
'H�rfarve', //136
'�jenfarve', //137
'Etniskoprindelse', //138
'Religion', //139
'Ryger', //140
'Drikker', //141
'Uddannelse', //142
'S�g efter bruger med', //143
'Webside', //144
'ICQ', //145
'AIM', //146
'Telefon', //147
'Registreret i', //148
'Sorter resultat efter', //149
'Resultater p� side', //150
'Simpel s�gning', //151
'Adgang lukket for ikke medlemmer', //152
'Adgang lukket for at sende d�rlige profiler', //153
'Bruger er allerede i d�rlig profil database', //154
'Tak, Bruger er tilf�jet til d�rlige profiler og vil blive undes�gt af admin om kort tid', //155
'Adgang lukket til sovev�relse', //156
'Bruger er allerede i sovev�relse', //157
'Tak, Bruger er tilf�jet sovev�relse', //158
'Din profil er blevet tilf�jet til admin unders�gelse!', //159
'Din profil er blevet tilf�jet databasen', //160
'Profil aktiveringsfejl. Er m�ske allerede aktiv', //161
'FAQ database er tom', //162
'FAQ svar#', //163
'Alle felter skal udfyldes', //164
'Din besked er sendt', //165
'Skriv emne', //166
'Skriv besked', //167
'emne', //168
'besked', //169
'Send besked', //170
'For medlemmer', //171
'Login ID', //172
'Glemt kodeord', //173
'Anbefal os', //174
'Ven-{0} email', //175
'F�dselsdage idag', //176
'Ingen f�dselsdage', //177
'Velkommen til vores AzDGDating Side', //178 Welcome message header
'AzDGDatingLite - Er en god vej til at finde nye venner eller partner, for sk�g, dating og l�ngerevarende forhold. At m�de og l�re hinanden at kende her er b�de sk�gt og sikkert. Man b�r duog bruge sin almindelige sunde fornuft f�rste gang man �nsker at arrangerer et m�de ansigt til ansigt f�rste gang.<br><br>Du kan ogs� m�de nye venner gennem vores eget email system. Gennem dette kan du kommunikere med andre medlemmer og l�re dem at kende og udvikle nye bekendtskaber.<br>', //179 Welcome message
'Sidst {0} registrerde brugere', //180
'Hurtig s�gning', //181
'Adv. s�gning', //182
'Dagens foto', //183
'Simple Statistiker', //184
'Dit ID skal v�re numerisk', //185
'Forker Login ID# eller kodeord', //186
'Adgang lukket for afsendelse ag beskeder til email', //187
'Send besked til email bruger ID#', //188
'Ingen brugere online', //189
'Anbefal side ikke tilg�ngelig', //190
'Hilsner fra {0}', //191 "Recommend Us" subject, {0} - username
'Hallo fra {0}!

Hvordan har du det:)

Bes�g denne side - den er god:
{1}', //192 "Recommend Us" message, {0} - username, {1} - site url
'Skriv venligst korrekt navn p� ven#{0} email', //193
'Skriv venligst navn og E-mail', //194
'Dit kodeord fra {0}', //195 Reming password email subject
'Denne konto er deaktiveret eller eksisterer ikke i database.<br>Skriv venligst til admin om dette problem. Inkluder venligst ID.', //196
'Hallo!

Dit login ID#:{0}
Dit Kodeord:{1}

_________________________
{2}', //197 Remind password email message, Where {0} - ID, {1} - password, {2} - C_SNAME(sitename)
'Dit kodeord er sendt til din email.', //198
'Indtast venlist din ID', //199
'Send kodeord', //200
'Adgang lukket for at sende beskeder', //201
'Send besked til bruger ID#', //202
'Giv mig besked n�r bruger har l�st besked', //203
'Ingen brugere database', //204
'Statistiker ikke tilg�ngelige', //205
'Den ID eksisterer ikke', //206
'Profil ID#', //207
'Brugers Fornavn', //208
'Brugers Efternavb', //209
'F�dselsdag', //210
'Email', //211
'Besked fra AzDGDating', //212 - Subject for email
'Job', //213
'Hobby', //214
'Om', //215
'Popularitet', //216
'Send email', //217
'Forkert profil', //218
'Tilf�j til mit sovev�relse', //219
'Enten var ingen fil uploaded, <br>Eller ogs� var filen du pr�vede at uploade st�rre end {0} Kb begr�nsningen. Din fil er {1} Kb', //220
'Filen du pr�vede at upload var bredere end {0} px Eller h�jere end de {1} px begr�nsningen.', //221
'Filende du pr�vede at uploade var af forkert type (kun jpg, gif og png kan benyttes). Din type - ', //222
'(Max. {0} Kb)', //223
'Statistik p� lande', //224
'Du har ingen beskeder', //225
'Total antal af beskeder - ', //226
'Nummer', //227 Number
'Fra', //228
'Dato', //229
'Slet', //230 Delete
'<sup>Ny</sup>', //231 New messages
'Slet valgte beskeder', //232
'Besked fra - ', //233
'Svar', //234
'Hallo, Du skrev {0}:\n\n_________________\n{1}\n\n_________________', //235 Reply to message {0} - date, {1} - message
'Din besked er blevet l�st', //236
'Din besked:<br><br><span class=dat>{0}</span><br><br>er l�st af {1} [ID#{2}] in {3}', //237 {0} - message, {1} - Username, {2} - UserID, {3} - Date and Time
'{0} beskeder slettet!', //238
'Skriv gammelt kodeord', //239
'Skriv nyt kodeord', //240
'Skriv nyt kodeord igen', //241
'�ndre kodeord', //242
'Gammelt kodeord', //243
'Nyt kodeord', //244
'Skriv nyt kodeord igen', //245
'Du har ingen brugere i sovev�relset', //246
'Tilf�jelses dato', //247
'Slet valgte brugere', //248
'Er du sikker p� at du vil slette din egen profil?<br>Alle dine beskeder, billeder vil blive fjernet fra databasen.', //249
'Bruger med ID#={0} Er blevet slettet fra databasen', //250
'Din profil vil blive slettet efter admin sikkerhedscheck', //251
'{0} Brugere fjernet fra dit sovev�relse!', //252
'Ikke identiske kodeord eller indeholder forkerte karakterer', //253
'Du har ikke adgang til at �ndre kodeord', //254
'Forkert gammelt kodeord. G� tilbage og skriv det igen!', //255
'Kodeord �ndret!', //256
'Det er ikke muligt at fjerne alle billeder', //257
'Din profil er �ndret', //258
' - Slet billede', //259
'Din session er blevet afsluttet. du kan slukke din browser', //260
'Flagbilleder ikke tilg�ngelige', //261
'Sprog', //262
'Enter', //263
'Login [3-16 chars [A-Za-z0-9_]]', //264
'Login', //265
'Your login must consist of 3-16 chars and only A-Za-z0-9_ chars is available', //266
'This is login already in database. Please select another!', //267
'Total users - {0}', //268
'The messages are not visible. You should be the privileged user see the messages.<br><br>You can purshase from <a href="'.C_URL.'/members/index.php?l=dk&a=r" class=head>here</a>', //269 change l=default to l=this_language_name
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
