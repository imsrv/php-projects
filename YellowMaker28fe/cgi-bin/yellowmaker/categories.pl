#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# categories.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
do "config2.pl";
do "variable.pl";
do "sub.pl";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}

&parse_form;

&header;
&top;

$adsubcatimagefile="$homedir/$sub10/$sub11/$form{'sub'}.gif";
$adsubcatimage="$home/$sub10/$sub11/$form{'sub'}.gif";
if (-e $adsubcatimagefile) {
$adsubcatval=1;
}
$adsubcatfile="$sub10/$sub11/$form{'sub'}.txt";
if (-e $adsubcatfile) {
open(ADSUBCATFILE, "<$adsubcatfile") || return 0;
foreach $line (<ADSUBCATFILE>) {
$line =~ s/^\s+//;
$line =~ s/\s+$//;
$adsubcaturl=$line;
}
close ADSUBCATFILE;
}

if ($adsubcatval) {
if ($adsubcaturl) {
$adsubcat="<div align=\"center\"><center><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td width=\"100%\" height=\"15\"></td></tr><tr><td width=\"100%\"><p align=\"center\"><font face=\"$font\" size=\"$size\" color=\"#000000\"><a href=\"$adsubcaturl\"><img src=\"$adsubcatimage\" border=\"0\" width=\"640\" height=\"60\"></a></font></td></tr><tr><td width=\"100%\" height=\"20\"></td></tr></table></center></div>";
} else {
$adsubcat="<div align=\"center\"><center><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td width=\"100%\" height=\"15\"></td></tr><tr><td width=\"100%\"><p align=\"center\"><font face=\"$font\" size=\"$size\" color=\"#000000\"><img src=\"$adsubcatimage\" border=\"0\" width=\"640\" height=\"60\"></font></td></tr><tr><td width=\"100%\" height=\"20\"></td></tr></table></center></div>";
}
}

$no1=0;$no2=0;$no3=0;$no4=0;$no5=0;$no6=0;$no7=0;$no8=0;$no9=0;$no10=0;
$no11=0;$no12=0;$no13=0;$no14=0;$no15=0;$no16=0;$no17=0;$no18=0;$no19=0;
$no20=0;$no21=0;$no22=0;$no23=0;$no24=0;$no25=0;$no26=0;$no27=0;$no28=0;$no29=0;$no30=0;$no31=0;$no32=0;$no33=0;$no34=0;$no35=0;$no36=0;$no37=0;

if ($form{'sub'} eq "1") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;

if ($category eq "Amusement Places") {$no1+=1;} 
if ($category eq "Art Galleries, Dealers & Consultants") {$no2+=1;} 
if ($category eq "Bars") {$no3+=1;}
if ($category eq "Book Dealers Retail") {$no4+=1;} 
if ($category eq "Casinos") {$no5+=1;}
if ($category eq "Cinemas") {$no6+=1;}
if ($category eq "Clubs") {$no7+=1;}
if ($category eq "Comic Books") {$no8+=1;}
if ($category eq "Dance Clubs") {$no9+=1;}
if ($category eq "Entertainers") {$no10+=1;}
if ($category eq "Magazines Dealers") {$no11+=1;}
if ($category eq "Museums") {$no12+=1;}
if ($category eq "Music Instruction Instrucmental") {$no13+=1;}
if ($category eq "Music Records, Compact Discs & Tape Retails") {$no14+=1;}
if ($category eq "Newspapers") {$no15+=1;}
if ($category eq "Night Clubs") {$no16+=1;}
if ($category eq "Orchestras & Bands") {$no17+=1;}
if ($category eq "Party Planning Service") {$no18+=1;}
if ($category eq "Party Supplies") {$no19+=1;}
if ($category eq "Photographers Portrait") {$no20+=1;}
if ($category eq "Pubs") {$no21+=1;}
if ($category eq "Radio Station & Broadcasting Companies") {$no22+=1;}
if ($category eq "Stamps For Collectors") {$no23+=1;}
if ($category eq "Television Station & Broadcasting Companies") {$no24+=1;}
if ($category eq "Theatres") {$no25+=1;}
if ($category eq "Ticket Sales Entertainment & Sports") {$no26+=1;}
if ($category eq "Video Discs & Tapes Rentals & Sales") {$no27+=1;}
if ($category eq "Video Games Retail") {$no28+=1;}
if ($category eq "Video Production") {$no29+=1;}
if ($category eq "Video Tape Duplication Service") {$no30+=1;}
if ($category eq "Zoos") {$no31+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22+$no23+$no24+$no25+$no26+$no27+$no28+$no29+$no30+$no31;
&include("/$sub/$sub9/c1.htm");
}

