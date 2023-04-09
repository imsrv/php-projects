<?php 
############################################################
# \-\-\-\-\-\-\     AzDG  - S C R I P T S    /-/-/-/-/-/-/ #
############################################################
# AzDGDatingLite          Version 2.0.3                    #
# Writed by               AzDG (support@azdg.com)          #
# Created 03/01/03        Last Modified 05/02/03           #
# Scripts Home:           http://www.azdg.com              #
############################################################
# File name               gr_.php                          #
# File purpose            Addition to gr langfile          #
# File created by         Sofokli Magoula <admin@sympan.gr>#
############################################################

$wg=array(
'Αγνωστο', 
'Αντρας',
'Γυναίκα'
);

$wp=array(
'οτι προκύψει',
'για ρομαντική σχέση',
'για μακροχρόνια σχέση',
'για φιλία',
'για sex'
);

// Privileged users names
$wpu=array(
'Lite member', // Free user
'Silver member',
'Gold member',
'Platinum member');
// Privileged users timelife (in month)
$wpt=array(
'0', // Free user
'3',
'6',
'12');
// Payment for each member type in dollars
$wpm=array(
'0', // Free User
'19',
'29',
'39');


$wm=array(
'Δεν καθορίστηκε', 
'Μόνος',
'Διαζευγμένος',
'Σε διάσταση',
'Χήρος',
'Παντρεμένος'
);

$wmm=array(
'Δεν καθορίστηκε',
'Ιανουάριος',
'Φεβρουάριος',
'Μάρτιος',
'Απρίλιος',
'Μάιος',
'Ιούνιος',
'Ιούλιος',
'Αύγουστος',
'Σεπτέμβρης',
'Οκτώβρης', // [10]
'Νοέμβρης',
'Δεκέμβρης'
);

$wc=array(
'Δεν καθορίστηκε',
'Οχι',
'1',
'2',
'3',
'4',
'5 ή περισσότερα'
);

$wh=array(
'Δεν καθορίστηκε',
'4\'2\' (127cm)',
'4\'4\' (132cm)',
'4\'6\' (137cm)',
'4\'8\' (142cm)',
'4\'1\' (152cm)',
'5\'0\' (152cm)',
'5\'2\' (157cm)',
'5\'3\' (160cm)',
'5\'4\' (163cm)',
'5\'5\' (166cm)', // [10]
'5\'6\' (168cm)',
'5\'7\' (171cm)',
'5\'8\' (173cm)',
'5\'9\' (175cm)',
'5\'1\' (178cm)',
'6\'0\' (183cm)',
'6\'2\' (188cm)',
'6\'4\' (193cm)',
'6\'6\' (198cm)',
'6\'8\' (203cm)', // [20]
'6\'1\' (208cm)',
'7\'0\' (213cm)'
);

$ww=array(
'Δεν καθορίστηκε',
'80 lbs (36kg)',
'85 lbs (39kg)',
'90 lbs (41kg)',
'95 lbs (43kg)',
'100 lbs (45kg)',
'105 lbs (48kg)',
'110 lbs (50kg)',
'115 lbs (52kg)',
'120 lbs (54kg)',
'125 lbs (57kg)', // [10]
'130 lbs (59kg)',
'135 lbs (61kg)',
'140 lbs (63kg)',
'145 lbs (66kg)',
'150 lbs (68kg)',
'155 lbs (70kg)',
'160 lbs (73kg)',
'165 lbs (75kg)',
'170 lbs (77kg)',
'175 lbs (79kg)', // [20]
'180 lbs (82kg)',
'185 lbs (84kg)',
'190 lbs (86kg)',
'195 lbs (89kg)',
'200 lbs (91kg)',
'205 lbs (93kg)',
'210 lbs (95kg)',
'215 lbs (97kg)',
'220 lbs (100kg)',
'225 lbs (102kg)', // [30]
'230 lbs (104kg)',
'235 lbs (107kg)',
'240 lbs (109kg)',
'245 lbs (111kg)',
'250 lbs (113kg)',
'255 lbs (116kg)',
'260 lbs (118kg)',
'265 lbs (120kg)',
'270 lbs (122kg)',
'275 lbs (125kg)', // [40]
'280 lbs (127kg)',
'285 lbs (129kg)',
'290 lbs (131kg)',
'295 lbs (134kg)',
'300 lbs (136kg)'
);

$whc=array(
'Δεν καθορίστηκε',
'Black',
'Blonde',
'Brown',
'Brunette',
'Chestnut',
'Auburn',
'Dark-blonde',
'Golden',
'Red',
'Gray', // [10]
'Silver',
'White',
'Bald',
'Other'

);

$we=array(
'Δεν καθορίστηκε',
'Μαύρο',
'Καφετή',
'Μπλε',
'Πράσινος',
'Γκρίζος',
'Αλλο'
);

$wet=array(
'Δεν καθορίστηκε',
'White/Caucasion',
'Hispanic',
'Asian',
'African American/Black',
'Mixed',
'Other'

);

$wr=array(
'Δεν καθορίστηκε',
'Agnostic',
'Atheist',
'Baptist',
'Belief in God',
'Buddhist',
'Catholic',
'Christian',
'Eastern Orthodox',
'Humanist',
'Judaism', // [10]
'Lutheran',
'Mormon (LDS)',
'Muslim',
'New Age',
'Non-believer',
'Protestant',
'Other'

);

$ws=array(
'Δεν καθορίστηκε',
'Μη καπνιστής',
'Περιστασιακά',
'Τακτικά'
);

