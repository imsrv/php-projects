package AUt; use strict; 
# <<----Autoresponder/Majordomo/etc options ( LIST TYPE 5 )---->>
# Edit ONLY BETWEEN the single quotes '.......'
sub specs {

## ADDING Address From for e-mail - ( see readme for options )--#
my $ADDadrs = 'foosub@dtp-aus.com';

## ADDING Subject line of e-mail - ( see readme for options )---#
my $ADDsubject = 'subscribe <%%ADDRS%%>';

## ADDING Body text of e-mail - ( see readme for options )------#
my $ADDbody = 'Subscribe <%%ADDRS%%>
body text - if required. Use this marker to insert address 
IF needed. Also in subject line IF needed.';

## UNSUB Address From for e-mail - ( see readme for options )---#
my $UNSadrs = 'fooUNsub@dtp-aus.com';

## UNSUB Subject line of e-mail - ( see readme for options )----#
my $UNSsubject = 'unsubscribe <%%ADDRS%%>';

## UNSUB Body text of e-mail - ( see readme for options )-------#
my $UNSbody = 'UN-Subscribe <%%UNADDRS%%>
body text - if required. Use this marker to insert address 
IF needed. Also in subject line IF needed.';

return ($ADDadrs,$ADDsubject,$ADDbody,$UNSadrs,$UNSsubject,$UNSbody); 
}
1;