if ($form{'sub'} eq "2") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Automobile & Truck Drive Away Service") {$no1+=1;} 
if ($category eq "Automobile Antique & Classic Cars") {$no2+=1;} 
if ($category eq "Automobile Body Repairing & Painting") {$no3+=1;}
if ($category eq "Automobile Brokers") {$no4+=1;} 
if ($category eq "Automobile Dealers New Cars") {$no5+=1;}
if ($category eq "Automobile Dealers Used Cars") {$no6+=1;}
if ($category eq "Automobile Kits") {$no7+=1;}
if ($category eq "Automobile Leasing") {$no8+=1;}
if ($category eq "Automobile Parts & Supplies New") {$no9+=1;}
if ($category eq "Automobile Parts & Supplies Used & Rebuilt") {$no10+=1;}
if ($category eq "Automobile Renting") {$no11+=1;}
if ($category eq "Automobile Repairing & Service") {$no12+=1;}
if ($category eq "Boat Dealers") {$no13+=1;}
if ($category eq "Boat Equipment & Supplies") {$no14+=1;}
if ($category eq "Car Washing & Polishing") {$no15+=1;}
if ($category eq "Motorcycles & Motor Scooters") {$no16+=1;}
if ($category eq "Recreational Vehicles Renting & Leasing") {$no17+=1;}
if ($category eq "Recreational Vehicles Sales & Service") {$no18+=1;}
if ($category eq "Tire Dealers Retail") {$no19+=1;}
if ($category eq "Tire Dealers Used") {$no20+=1;}
if ($category eq "Tire Repair") {$no21+=1;}
if ($category eq "Towers") {$no22+=1;}
if ($category eq "Trailers Truck") {$no23+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22+$no23;
&include("/$sub/$sub9/c2.htm");
}

if ($form{'sub'} eq "3") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Accountants Public") {$no1+=1;} 
if ($category eq "Accountants Registered Public") {$no2+=1;} 
if ($category eq "Advertising Agencies & Counsellors") {$no3+=1;}
if ($category eq "Architects") {$no4+=1;} 
if ($category eq "Associations") {$no5+=1;}
if ($category eq "Auctioneers") {$no6+=1;}
if ($category eq "Bookkeeping Service") {$no7+=1;}
if ($category eq "Business & Trade Organization") {$no8+=1;}
if ($category eq "Business Brokers") {$no9+=1;}
if ($category eq "Business Consultants") {$no10+=1;}
if ($category eq "Business Valuators") {$no11+=1;}
if ($category eq "Convention Services & Facilities") {$no12+=1;}
if ($category eq "Courier Service") {$no13+=1;}
if ($category eq "Display Designers & Producers") {$no14+=1;}
if ($category eq "Employment Agencies") {$no15+=1;}
if ($category eq "Engineers") {$no16+=1;}
if ($category eq "Event Planning") {$no17+=1;}
if ($category eq "Exporters") {$no18+=1;}
if ($category eq "Importers") {$no19+=1;}
if ($category eq "Investigators") {$no20+=1;}
if ($category eq "Lawyers") {$no21+=1;}
if ($category eq "Management Consultants") {$no22+=1;}
if ($category eq "Market Research & Analysis") {$no23+=1;}
if ($category eq "Notaries") {$no24+=1;} 
if ($category eq "Printing Supplies") {$no25+=1;} 
if ($category eq "Publishers' Services") {$no26+=1;}
if ($category eq "Safety Consultants") {$no27+=1;} 
if ($category eq "Secretarial Services") {$no28+=1;}
if ($category eq "Security Guard & Patrol Service") {$no29+=1;}
if ($category eq "Transport Services") {$no30+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22+$no23+$no24+$no25+$no26+$no27+$no28+$no29+$no30;
&include("/$sub/$sub9/c3.htm");
}