$wd=array(
'Δεν καθορίστηκε',
'Ποτέ ποτό',
'Περιστασιακά',
'Συχνά'
);

$wed=array(
'Δεν καθορίστηκε',
'Γυμνάσιο',
'Σπουδαστής κολλεγίου',
'Πανεπιστημιακός σπουδαστής',
'Πτυχιούχος κολλεγίου',
'Μεταπτυχιακός'
);

$wu=array(
'Δεν καθορίστηκε',
'Banner',
'Εφημερίδα',
'Τηλεόραση',
'Μηχανη αναζήτησης',
'Σύσταση φίλων',
'Αλλο'
);

$whr=array(
'Δεν καθορίστηκε',
'Αιγόκερος',
'Υδροχόος',
'Ιχθύς',
'Κριός',
'Ταύρος',
'Διδυμοι',
'Καρκίνος',
'Λέων',
'Παρθένος',
'Ζυγός', // [10]
'Σκορπιός',
'Τοξότης'
);

$wsb=array(
'Ημερομηνία φθίνουσα',
'Ημερομηνία αύξουσα',
'Ονομα φθίνουσα',
'Ονομα αυξουσα',
'Ηλικία φθίνουσα',
'Ηλικία αυξουσα',
'Υψος φθίνουσα',
'Υψος αυξουσα',
'Βάρος φθινουσα',
'Βάρος αυξουσα'
);
/* 
$wsb only for search - you can`t add new or remove - 
only translate!
*/

$wrg=array(
'Συνολικά',
'τελευταίες 7 μέρες',
'τελευταίος μήνας',
'τελευταίοι τρεις μήνες',
'τελευταίο ετος'
);

$wrgv=array(
'', // Not require enter this value for All period
'7', 
'31',
'92',
'365'
);


$wst=array(
'ολοι οι χρήστες',
'Αναμονή ελεγχου από mail',
'Αναμονή ελέγχου εγραφής',
'Αναμονη ελεγχου ανανέωσης',
'Αναμονή διαχειρηστη για διαγραφή',
'Ενεργοί χρήστες'
);

$wcr=array(
' Δεν ορίστικε', // First space is required for sorting
'Afghanistan',
'Albania',
'Algeria',
'Andorra',
'Angola',
'Antigua and arbuda',
'Argentina', 
'Armenia',
'Australia',
'Austria',
'Azerbaijan',
'Bahamas',
'Bahrain',
'Bangladesh',
'Barbados',
'Belarus', 
'Belgium',
'Bolivia',
'Bosnia and Herzegovina',
'Botswana',
'Brazil',
'Brunei Darussalam',
'Bulgaria',
'Burundi',
'Cambodia',
'Cameroon',
'Canada',
'Central African Republic',
'Chad',
'Chile',
'China',
'Colombia',
'Congo',
'Costa Rica',
'Ivory Coast',
'Croatia',
'Cuba',
'Cyprus',
'Czech Republic',
'Denmark',
'Dominican Republic',
'Ecuador',
'Egypt',
'El Salvador',
'Equatorial Guinea',
'Estonia',
'Ethiopia',
'Fiji',
'Finland',
'France',
'Gabon',
'Gambia',
'Georgia',
'Germany', 
'Ghana',
'Gibraltar',
'Greece',
'Greenland',
'Grenada',
'Guadeloupe',
'Guatemala',
'Guinea-Bissau',
'Guinea', 
'Guyana',
'Haiti',
'Honduras',
'Hong Kong',
'Hungary',
'Iceland',
'India',
'Indonesia',
'Iran', 
'Iraq',
'Ireland',
'Israel',
'Italy',
'Jamaica',
'Japan',
'Jordan',
'Kazakhstan',
'Kenya',
'North Korea',
'South Korea',
'Kuwait',
'Kyrgyzstan',
'Laos',
'Latvia',
'Lebanon',
'Lesotho',
'Liberia',
'Libya',
'Liechtenstein',
'Lithuania',
'Luxembourg',
'Macedonia',
'Madagascar',
'Malaysia',
'Mali', 
'Malta',
'Mauritania',
'Mexico',
'Moldova',
'Monaco', 
'Mongolia',
'Morocco',
'Mozambique',
'Namibia',
'Nepal',
'Netherlands', 
'New Zealand',
'Nicaragua',
'Nigeria',
'Niger',
'Norway',
'Oman', 
'Pakistan',
'Panama',
'Papua New Guinea',
'Paraguay',
'Peru',
'Philippines',
'Poland',
'Portugal', 
'Puerto Rico',
'Qatar',
'Romania',
'Russian Federation',
'Rwanda',
'Samoa',
'San Marino',
'Saudi Arabia',
'Senegal',
'Sierra Leone',
'Singapore',
'Slovak Republic',
'Slovenia', 
'Solomon Islands',
'Somalia',
'South Africa',
'Spain',
'Sri Lanka',
'Sudan',
'Swaziland',
'Sweden',
'Switzerland',
'Syria',
'Taiwan',
'Tajikistan',
'Tanzania',
'Thailand',
'Tunisia',
'Turkey',
'Turkmenistan',
'Uganda',
'Ukraine', 
'United Arab Emirates',
'United Kingdom',
'United States',
'Uruguay',
'Uzbekistan',
'Vatican City State',
'Venezuela',
'Viet Nam',
'Yemen',
'Yugoslavia',
'Zaire',
'Zambia',
'Zimbabwe' 
);
// No more 255 countries in this list!!!
// You can change this list to cities of your country
// Be carefull!
?>
