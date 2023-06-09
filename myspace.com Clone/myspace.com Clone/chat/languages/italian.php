<?
/*
           .������������,                                  .���������:     ,��������:
         ������������������                             .�������������� ,�������������
        ��������������������             D O N          ;��������������:���������������
        ���������������������                           ;����������������������������.
         ����������  ���������          �������;        .��������������� ����������;
         ,���������  ���������        �����������        ,�������������� ;��������;
          ��������� :���������      ��������������        ��������������;;��������
          ��������: ����������    .�������;;������;      :���������������;������.
         ���������������������   ;�������  .�������     .��������;�������;������
        :���������������������  ��������,,,��������    .��������  ��������������
        ���������������������� ;�������������������    ���������  ��������������
       ����������������������, ��������������������  .����������� ��������������:
     .����������������������� ��������������������  ������������� ��������������;
    ,����������������������� .�������������������� :������������� ��������������;
   ;�����������������������  :������������������� ,�������������� ��������������;
  ;�����������������������.  :�������������������:������������������������������;
 �����������������������;     ������������������ �������������������������������:
 ����������������������.      ����������������,  ���������������� ��������������
 ,����LiquidIce������          ��������������    ���������������  �������������
    .����������;                 ���������        .�����������    .����������,

*/

// special thanks to Giovanni Bassetto and Adriano for this translation!

$roomListMap = Array ( ); // refer to readme file for instructions on setting up a room language map

$badWords = Array ( );	// please see english.php to show how this array is set up