if ($form{'sub'} eq "4") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Bridal Shops") {$no1+=1;} 
if ($category eq "Children's & Infants' Wear Retail") {$no2+=1;} 
if ($category eq "Clothing & Accessories Retail Men") {$no3+=1;}
if ($category eq "Clothing & Accessories Retail Women") {$no4+=1;} 
if ($category eq "Cosmetics & Perfumes Retail") {$no5+=1;}
if ($category eq "Fabric Shops") {$no6+=1;}
if ($category eq "Formal Wear Rental") {$no7+=1;}
if ($category eq "Handbags Repairing") {$no8+=1;}
if ($category eq "Handbags Retail") {$no9+=1;}
if ($category eq "Hats Retail") {$no10+=1;}
if ($category eq "Jeans Retail") {$no11+=1;}
if ($category eq "Leather") {$no12+=1;}
if ($category eq "Lingerie Retail") {$no13+=1;}
if ($category eq "Luggage Repairing") {$no14+=1;}
if ($category eq "Luggage Retail") {$no15+=1;}
if ($category eq "Maternity Apparel") {$no16+=1;}
if ($category eq "Men's Clothing & Furnishings Retail") {$no17+=1;}
if ($category eq "Shoe Repairing") {$no18+=1;}
if ($category eq "Shoes Retail") {$no19+=1;}
if ($category eq "Sportswears Retail") {$no20+=1;}
if ($category eq "Swimwear & Accessories Retail") {$no21+=1;}
if ($category eq "T-shirts Retail") {$no22+=1;}
if ($category eq "Tailors") {$no23+=1;}
if ($category eq "Uniform Rental Service") {$no24+=1;} 
if ($category eq "Uniforms") {$no25+=1;} 
if ($category eq "Western Apparel") {$no26+=1;}
if ($category eq "Women's Apparel Retail") {$no27+=1;} 
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22+$no23+$no24+$no25+$no26+$no27;
&include("/$sub/$sub9/c4.htm");
}

if ($form{'sub'} eq "5") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Cemeteries") {$no1+=1;} 
if ($category eq "Children's Services & Activities Information") {$no2+=1;} 
if ($category eq "Clubs") {$no3+=1;}
if ($category eq "Embassies") {$no4+=1;} 
if ($category eq "Government County") {$no5+=1;}
if ($category eq "Government Federal") {$no6+=1;}
if ($category eq "Government Municipal") {$no7+=1;}
if ($category eq "Government Provincial") {$no8+=1;}
if ($category eq "Government Regional") {$no9+=1;}
if ($category eq "Government Relations Consultants") {$no10+=1;}
if ($category eq "Libraries Public") {$no11+=1;}
if ($category eq "Parks") {$no12+=1;}
if ($category eq "Police Emergency Calls") {$no13+=1;}
if ($category eq "Political Organizations") {$no14+=1;}
if ($category eq "Post Offices") {$no15+=1;}
if ($category eq "Religious Organizations") {$no16+=1;}
if ($category eq "Senior Citizens Services & Centers") {$no17+=1;}
if ($category eq "Social Service Organizations") {$no18+=1;}
if ($category eq "Youth Organizations & Centers") {$no19+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19;
&include("/$sub/$sub9/c5.htm");
}

if ($form{'sub'} eq "6") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Cellular Telephones") {$no1+=1;} 
if ($category eq "Computer Consultants") {$no2+=1;} 
if ($category eq "Computer Graphics") {$no3+=1;}
if ($category eq "Computer Networking") {$no4+=1;} 
if ($category eq "Computer Renting & Leasing") {$no5+=1;}
if ($category eq "Computer Repairs, Cleaning & Service") {$no6+=1;}
if ($category eq "Computer Software") {$no7+=1;}
if ($category eq "Computer Supplies & Accessories") {$no8+=1;}
if ($category eq "Computer Training") {$no9+=1;}
if ($category eq "Data Communication Systems & Service") {$no10+=1;}
if ($category eq "Data Processing Service") {$no11+=1;}
if ($category eq "Desktop Publishing") {$no12+=1;}
if ($category eq "Internet Product & Service Providers") {$no13+=1;}
if ($category eq "Multimedia") {$no14+=1;}
if ($category eq "Photographic Equipment & Systems") {$no15+=1;}
if ($category eq "Radio Sales & Service") {$no16+=1;}
if ($category eq "Radio Supplies & Parts Retail") {$no17+=1;}
if ($category eq "Telephone Companies") {$no18+=1;}
if ($category eq "Telephone Equipment & Systems") {$no19+=1;}
if ($category eq "Telephone Installation & Repair Service") {$no20+=1;}
if ($category eq "Television Sales & Service") {$no21+=1;}
if ($category eq "Television Supplies & Parts Retail") {$no22+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22;
&include("/$sub/$sub9/c6.htm");
}

