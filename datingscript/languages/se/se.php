<?php
############################################################
# \-\-\-\-\-\-\     AzDG  - S C R I P T S    /-/-/-/-/-/-/ #
############################################################
# AzDGDatingLite          Version 2.0.3                    #
# Writed by               AzDG (support@azdg.com)          #
# Created 03/01/03        Last Modified 05/02/03           #
# Scripts Home:           http://www.azdg.com              #
############################################################
# File name               sw.php                           #
# File purpose            Swedish language file            #
# File created by         Kaj Merstrand <kaj@kub.se>       #
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
'S�kerhetsfel - #', //1
'Den E-post adress du angav finns redan i v�r databas. V�lj en annan!', //2
'Namn m�ste vara {0} - {1} tecken', //3 - �ndra inte {0} and {1} - Se regel 2 !!!
'Efternamn m�ste vara {0} - {1} tecken', //4
'Felaktig f�delse data', //5
'Felaktigt l�senord. L�senord m�ste vara mellan {0} - {1} tecken', //6
'V�lj k�n', //7
'Please select seeking gender', //8
'V�lj vad f�r relation s�ker du', //9
'Ange ditt land', //10
'Felaktig e-post adress', //11
'Felaktig webbadress', //12
'Felaktigt ICQ nummer', //13
'Felaktig AIM', //14
'Fyll i telefonnummer', //15
'Fyll i Ort', //16
'Ange ditt civilst�nd', //17
'Ange om du har barn', //18
'Ange din l�ngd', //19
'Ange din vikt', //20
'Ange �nskad l�ngd', //21
'Ange �nskad vikt', //22
'Ange din h�rf�rg', //23
'Ange din �gonf�rg', //24
'Ange Etnisk h�rkomst', //25
'Ange religion', //26
'Ange �nskad etnisk h�rkomst', //27
'Ange �nskad religion', //28
'Ange om du r�ker', //29
'Ange alkoholvanor', //30
'Ange din utbildning', //31
'Ange yrke', //32
'Ange �nskad �lder', //33
'Ange hur du hittade oss', //34
'Ange din hobby', //35
'Felaktigt ifylld hobby. Hobby f�r inte inneh�lla mer �n {0} tecken', //36
'Felaktigt ifylld hobby. Hobby f�r inte inneh�lla mer �n {0} tecken', //37
'Ange en beskrivning om dig sj�lv', //38
'Felaktig beskrivning. Din beskrivning f�r inneh�lla max {0} tecken', //39
'Felaktig beskrivning. Din beskrivning f�r inneh�lla max {0} tecken', //40
'Ditt foto beh�vs!', //41
'Grattis! <br>Din registreringskod har skickats till din E-post adress. <br>Du m�ste aktivera din registrering via E-post meddelandet!', //42 - Message after register if need confirm by email
'Godk�nn din registrering', //43 - E-post bekr�ftelse
'Tack f�r din registrering hos Smygis Dating
Anv�nd denna l�nk f�r att aktivera din registrering:

', //44 - Confirm message
'Tack f�r din registrering. Din profil kommer att kontroleras inom 24 timmar. Bes�k oss och kontrollera att du kommit med. ', //45 - Din registrering �r nu godk�nd.
'Grattis! <br>Dina uppgifter har registrerats i v�r databas!<br><br>Ditt login id:', //46
'<br>Ditt l�senord:', //47
'Upprepa ditt l�senord', //48
'L�senorden �r inte lika', //49
'Registrering', //50
'Ditt namn', //51
'tecken', //52
'Efternamn', //53
'L�senord', //54
'Skriv l�senord igen', //55
'F�delsedata', //56
'K�n', //57
'F�rh�llande du s�ker', //58
'Land', //59
'E-post', //60
'Webbsida', //61
'ICQ', //62
'AIM', //63
'Telefon', //64
'Ort', //65
'Civilst�nd', //66
'Barn', //67
'L�ngd', //68
'Vikt', //69
'H�r f�rg', //70
'�gon F�rg', //71
'Etnisk h�rkomst', //72
'Religion', //73
'R�kare', //74
'Alkoholvanor', //75
'Utbildning', //76
'Arbete', //77
'Hobby', //78
'Beskriv dig sj�lv och vad du har f�r �nskem�l hos en blivande partner.', //79
'Jag s�ker', //80
'�nskad etnisk h�rkomst', //81
'�nskad religion', //82
'�nskad �lder', //83
'�nskad l�ngd', //84
'�nskad vikt', //85
'Hur hittade du oss?', //86
'Bild', //87
'Hem', //88
'Registrera', //89
'Medlems sida', //90
'S�k', //91
'Skicka �sikter till oss', //92
'Hj�lp', //93
'Statistik', //94
'Medlems sida ID#', //95
'L�s meddelande', //96
'Mitt sovrum', //97
'Min profil', //98
'�ndra profil', //99
'�ndra l�senord', //100
'Radera profil', //101
'Logga ut', //102
'Senaste uppdatering tog:', //103
'sek.', //104
'Anv�ndare online:', //105
'G�ster online:', //106
'Powered by <a href="http://www.azdg.com" target="_blank" class="desc">AzDG</a>', //107 - Don`t change link - only for translate - read GPL!!!
'Avancerad s�k funktion �r endast f�r registrerade anv�ndare', //108
'Tyv�rr, "�lder fr�n" m�ste vara l�gre �n "�lder till"', //109
'Tyv�rr hittade inget som motsvarar din s�kning', //110
'Ingen', //111 Picture available?
'Ja', //112 Picture available?
'Kan inte logga in till servern,<br>ditt mysql namn eller mysql l�senord �r felaktigt.<br>Kontrollera Konfigurations filen', //113
'Kan inte logga in till servern<br>Databasen finns inte<br>Kontrollera Konfigurations filen', //114
'Sidor :', //115
'S�k resultat', //116
'Totalt : ', //117 
'Anv�ndarnamn', //118
'Syfte', //119
'�lder', //120
'Land', //121
'Ort', //122
'Senaste tilltr�de', //123
'Registrerad den', //124
'Avancerad s�kning', //125
'Anv�ndar ID#', //126
'Nam', //127
'Efternamn', //128
'Stj�rntecken', //129
'L�ngd', //130
'Vikt', //131
'K�n', //132
'Typ av relation', //133
'Civilst�nd', //134
'Barn', //135
'H�rf�rg', //136
'�gonf�rg', //137
'Etnisk h�rkomst', //138
'Religion', //139
'R�ker', //140
'Dricker', //141
'Utbildning', //142
'S�k person med', //143
'Webbsida', //144
'ICQ', //145
'AIM', //146
'Telefon', //147
'Registerad i ', //148
'Sortera resultat efter', //149
'Resultat per sida', //150
'Standard s�kning', //151
'St�ngt, endast f�r medlemmar', //152
'St�ngt f�r att skicka d�liga profiler', //153
'Anv�ndaren finns redan i d�liga "svarta" listan', //154
'Tack, anv�ndaren har placerats i d�liga "svarta" listan och kommer att kontrolleras inom kort', //155
'St�ngt f�r att anv�nda sovrum', //156
'Personen finns redan i ditt sovrum', //157
'Personen har lagts till i ditt sovrum', //158
'Din profile lagts in f�r kontroll hos administrat�ren!', //159
'Din profil har lagts till i v�r databas', //160
'Fel vid aktivering av profil. Kanske den redan �r aktiverad', //161
'FAQ databasen �r tom', //162
'FAQ svar#', //163
'Alla f�lt m�ste vara ifyllda', //164
'Ditt meddelande har skickats', //165
'Ange din rubrik', //166
'Skriv ditt meddelande', //167
'Rubrik', //168
'Meddelande', //169
'Skicka meddelande', //170
'F�r medlemmar', //171
'Login ID', //172
'Gl�mt l�senord', //173
'Rekommendera oss', //174
'V�n-{0} E-post', //175
'Dagens f�delsedagar', //176
'Inga f�delsedagar', //177
'V�lkommen AzDGDating Site', //178 V�lkommen
'AzDGDatingLite - �r ett roligt s�tt att hitta nya v�nner eller partners, bara p� skoj, dating eller kanske till och med en l�ngvarig relation. M�ta och diskutera med olika m�nniskor �r alltid lika roligt. Men t�nk alltid p� att vara v�ldigt noga innan du m�ter en ok�nd person ansikte mot ansikte f�r f�rsta g�ngen..<br><br>Du kan lugnt och s�kert kommunicera med personer via v�rt skyddade E-post system, din riktiga E-post adress blir aldrig visad till n�gon annan. Detta ger dig bra m�jligheter att l�ra k�nna din nya v�n innan du l�mnar n�gra privata uppgifter.<br>', //179 Hj�rtligt v�lkommen till oss
'Senaste {0} registrerade anv�ndare', //180
'Snabb s�k', //181
'Avancerad s�kning', //182
'Dagens bild', //183
'Enkel statistik', //184
'Ditt ID m�ste best� av siffror', //185
'Felaktigt Login ID# eller l�senord', //186
'St�ngt f�r att skicka meddelanden till E-post', //187
'Skicka meddelande till E-post f�r anv�ndar ID#', //188
'Inga anv�ndare online', //189
'Rekommenderad sida �r inte tillg�nglig', //190
'H�lsningar fr�n {0}', //191 "Recommend Us" subject, {0} - username
'Hej fr�n {0}!

Hur m�r du:)