$language = Array(

"ttl1" => "On line",
"ttl2" => "Chat",
"ttl3" => "Benvenuto",
"ttl4" => "Messaggio:",
"ttl5" => "Font messaggi",
"ttl6" => "Font lista utenti",
"ttl7" => "chi c'� nella Chat?",
"ttl8" => "Utenti",
"ttl9" => "Crea una nuova stanza! Il nome della stanza pu� contenere solo caratteri alfanumerici (A-Z,a-z,0-9). Nome della stanza:",
"ttl10" => "Creando una stanza privata, ricordati di selezionare gli utenti a cui vuoi consentire l'accesso nella stanza (gli utenti riceveranno un invito ad entrarvi).",
"ttl11" => "Impostazioni audio",
"ttl12" => "Volume",
"ttl13" => "Bilanciamento",
"ttl17" => "Skins",

"opt4" => "N/A",
"opt6" => "Invita in una stanza privata...",
"opt7" => "Invia un messaggio in privato a...",
"opt8" => "Bandisci l'utente dalla stanza...",
"opt9" => "Bandisci l'utente da tutte le stanze...",
"opt10" => "Bandisci l'IP dell'utente...",
"opt11" => "Stanza privata",
"opt12" => "- Seleziona utente -",
"opt13" => "- Seleziona azione -",
"opt15" => "- Seleziona opzioni -",
"opt16" => "Chat",
"opt20" => "Opzioni video",
"opt21" => "Opzioni audio",
"opt22" => "Stanze pubbliche e private",
"opt23" => "Salva questa Chat",
"opt24" => "Help",
"opt25" => "Support Forum",
"opt26" => "- Opzioni -",
"opt27" => "Logout",

"btn1" => "Pausa",
"btn3" => "Invia",
"btn4" => "Colori predefiniti",
"btn5" => "Cancella i messaggi",
"btn6" => "Crea una nuova stanza",
"btn7" => "Esempio",
"btn8" => "Test",
"btn9" => "OK",

"rbn1" => "Metallico",
"rbn2" => "Bianco",
"rbn3" => "Acqua",
"rbn4" => "Oliva",
"rbn5" => "Blu",
"rbn6" => "Rosa",
"rbn7" => "Quercia",
"rbn8" => "Nero",
"rbn9" => "Il Testo dei titoli",
"rbn10" => "Lo Sfondo Principale",
"rbn11" => "Lo Sfondo dei bottoni",
"rbn12" => "I Bottoni",
"rbn13" => "Il Testo dei men�",
"rbn14" => "Lo Sfondo dei men�",
"rbn15" => "Il Testo principale",
"rbn16" => "Lo Sfondo del Testo",
"rbn17" => "Messaggi di Sistema",
"rbn18" => "Emoticons",
"rbn19" => "Ingresso nella Stanza",
"rbn20" => "Il Nome",
"rbn21" => "Gli Operatori",
"rbn22" => "Lo Sfondo dell'Operatore",
"rbn23" => "Crea stanza pubblica",
"rbn24" => "Crea stanza privata",

"chk1" => "Nascondi profilo",
"chk2" => "Suono di entrata in una stanza",
"chk3" => "Suono di uscita da una stanza",
"chk4" => "Suono di ricezione messaggio",
"chk5" => "Suono di invio messaggio",
"chk6" => "Nessun suono",
"msg1" => "Benvenuto nella Customer-care Chat, <name>!",
"msg2" => "Per inviare un messaggio di supporto, scegli il destinatario nel menu a tendina.",
"msg3" => "Non sono stati attivati i comandi speciali!",
"msg4" => "Un Operatore sar� presto a Tua disposizione. Se non ricevi risposta, per cortesia suona il campanello per attirare la nostra attenzione.",
"msg5" => "Nessuna risposta? Suona il campanello...",
"msg6" => "Benvenuto nella Chat, <name>!",
"msg7" => "La stanza <room> � al completo. Riprova pi� tardi.",
"msg8" => "(scrivi il Tuo messaggio qui e premi 'Invia')",
"msg9" => "Le spie non possono immettere di messaggi!",
"msg10" => "Seleziona un destinatario!",
"msg11" => "Non puoi inviare un messaggio a te stesso!",
"msg12" => "*** <name> sta suonando il campanello! ***",
"msg13" => "Invito ad una chat privata",
"msg14" => "Il tuo invito alla chat privata � stato inviato. Entra nella stanza privata <room> selezionandola dalla lista.",
"msg15" => "Nuova stanza pubblica",
"msg16" => "La nuova stanza pubblica <room> � stata creata e tutti sono stati avvertiti.",
"msg17" => "<name> ti invita ad una chat privata nella stanza <room>.",
"msg18" => "<name> ha creato una nuova stanza pubblica chiamata <room>.",
"msg19" => "Bandito",
"msg20" => "Bandito",
"msg21" => "<name> ti ha bandito da tutte le stanze. Effettua nuovamente il Login.",
"msg22" => "<name> � stato bandito da tutte le stanze.",
"msg23" => "<name> ti ha bandito dalla stanza <room>.",
"msg24" => "<name> ti ha bandito dalla Chat. Il tuo indirizzo IP � stato memorizzato per impedirti di rientrarvi.",
"msg25" => "<name> � stato bandito dalla Chat. Il suo indirizzo IP  � stato memorizzato per impedirgli di rientrarvi.",
"msg26" => "Richiedi aiuto",
"msg27" => "<name> ha richiesto aiuto.",
"msg28" => "Spiacenti, La Chat � al completo. Riprova pi� tardi.",
"msg29" => "Il nome della stanza pu� contenere solo caratteri alfanumerici.",
"msg30" => "Non puoi entrare nella Chat: il Tuo indirizzo IP, <ip>, � stato bloccato.",
"msg31" => "(moderatore)",
"msg34" => "Esiste gi� una stanza con questo nome.",
"msg35" => "Inserisci il nome per la nuova stanza.",
"msg36" => "<room> � stata aggiunta.",
"msg37" => "(in privato)",
"msg38" => "(moderato)",
"msg40" => "Privato da <name>",
"msg41" => "Messaggio per <name>",
"msg42" => "Messaggio privato per <name>",
"msg43" => "La Chat non � disponibile in questo momento.",
"msg50" => "� entrato",
"msg51" => "<name> � stato bandito dalla stanza <room>.",
"msg52" => "Il campanello sta suonando...",
"msg53" => "Sei uscito dalla Chat."

);

?>