if ($form{'sub'} eq "7") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Aircraft Schools") {$no1+=1;} 
if ($category eq "Art Schools") {$no2+=1;} 
if ($category eq "Arts & Crafts Schools") {$no3+=1;}
if ($category eq "Beauty Institutes") {$no4+=1;} 
if ($category eq "Boating & Sailing Instruction") {$no5+=1;}
if ($category eq "Bowling Instruction") {$no6+=1;}
if ($category eq "Boxing Instruction") {$no7+=1;}
if ($category eq "Career Counselling") {$no8+=1;}
if ($category eq "Dancing Instruction") {$no9+=1;}
if ($category eq "Driving Instruction") {$no10+=1;}
if ($category eq "Flower Arranging Instruction") {$no11+=1;}
if ($category eq "Golf Instruction") {$no12+=1;}
if ($category eq "Hockey Instruction") {$no13+=1;}
if ($category eq "Libraries Public") {$no14+=1;}
if ($category eq "Martial Arts & Self Defense Instruction") {$no15+=1;}
if ($category eq "Photography Schools") {$no16+=1;}
if ($category eq "Public Speaking Instruction") {$no17+=1;}
if ($category eq "Schools Academic Colleges & Universities") {$no18+=1;}
if ($category eq "Schools Academic Elementary & Secondary") {$no19+=1;}
if ($category eq "Schools Academic Nursery & Kindergarten") {$no20+=1;}
if ($category eq "Schools Academic Special Purpose") {$no21+=1;}
if ($category eq "Schools Cooking") {$no22+=1;}
if ($category eq "Schools Correspondence") {$no23+=1;}
if ($category eq "Schools Dramatic Art & Speech") {$no24+=1;}
if ($category eq "Schools Hairdressing") {$no25+=1;}
if ($category eq "Schools Language") {$no26+=1;}
if ($category eq "Schools Modelling") {$no27+=1;}
if ($category eq "Schools Nursing") {$no28+=1;}
if ($category eq "Schools Reading Improvement") {$no29+=1;}
if ($category eq "Schools Special Purpose") {$no30+=1;}
if ($category eq "Schools Technical & Trade") {$no31+=1;}
if ($category eq "Skating Instruction") {$no32+=1;}
if ($category eq "Skiing Instruction") {$no33+=1;}
if ($category eq "Swimming Instruction") {$no34+=1;}
if ($category eq "Tennis Instruction") {$no35+=1;}
if ($category eq "Tutoring") {$no36+=1;}
if ($category eq "Yoga Instruction") {$no37+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22+$no23+$no24+$no25+$no26+$no27+$no28+$no29+$no30+$no31+$no32+$no33+$no34+$35+$no36+$no37;
&include("/$sub/$sub9/c7.htm");
}

if ($form{'sub'} eq "8") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Adoption Services") {$no1+=1;} 
if ($category eq "Children's Services & Activities Information") {$no2+=1;} 
if ($category eq "Cleaners") {$no3+=1;}
if ($category eq "Day Care Centers & Nurseries") {$no4+=1;} 
if ($category eq "Funeral Escort Service") {$no5+=1;}
if ($category eq "Funeral Homes") {$no6+=1;}
if ($category eq "Funeral Planning") {$no7+=1;}
if ($category eq "House & Apartment Cleaning") {$no8+=1;}
if ($category eq "House Sitters") {$no9+=1;}
if ($category eq "Laundries") {$no10+=1;}
if ($category eq "Pet Foods & Supplies Retail") {$no11+=1;}
if ($category eq "Pet Grooming Clipping & Washing") {$no12+=1;}
if ($category eq "Pet Shops") {$no13+=1;}
if ($category eq "Pet Sitting Services") {$no14+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14;
&include("/$sub/$sub9/c8.htm");
}