Bes�k denna sida - Kanon bra:
{1}', //192 "Recommend Us" message, {0} - username, {1} - site url
'Skriv r�tt namn p� din v�n#{0} email', //193
'Skriv ditt namn och E-post adress', //194
'Ditt l�senord fr�n {0}', //195 Reming password email subject
'Detta konto �r deaktiverat eller finns inte i v�r databas.<br>Skicka ett brev till administrat�ren via "skicka �sikt". V�nligen skriv med ditt ID ocks�.', //196
'Hej!

Ditt login ID#:{0}
Ditt l�senord:{1}

_________________________
{2}', //197 Remind password email message, Where {0} - ID, {1} - password, {2} - C_SNAME(sitename)
'Ditt l�senord har skickats till din E-post adress.', //198
'Skriv ditt ID', //199
'Skicka l�senord', //200
'Tillg�ng st�ngd f�r att skicka meddelande', //201
'Skicka meddelande till anv�ndar ID#', //202
'Meddela mig n�r mottagaren har l�st sitt meddelande', //203
'Ingen med det ID du angav i databasen', //204
'Statistik inte tillg�nglig', //205
'Detta ID existerar inte', //206
'Profil ID#', //207
'Anv�ndarens f�rstanamn', //208
'Anv�ndarens efternamn', //209
'F�delsedag', //210
'E-post', //211
'Besked fr�n AzDGDating', //212 - Subject for email
'Arbete', //213
'Hobby', //214
'Om', //215
'Popularitet', //216
'Skicka E-post', //217
'D�lig profil', //218
'L�gg till i mitt sovrum', //219
'Antingen s� var det ingen bild skickad, <br>eller s� var bilden du f�rs�kte skicka st�rre �n {0} Kb gr�nsen. Din bild �r {1} Kb', //220
'Filen du f�rs�kte skicka �r bredden st�rre �n {0} px eller h�jden st�rre �n {1} px gr�nsen.', //221
'Den bild du f�rs�kte skicka �r i fel format (endast jpg, gif och png �r till�tet). Din bild �r - ', //222
'(Max. {0} Kb)', //223
'Statistik �ver l�nder', //224
'Du har inga meddelanden', //225
'Total antal meddelanden - ', //226
'Nummer', //227 Number
'Fr�n', //228
'Datum', //229
'Radera', //230 Delete
'<sup>Ny</sup>', //231 New messages
'Radera valda meddelanden', //232
'Meddelande fr�n - ', //233
'Svara', //234
'Hej, du skrev {0}:\n\n_________________\n{1}\n\n_________________', //235 Reply to message {0} - date, {1} - message
'Ditt meddelande har l�sts av mottagaren', //236
'Ditt meddelande:<br><br><span class=dat>{0}</span><br><br>l�sts av {1} [ID#{2}] in {3}', //237 {0} - message, {1} - Username, {2} - UserID, {3} - Date and Time
'{0} Meddelande raderat!', //238
'Ange ditt gamla l�senord', //239
'Skriv nytt l�senord', //240
'Skriv l�senordet igen', //241
'�ndra l�senord', //242
'Gammalt l�senord', //243
'Nytt l�senord', //244
'Skriv det nya l�senorder igen', //245
'Du har inga anv�ndare i sovrummet', //246
'Tillf�ljelse datum', //247
'Radera valda anv�ndare', //248
'�r du s�ker p� att du vill radera din egen profil?<br>Alla dina meddelande och bilder kommer att raderas ur v�r databas, kan inte �terskapas.', //249
'Anv�ndare med ID#={0} har raderats ur v�r databas', //250
'Din  profil kommer att raderas n�r den kontrollerats av administrat�ren', //251
'{0} anv�ndare raderad fr�n ditt sovrum!', //252
'Inte identiska l�senord eller l�senordet inneh�ller felaktiga tecken', //253
'Du har inte beh�righet att �ndra l�senord', //254
'Gamla l�senordet �r felaktigt. G� tillbaka och f�rs�k igen!', //255
'L�senordet har �ndrats!', //256
'Inte m�jligt att radera alla bilder', //257
'Din profil �r �ndrad', //258
' - Radera bilder', //259
'Din session har avslutats. Du kan st�nga din browser', //260
'Flaggbilder inte tillg�ngliga', //261
'Spr�k', //262
'Enter', //263
'Login [3-16 chars [A-Za-z0-9_]]', //264
'Login', //265
'Your login must consist of 3-16 chars and only A-Za-z0-9_ chars is available', //266
'This is login already in database. Please select another!', //267
'Total users - {0}', //268
'The messages are not visible. You should be the privileged user see the messages.<br><br>You can purshase from <a href="'.C_URL.'/members/index.php?l=se&a=r" class=head>here</a>', //269 change l=default to l=this_language_name
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