if ($form{'sub'} eq "9") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Baby Foods") {$no1+=1;} 
if ($category eq "Bakers Retail") {$no2+=1;} 
if ($category eq "Beer & Ale") {$no3+=1;}
if ($category eq "Beverage Dealers Retail") {$no4+=1;} 
if ($category eq "Brewers") {$no5+=1;}
if ($category eq "Cafes") {$no6+=1;}
if ($category eq "Candy & Confectionery Retail") {$no7+=1;}
if ($category eq "Caterers") {$no8+=1;}
if ($category eq "Cheese") {$no9+=1;}
if ($category eq "Coffee Houses") {$no10+=1;}
if ($category eq "Convenience Stores") {$no11+=1;}
if ($category eq "Dairies") {$no12+=1;}
if ($category eq "Delicatessens") {$no13+=1;}
if ($category eq "Donuts") {$no14+=1;}
if ($category eq "Fish & Chips") {$no15+=1;}
if ($category eq "Fish Meals & Oils") {$no16+=1;}
if ($category eq "Fish Seafood Retail") {$no17+=1;}
if ($category eq "Food Products") {$no18+=1;}
if ($category eq "Fruits & Vegetables Retail") {$no19+=1;}
if ($category eq "Gourmet Shops") {$no20+=1;}
if ($category eq "Grocers Retail") {$no21+=1;}
if ($category eq "Health Foods Retail") {$no22+=1;}
if ($category eq "Ice Cream & Frozen Desserts Retail") {$no23+=1;}
if ($category eq "Liquor & Food Delivery Service") {$no24+=1;} 
if ($category eq "Liquor Stores") {$no25+=1;} 
if ($category eq "Meat Brokers") {$no26+=1;}
if ($category eq "Pizza") {$no27+=1;} 
if ($category eq "Poultry Retail") {$no28+=1;}
if ($category eq "Restaurants") {$no29+=1;}
if ($category eq "Sandwiches") {$no30+=1;}
if ($category eq "Wineries") {$no31+=1;}
if ($category eq "Yogurt") {$no32+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22+$no23+$no24+$no25+$no26+$no27+$no28+$no29+$no30+$no31+$no32;
&include("/$sub/$sub9/c9.htm");
}

if ($form{'sub'} eq "10") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Acupuncturists") {$no1+=1;} 
if ($category eq "Ambulance Service") {$no2+=1;} 
if ($category eq "Clinics") {$no3+=1;}
if ($category eq "Clinics Dental") {$no4+=1;} 
if ($category eq "Clinics Medical") {$no5+=1;}
if ($category eq "Dentists") {$no6+=1;}
if ($category eq "Exercising Equipment") {$no7+=1;}
if ($category eq "Health Care & Hospital Consultants") {$no8+=1;}
if ($category eq "Health Clubs") {$no9+=1;}
if ($category eq "Health Service") {$no10+=1;}
if ($category eq "Hospitals") {$no11+=1;}
if ($category eq "Medical Information Service") {$no12+=1;}
if ($category eq "Medical Service Organizations") {$no13+=1;}
if ($category eq "Mental Health Services") {$no14+=1;}
if ($category eq "Optical Laboratories") {$no15+=1;}
if ($category eq "Pharmacies") {$no16+=1;}
if ($category eq "Physiotherapists") {$no17+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17;
&include("/$sub/$sub9/c10.htm");
}

if ($form{'sub'} eq "11") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Air Conditioning Contractors") {$no1+=1;} 
if ($category eq "Bathroom Accessories") {$no2+=1;} 
if ($category eq "Bedding") {$no3+=1;}
if ($category eq "Building Materials") {$no4+=1;} 
if ($category eq "Carpet & Rug Cleaners") {$no5+=1;}
if ($category eq "Contractors General") {$no6+=1;}
if ($category eq "Furniture Cleaning") {$no7+=1;}
if ($category eq "Furniture Dealers Retail") {$no8+=1;}
if ($category eq "Hardware Retail") {$no9+=1;}
if ($category eq "Home Automation") {$no10+=1;}
if ($category eq "Home Builders") {$no11+=1;}
if ($category eq "Home Designers") {$no12+=1;}
if ($category eq "Interior Designers") {$no13+=1;}
if ($category eq "Lawn Maintenance") {$no14+=1;}
if ($category eq "Linens Retail") {$no15+=1;}
if ($category eq "Lockers") {$no16+=1;}
if ($category eq "Locks") {$no17+=1;}
if ($category eq "Moving & Storage") {$no18+=1;}
if ($category eq "Pest Control Services") {$no19+=1;}
if ($category eq "Plaster") {$no20+=1;}
if ($category eq "Plumbing Contractors") {$no21+=1;}
if ($category eq "Tree Service") {$no22+=1;}
if ($category eq "Vacuum Cleaning") {$no23+=1;}
if ($category eq "Wall & Ceiling Cleaning") {$no24+=1;} 
if ($category eq "Wallpaper & Wall Coverings Contractors") {$no25+=1;} 
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22+$no23+$no24+$no25;
&include("/$sub/$sub9/c11.htm");
}

if ($form{'sub'} eq "12") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Banks") {$no1+=1;} 
if ($category eq "Credit & Debt Counselling Service") {$no2+=1;} 
if ($category eq "Credit Card & Cheque Cashing Protection Service") {$no3+=1;}
if ($category eq "Credit Card & Other Credit Plans") {$no4+=1;} 
if ($category eq "Credit Reporting Agencies") {$no5+=1;}
if ($category eq "Credit Unions") {$no6+=1;}
if ($category eq "Financial Planning Consultants") {$no7+=1;}
if ($category eq "Financing") {$no8+=1;}
if ($category eq "Financing Consultants") {$no9+=1;}
if ($category eq "Foreign Exchange Service") {$no10+=1;}
if ($category eq "Insurance Agents") {$no11+=1;}
if ($category eq "Insurance Agents & Brokers") {$no12+=1;}
if ($category eq "Insurance Brokers") {$no13+=1;}
if ($category eq "Insurance Consultants") {$no14+=1;}
if ($category eq "Investment Advisory Service") {$no15+=1;}
if ($category eq "Investment Castings") {$no16+=1;}
if ($category eq "Investment Dealers") {$no17+=1;}
if ($category eq "Investment Securities") {$no18+=1;}
if ($category eq "Investments Miscellaneous") {$no19+=1;}
if ($category eq "Loans") {$no20+=1;}
if ($category eq "Mortgage Brokers") {$no21+=1;}
if ($category eq "Mortgages") {$no22+=1;}
if ($category eq "Mutual Funds") {$no23+=1;}
if ($category eq "Pawnbrokers") {$no24+=1;}
if ($category eq "Retirement Planning Consultants") {$no25+=1;}
if ($category eq "Stock & Bond Brokers") {$no26+=1;}
if ($category eq "Stock Exchanges") {$no27+=1;}
if ($category eq "Tax Consultants") {$no28+=1;}
if ($category eq "Tax Return Preparation") {$no29+=1;}
if ($category eq "Venture Capital") {$no30+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22+$no23+$no24+$no25+$no26+$no27+$no28+$no29+$no30;
&include("/$sub/$sub9/c12.htm");
}

if ($form{'sub'} eq "13") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Barbers") {$no1+=1;} 
if ($category eq "Beauty Salons") {$no2+=1;} 
if ($category eq "Cosmetics & Perfumes Retail") {$no3+=1;}
if ($category eq "Exercising Equipment") {$no4+=1;} 
if ($category eq "Fitness Centers") {$no5+=1;}
if ($category eq "Florists Retail") {$no6+=1;}
if ($category eq "Hairstylists") {$no7+=1;}
if ($category eq "Manicuring") {$no8+=1;}
if ($category eq "Massages") {$no9+=1;}
if ($category eq "Tanning Salons") {$no10+=1;}
if ($category eq "Wedding Planning, Supplies & Services") {$no11+=1;}
if ($category eq "Weight Control Services") {$no12+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12;
&include("/$sub/$sub9/c13.htm");
}

if ($form{'sub'} eq "14") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Apartments") {$no1+=1;} 
if ($category eq "Condominiums") {$no2+=1;} 
if ($category eq "Home Builders") {$no3+=1;}
if ($category eq "Property Maintenance") {$no4+=1;} 
if ($category eq "Real Estate Appraisers") {$no5+=1;}
if ($category eq "Real Estate Brokers") {$no6+=1;}
if ($category eq "Real Estate Consultants") {$no7+=1;}
if ($category eq "Real Estate Developers") {$no8+=1;}
if ($category eq "Real Estate General") {$no9+=1;}
if ($category eq "Real Estate International") {$no10+=1;}
if ($category eq "Real Estate Investments") {$no11+=1;}
if ($category eq "Real Estate Management") {$no12+=1;}
if ($category eq "Real Estate Rental Service") {$no13+=1;}
if ($category eq "Real Estate Service Agencies") {$no14+=1;}
if ($category eq "Relocation Services") {$no15+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15;
&include("/$sub/$sub9/c14.htm");
}

if ($form{'sub'} eq "15") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Book Dealers Retail") {$no1+=1;} 
if ($category eq "Clothing & Accessories Retail Men") {$no2+=1;} 
if ($category eq "Clothing & Accessories Retail Women") {$no3+=1;}
if ($category eq "Department Stores") {$no4+=1;} 
if ($category eq "Discount Stores") {$no5+=1;}
if ($category eq "Florists Retail") {$no6+=1;}
if ($category eq "Gift Shops") {$no7+=1;}
if ($category eq "Greeting Cards Retail") {$no8+=1;}
if ($category eq "Jewellers Retail") {$no9+=1;}
if ($category eq "Mail Order Houses") {$no10+=1;}
if ($category eq "Shopping Center Promotion") {$no11+=1;}
if ($category eq "Shopping Centers") {$no12+=1;}
if ($category eq "Shopping Service Personal") {$no13+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13;
&include("/$sub/$sub9/c15.htm");
}

if ($form{'sub'} eq "16") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Aviation Consultants") {$no1+=1;} 
if ($category eq "Bicycles Renting") {$no2+=1;} 
if ($category eq "Billiard Halls") {$no3+=1;}
if ($category eq "Bowling") {$no4+=1;} 
if ($category eq "Camps") {$no5+=1;}
if ($category eq "Golf Courses Private") {$no6+=1;}
if ($category eq "Golf Courses Public") {$no7+=1;}
if ($category eq "Golf Equipment & Supplies Retail") {$no8+=1;}
if ($category eq "Gymnastics Clubs") {$no9+=1;}
if ($category eq "Health Clubs") {$no10+=1;}
if ($category eq "Playground Equipment") {$no11+=1;}
if ($category eq "Race Tracks") {$no12+=1;}
if ($category eq "Recreation Centers") {$no13+=1;}
if ($category eq "Skateboards") {$no14+=1;}
if ($category eq "Ski Clubs") {$no15+=1;}
if ($category eq "Skiing Centers & Resorts") {$no16+=1;}
if ($category eq "Sporting Goods Retail") {$no17+=1;}
if ($category eq "Swimming Pool Service") {$no18+=1;}
if ($category eq "Swimming Pools Private") {$no19+=1;}
if ($category eq "Swimming Pools Public") {$no20+=1;}
if ($category eq "Tennis Courts Private") {$no21+=1;}
if ($category eq "Tennis Courts Public") {$no22+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19+$no20+$no21+$no22;
&include("/$sub/$sub9/c16.htm");
}

if ($form{'sub'} eq "17") {
open (DATABASE, "<$database") || die ("Can't open $database.");
foreach $line (<DATABASE>) {
@fieldvalue=split(/\s*\|\s*/, $line, 19);
&checkrecord;
if ($category eq "Air Travel Ticket Agencies") {$no1+=1;} 
if ($category eq "Airline Companies") {$no2+=1;} 
if ($category eq "Airport Transportation Service") {$no3+=1;}
if ($category eq "Airports") {$no4+=1;} 
if ($category eq "Bed & Breakfast Accommodation") {$no5+=1;}
if ($category eq "Boat Charter & Cruises") {$no6+=1;}
if ($category eq "Historical Places") {$no7+=1;}
if ($category eq "Hotels") {$no8+=1;}
if ($category eq "Motels") {$no9+=1;}
if ($category eq "Resorts") {$no10+=1;}
if ($category eq "Sightseeing Tours") {$no11+=1;}
if ($category eq "Taxis") {$no12+=1;}
if ($category eq "Tourism Consultants") {$no13+=1;}
if ($category eq "Tourist Accommodation") {$no14+=1;}
if ($category eq "Tourist Attractions") {$no15+=1;}
if ($category eq "Tourist Information") {$no16+=1;}
if ($category eq "Transit Services") {$no17+=1;}
if ($category eq "Travel Accessories") {$no18+=1;}
if ($category eq "Travel Agencies") {$no19+=1;}
}
close(DATABASE);
$no=$no1+$no2+$no3+$no4+$no5+$no6+$no7+$no8+$no9+$no10+$no11+$no12+$no13+$no14+$no15+$no16+$no17+$no18+$no19;
&include("/$sub/$sub9/c17.htm");
}

&bottom;
exit;
