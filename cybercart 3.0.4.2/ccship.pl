# CyberCart Pro Internet Commerce System, Version 3.04
# Copyright 1997, Richard Torzynski
# 1-25-98
# All rights reserved

# Routines for calculating shipping cost for CyberCart
# Place this file in the merchant data directory defined in the
# variable $merchant_data in cybercart.pl


sub ship {
# Calculate shipping and get billing info
&check_form;

# Skip the shipping page if there is no shipping cost
if ($shipping_cost eq "none") {
  &billing;
  exit;
}

# Check to see if international ok
if ($post_query{'country'} ne $shipping_base && $no_world_shipping) {
  print "<h1>International Orders</h1>\n";
  print "I'm sorry, but $company does not ship orders outside the United
States.\n";
  print "<p>";
  &footer;
  exit;
}

print "<center>\n";
print "<h1>Shipping Method</h1>\n";
print "</center>\n";
&show_order;
&show_ship;
}
# End sub ship
#--------------------------------------------------------

sub show_ship { 



# Show shipping options, if there are any
if (%delivery_method) {
  # This is where the merchant has a simple drop down of shipping choices
  print qq(
  <center>
  <table border=1 cellspacing=0 cellpadding=10 width="$Table_width" bgcolor=$Table_Header_Color>
  <tr align=left><td colspan=2 bgcolor=$Table_Body_Color>
  );

  if ((keys (%delivery_method) + keys(%ups_cost)) > 1) {
    print "<pre><b><u>Choose Shipping:</u></b>\n</pre>";
  } else {
    print "<pre><b><u>Shipping:</u></b>\n</pre>";
  }

  print qq(
  </td>
  <tr>
  <th align=left>Method</th>
  <th align=right>Cost</th>
  </tr>
  );
  foreach $key (keys %delivery_method) {
    print "<tr bgcolor=$Table_Entry_Color><td>";
    print "<input type=radio name=ship_cost value=\"$key\-$delivery_method{$key}\">$key";
    print "</td><td align=right>";
    print "\$$delivery_method{$key}</td></tr>";
  }
} elsif (($shipping_cost eq "actual" && $post_query{'country'} eq "US") || 
         ($world_shipping_cost eq "actual" && $post_query{'country'} ne "US") ||
         ($shipping_cost =~ m/special/ && $post_query{'country'} eq $shipping_base) || 
         ($world_shipping_cost =~ m/special/ && $post_query{'country'} ne $shipping_base)) {
  # Files need for calculating shipping rates.  

  $zone_chart_dir = $shipping_dir . "Zones/";


  # If merchant is using actual UPS and USPS Shipping Rates
  print qq(
  <center>
  <table border=1 cellspacing=0 cellpadding=10 width=580 bgcolor=\#$Table_Header_Color> 
  <tr align=left><td colspan=2 bgcolor=$Table_Body_Color>
  );

  if ((keys (%delivery_method) + keys(%ups_cost)) > 1) {
    print "<pre><b><u>Choose Shipping:</u></b>\n</pre>";
  } else {
    print "<pre><b><u>Shipping:</u></b>\n</pre>";
  }

  print qq( 
  </td>
  <tr>
  <th align=left>Method</th>
  <th align=right>Cost</th>
  </tr>
  );
  
  # Routine for special shipping charts
  if ( ($shipping_cost =~ m/special/ && $post_query{'country'} eq $shipping_base) ||
       ($world_shipping_cost =~ m/special/ && $post_query{'country'} ne $shipping_base)) {
    &special_shipping;
  } elsif ($post_query{'country'} eq "US") {
    &us_rate;
    &ups;
    &usps;
  } elsif ($post_query{'country'} eq "Canada") {
    &ups_canada_zone;
    &ups_canada_rate;
  } elsif ($post_query{'country'} ne "US"){
    &world_zone;
    &world_ups_express;
    &world_ups_expedited;
  }

  foreach $key (keys %ups_cost) {
    print "<tr bgcolor=$Table_Entry_Color><td>";
    if ($ups_cost{$key} > 1) {    
      $ups_cost{$key} += $handling;
 
      if ((keys (%delivery_method) + keys(%ups_cost)) > 1) {    
        print "<input type=radio name=ship_cost value=\"$key-$ups_cost{$key}\">\n";
      } else {
        print "<input type=hidden name=ship_cost value=\"$key-$ups_cost{$key}\">\n";
      }
      print "$key</td>";
      if ($no_decimal) {
        printf "<td align=right>%5.0f", $ups_cost{$key};
      } else {
        printf "<td align=right>%5.2f", $ups_cost{$key};
      }
      print "</td></tr>";

      
    } else {
      print "$key</td><td align=right>N/A</td></tr>\n";
    }
  }

} elsif ($shipping_cost eq "None") {
  # Just print button if shipping cost are included in the price
  print qq(
  <center>
  <input type=hidden name=processing value=$post_query{'processing'}>
  <input type=hidden name=action value="billing">
  <input type=submit value="Continue">
  );
}

foreach $key (keys %post_query) {
  # print all the form variables passed
  if ($key ne "action") {
    print "<input type=hidden name=\"$key\" value=\"$post_query{$key}\">\n";
  }
}

if (%delivery_method || ($shipping_cost eq "actual" && $post_query{'country'} eq "US") || 
   ($world_shipping_cost eq "actual" && $post_query{'country'} ne "US") ||
   ($shipping_cost =~ m/special/ && $post_query{'country'} eq $shipping_base) || 
   ($world_shipping_cost =~ m/special/ && $post_query{'country'} ne $shipping_base) ) {
  # print button as part of the shipping choice table 
  print qq(
  <tr>
  <td colspan=2 bgcolor=$Table_Body_Color><center>
  <input type=hidden name=processing value=$post_query{'processing'}>
  <input type=hidden name=action value="billing">
  <input type=submit value="Continue">
  </td></tr></table></center>
  );
} elsif (($shipping_cost ne "none" && $post_query{'country'} eq $shipping_base) || 
         ($world_shipping_cost ne "none" && $post_query{'country'} ne $shipping_base)) {
  # print shipping cost and button if flat,percentage,table, weight, or items
  &shipping;
  if ($shipping > 0) {
    print qq(
    <center>
    <table border=1 cellspacing=0 cellpadding=10 width=\"$Table_width\" bgcolor=$Table_Body_Color\>  
    <tr>
    <td colspan=2 bgcolor=$Table_Header_Color align=center>
    <h2>Shipping Cost</h2>
    </td></tr>
    <tr>
    <td bgcolor=$Table_Entry_Color>
    $mod
    );

    if ($show_table && $post_query{'country'} eq $shipping_base) {
      print "<pre>$show_table</pre>";
    } elsif ($world_show_table && $post_query{'country'} ne $shipping_base) {
      print "<pre>$world_show_table</pre>";
    }
    print qq(
    </td>
    <td align=right valign=top bgcolor=$Table_Body_Color>
    );

    if ($no_decimal) {
      printf "\$%5.0f", $shipping;
    } else {
      printf "\$%5.2f", $shipping;
    }

    print qq(
    </td>
    </tr>
    <tr><td colspan=2 align=center bgcolor=$Table_Header_Color>
    <input type=hidden name=processing value=$post_query{'processing'}>
    <input type=hidden name=action value="billing">
    <input type=submit value="Continue"> 
    </table>
    </center>
    );
  } else {
    print qq(
    <center>
    <input type=hidden name=processing value=$post_query{'processing'}>
    <input type=hidden name=action value="billing">
    <input type=submit value="Continue">
    );
  }
}
print "</form>\n";
print "<p>";
&print_links;
&footer;
}
# End sub show_ship
#----------------------------------------------------------


sub shipping {
# Calcuate shipping cost

if ($post_query{'country'} ne $shipping_base) {
  $shipping_cost = $world_shipping_cost;
}


if ($shipping_cost eq "percent") {
  # to apply a straight percentage shipping cost:
  if ($post_query{'country'} ne $shipping_base) {
    $shipping_modifier = $world_shipping_modifier;
  }

  $shipping = $shipping_modifier * $order_total;
  $perc = 100 * $shipping_modifier;
  $mod = "Shipping \@ $perc\%";
  if ($min_shipping && $shipping < $min_shipping) {
    $shipping = $min_shipping;
  }
  print "<input type=hidden name=ship_cost value=\"$mod\-$shipping\">";
  if ($min_shipping) {
    $mod .= " (Minimum shipping: \$$min_shipping) ";
  }
} elsif ($shipping_cost eq "flat") {
  # to have one shipping cost:
  if ($post_query{'country'} ne $shipping_base) {
    $shipping_modifier = $world_shipping_modifier;
  }
  $shipping = $shipping_modifier;
  $mod = "Shipping \@ Flat Rate";
  print "<input type=hidden name=ship_cost value=\"$mod\-$shipping\">";
} elsif ($shipping_cost eq "table") {
  if ($post_query{'country'} ne $shipping_base) {
    %ship_table = %world_ship_table;
  }
  $mod = "Shipping Table";
  foreach $range (sort keys %ship_table) {
    ($low,$high) = split(/-/,$range);
    if ($order_total >= $low && $order_total < $high) {
      $shipping = $ship_table{$range};
      print "<input type=hidden name=ship_cost value=\"Shipping\-$shipping\">";
    }
  }
} elsif ($shipping_cost eq "items") {
  # use table for shipping
  if ($post_query{'country'} ne $shipping_base) {
    %ship_table = %world_ship_table;
  }
  $mod = "Shipping Table";
  foreach $range (sort keys %ship_table) {
    ($low,$high) = split(/-/,$range);
    if ($num_items_ordered >= $low && $num_items_ordered <= $high) {
      $shipping = $ship_table{$range};
      print "<input type=hidden name=ship_cost value=\"Shipping\-$shipping\">";
    }
  }
} elsif ($shipping_cost eq "percent_table") {
  # use percent table for shipping
  if ($post_query{'country'} ne $shipping_base) {
    %ship_table = %world_ship_table;
  }
  $mod = "Shipping Table";
  foreach $range (sort keys %ship_table) {
    $per = $ship_table{$range}*100;
    ($low,$high) = split(/-/,$range);
    if ($order_total >= $low && $order_total < $high) {
      $shipping = $ship_table{$range} * $order_total;
      if ($min_shipping && $shipping < $min_shipping) {
        $shipping = $min_shipping;
      }
      print "<input type=hidden name=ship_cost value=\"Shipping\-$shipping\">";
    }
  }
  if ($min_shipping) {
    $mod .= " (Minimum shipping: \$$min_shipping) ";
  }

} elsif ($shipping_cost eq "weight") {
  # use weight
  if ($post_query{'country'} ne $shipping_base) {
    %ship_table = $world_ship_table;
  }

  foreach $range (keys %ship_table) {
    ($low,$high) = split(/-/,$range);
    if ($total_wt >= $low && $total_wt < $high) {
      $shipping = $ship_table{$range};
      print "<input type=hidden name=ship_cost value=\"Shipping\-$shipping\">";
    }
  }
} elsif ($shipping_cost eq "per_item") {
  # use per item
  # Shipping value already set in show_order routine
  $mod = "Shipping Cost on Per Item Basis";
  print "<input type=hidden name=ship_cost value=\"$mod\-$shipping\">";

} else {
  $shipping="Not able to calculate";
}

if ($min_shipping && $shipping < $min_shipping && $post_query{'country'} eq $shipping_base) {
  $shipping = $min_shipping;
} elsif ($min_world_shipping && $shipping < $min_world_shipping && $post_query{'country'} ne $shipping_base) {
  $shipping = $min_world_shipping;
}

if ($max_shipping && $shipping > $max_shipping && $post_query{'country'} eq $shipping_base) {
  $shipping = $max_shipping;
} elsif ($max_shipping && $shipping > $max_shipping && $post_query{'country'} ne $shipping_base) {
  $shipping = $max_world_shipping;
}


}
# end sub shipping
#----------------------------------------------------#

sub us_rate {
# Determine UPS zone
# zone chart: zip,ground,3-day select,2nd day air, 2nd day air am, 
# next day airsaver, next day air

# Define the files needed.  

$upsgr = $shipping_dir . "Gndres.csv";
$ups2da = $shipping_dir . "2da.csv";
$ups2dam = $shipping_dir . "2dam.csv";
$ups1d = $shipping_dir . "1da.csv";
$ups1ds = $shipping_dir . "1dasaver.csv";
$ups3d = $shipping_dir . "3ds.csv";
$uspspm = $shipping_dir . "uspspm.csv";
$uspsem = $shipping_dir . "uspsem.csv";
$uspsmp = $shipping_dir . "uspsmp.csv";
$uspsnmp = $shipping_dir . "uspsnmp.csv";

# Determine which merchant zip to us.  This can also be set in the
# $zone_chart variable in the merchant setup file.  If its not there,
# this routine will search the directory containing the files.

# Get the first three digits in the zip
$mzip = substr($merchantzip,0,3);

# routine to look through zone chart files and determine the right one
# to use.
if (!$zone_chart) {
  opendir UPS, "$zone_chart_dir" || &error("Cant open $zone_chart_dir at line 511");
  @allfiles = readdir UPS;
  foreach $a (sort @allfiles) {
    ($z,$gar) = split(/\./,$a);
    if ($mzip < $a) {
      $zone_chart = $zone_chart_dir . "$prevfile";
      last;
    } else {
      $prevfile = $a;
    }
  }
}    

# First three digits of customers zip
$zip3 = substr($post_query{'zip'},0,3);
open(ZONE, "$zone_chart") || &error("Cant open zone_chart at $zone_chart in sub shipping");
while (<ZONE>) {
  chop;
  ($code_range,$gr,$td,$sda,$sdaam,$ndas,$nda) = split(/\,/,$_);
  ($lowcode,$hicode) = split(/-/,$code_range);
  if ($hicode) {
    if ($zip3 >= $lowcode && $zip3 <= $hicode) {
      last;
    }
  } elsif ($zip3 == $lowcode) {
    last;
  }
}
close(ZONE);
}

# End sub us_rate
#---------------------------------------------------------------------------------------

sub ups_canada_zone {

$zip3 = substr($post_query{'zip'},0,3);
$zip3 = uc $zip3;
open(ZONE, "$can_zone_chart") || &error("Cant open can_zone_chart at $can_zone_chart in sub shipping");
while (<ZONE>) {
  chop;
  ($lowcode,$hicode,$zone) = split(/\,/,$_);
  if ($hicode) {
    if ($zip3 >= $lowcode && $zip3 <= $hicode) {
      last;
    } 
  } elsif ($zip3 == $lowcode) {
      last;
  }
}
close(ZONE);
}


sub ups_canada_rate {
# Routines to calculate UPS Shipping rates

$canstnd = $shipping_dir . "Canstnd.csv";

  # ups to canada
  open(RATE, "$canstnd") ||  &error("Cant open canstnd at $canstnd in sub shipping");
  while (<RATE>) {
    s/ //g;
    s/\$//g; 
    ($lbs,$z[51],$z[52],$z[53],$z[54],$z[55],$z[56]) = split(/\,/,$_);
    if (($total_wt < 1 && $lbs == 1) || ($total_wt == $lbs) || ($total_wt < $lbs && $total_wt >= $lbs-1)) {
      $ups_cost{'UPS Ground to Canada'} = $z[$zone];
      last;

    }
  }
  close(CODE);
}



sub ups {
# Routines to calculate UPS Shipping rates

if ($upsground) {
  # ups commercial ground
  open(RATE, "$upsgr") ||  &error("Cant open upsgr at $upsgr in sub shipping");
  while (<RATE>) {
    s/ //g;
    s/\$//g; 
    ($lbs,$z[2],$z[3],$z[4],$z[5],$z[6],$z[7],$z[8]) = split(/\,/,$_);
    if (($total_wt < 1 && $lbs == 1) || ($total_wt == $lbs) || ($total_wt < $lbs && $total_wt >= $lbs-1)) {
      $ups_cost{'UPS Ground'} = $z[$gr];
      last;

    }
  }
  close(CODE);
}

if ($ups2day) {
  # ups second day air
  # now open rate chart 
  open(RATE, "$ups2da") ||  &error("Cant open upsgr $upsgr in sub shipping");
  while (<RATE>) {
  s/ //g;
  s/\$//g;    
($lbs,$sdar{'202'},$sdar{'203'},$sdar{'204'},$sdar{'205'},$sdar{'206'},$sdar{'207'},$sdar{'208'},$sdar{'224'},$sdar{'225'},$sdar{'226'}) = split(/\,/,$_);
    if ($total_wt < $lbs && $total_wt >= $lbs-1) {
      $ups_cost{'UPS 2nd Day Air'} = $sdar{$sda};
      last;

    }
  }
  close(RATE);
}

if ($ups2day) {
  # ups second day air am service
  open(RATE, "$ups2dam") ||  &error("Cant open ups2dam $up2dam in sub shipping");
  while (<RATE>) {
  s/ //g;
  s/\$//g;
($lbs,$sdar{'242'},$sdar{'243'},$sdar{'244'},$sdar{'245'},$sdar{'246'}, $sdar{'248'}) = split(/\,/,$_);
    if ($total_wt < $lbs && $total_wt >= $lbs-1) {
      $ups_cost{'UPS 2nd Day Air AM'} = $sdar{$sdaam};
      last;
    }
  }
  close(RATE);
}

if ($ups1day) {
  # ups second day air am service
  open(RATE, "$ups1d") ||  &error("Cant open ups1d $up1d in sub shipping");
  while (<RATE>) {
  s/ //g;
  s/\$//g;
($lbs,$zn{'102'},$zn{'103'},$zn{'104'},$zn{'105'},$zn{'106'},$zn{'107'},$zn{'108'},$zn{'124'},$zn{'125'},$zn{'126'}) = split(/\,/,$_);
    if ($total_wt < $lbs && $total_wt >= $lbs-1) {
      $ups_cost{'UPS Next Day Air'} = $zn{$nda};
      last;
    }
  }
  close(RATE);
}

if ($ups1daysav) {
  # ups next day air saver
  open(RATE, "$ups1ds") ||  &error("Cant open ups1ds $up1ds at line 526");
  while (<RATE>) {
  s/ //g;
  s/\$//g;
  ($lbs,$zn{'132'},$zn{'133'},$zn{'134'},$zn{'135'},$zn{'136'},
    $zn{'137'},$zn{'138'}) = split(/\,/,$_);
    if ($total_wt < $lbs && $total_wt >= $lbs-1) {
      $ups_cost{'UPS Next Day Air Saver'} = $zn{$ndas};
      last;
    }
  }
  close(RATE);
}

if ($ups3daysel) {
  # ups 3 day select
  open(RATE, "$ups3d") ||  &error("Cant open ups3d $ups3d at line 542");
  while (<RATE>) {
  s/ //g;
  s/\$//g;
($lbs,$zn{'302'},$zn{'303'},$zn{'304'},$zn{'305'},$zn{'306'},$zn{'307'},
    $zn{'307'},$zn{'308'}) = split(/\,/,$_);
    if ($total_wt < $lbs && $total_wt >= $lbs-1) {
      $ups_cost{'UPS 3 Day Select'} = $zn{$td};
      last;
    }
  }
  close(RATE);
}

} 

# end ups
#--------------------------------------------------------------------#

sub usps {
# calculate USPS shipping rates
if ($usps_priority) {
  # usps priority mail
  open(RATE, "$uspspm") ||  &error("Cant open uspspm at $uspspm in sub shipping");
  while (<RATE>) {
    ($lbs,$z[1],$z[2]) = split(/\,/,$_);
    if ($total_wt < $lbs && $total_wt >= $lbs-1) {
      # $ups_cost{'USPS Priority Mail'} = $z[$gr];
      $ups_cost{'USPS Priority Mail'} = $z[1];
      last;

    }
  }
  close(CODE);
}

if ($usps_express) {
  # usps express mail
  # now open rate chart
  open(RATE, "$uspsem") ||  &error("Cant open uspspm at $uspsem at line 579");
  while (<RATE>) {
    ($lbs,$z[2],$z[3],$z[4],$z[5],$z[6],$z[7],$z[8]) = split(/\,/,$_);
    if (($lbs == 0.5 && $total_wt <= 0.5) || ($total_wt <= $lbs && $total_wt >= $lbs-1)) {
      $ups_cost{'USPS Express Mail'} = $z[$gr];
      last;

    }
  }
  close(CODE);
}

if ($usps_mparcel) {
# usps machinable parcel service
  open(RATE, "$uspsmp") ||  &error("Cant open uspspm at $uspsmp at line 593");
  while (<RATE>) {
    ($lbs,$z[1],$z[2],$z[3],$z[4],$z[5],$z[6],$z[7],$z[8]) =split(/\,/,$_);
    if ($total_wt < $lbs && $total_wt >= $lbs-1) {
      $ups_cost{'USPS Machinable Parcel'} = $z[$gr];
      last;

    }
  }
  close(CODE);
}

if ($usps_nmparcel) {
# usps non-machinable parcel service
  open(RATE, "$uspsnmp") ||  &error("Cant open uspspm at $uspsnmp at line 606");
  while (<RATE>) {
    ($lbs,$z[1],$z[2],$z[3],$z[4],$z[5],$z[6],$z[7],$z[8]) =split(/\,/,$_);
    if ($total_wt < $lbs && $total_wt >= $lbs-1) {
      $ups_cost{'USPS Non-Machinable Parcel'} = $z[$gr];
      last;

    }
  }
  close(CODE);
}
}

# End sub usps
#-----------------------------------------------------------------------------


sub world_zone {
# Use the zone charts to find what zone order is in
$west ="AK,AZ,CA,CO,HI,ID,KS,LA,MN,MS,MT,NE,NV,NM,ND,OK,OR,SD,TX,UT,WA,WY";
$east ="AL,CT,DE,DC,FL,GA,IL,IN,IO,KY,MA,MD,MA,MI,MS,NH,NJ,NY,NC,OH,PN,RH,SC,TN,VT,VA,WI";

if ($west =~ m/$merchantstate/) {
  $ups_world_zone = $shipping_dir . "Wwwzone.csv";
  $ups_world_exp_rate = $shipping_dir . "Www-xpr.csv";
  $ups_world_exd_rate = $shipping_dir . "Www-xpr.csv";
} else {
  $ups_world_zone = $shipping_dir . "Ewwzone.csv";
  $ups_world_exp_rate = $shipping_dir . "Eee-xpr.csv";
  $ups_world_exd_rate = $shipping_dir . "Eee-xpr.csv";
}

# Determine World Zone zone
# zone chart: Country, Express,Expeditied, EAS 
open(ZONE, "$ups_world_zone") || &error("Cant open ups_world_zone at $ups_world_zone in sub shipping");
while (<ZONE>) {
  chop;
  ($country, $express, $expedited, $EAS) = split(/\,/,$_);
  if ($country eq $post_query{'country'}) {
    last;
  }
}
close(ZONE);
}

# End sub world_zone
#----------------------------------------------------------------------------

sub world_ups_express {
# now open rate chart for ups express 
open(RATE, "$ups_world_exp_rate") ||  &error("Cant open ups_world_exp_rate at $ups_world_exp_rate in sub shipping");
while (<RATE>) {
  s/ //g;
  s/\$//g;
  ($lbs,$w{'84'},$w{'901'},$w{'902'},$w{'903'},$w{'904'},$w{'905'},$w{'906'},$w{'907'},$w{'908'}) = split(/\,/,$_);
  if ($total_wt < $lbs && $total_wt >= $lbs-1) {
    $ups_cost{'UPS World Wide Express'} = $w{$express};
    last;
  }
}
close(CODE);
}

# End sub world_ups_express
#-----------------------------------------------------------------------------

sub world_ups_expedited {
# now open rate chart
open(RATE, "$ups_world_exd_rate") ||  &error("Cant open usp_world_exd_rate at $ups_world_exd_rate in sub shipping");
while (<RATE>) {
  s/ //g;
  s/\$//g;    
  ($lbs,$w{'74'},$w{'605'},$w{'606'},$w{'607'},$w{'608'}) = split(/\,/,$_);
  if ($total_wt < $lbs && $total_wt >= $lbs-1) {
    $ups_cost{'UPS World Wide Expedited'} = $w{$expedited};
    last;
  }
}
close(CODE);
}

# End sub world_ups_express
#-------------------------------------------------------------------------------
 


sub special_shipping {
# Determine Zone
# zone chart: Country, Express,Expeditied, EAS 

if ($post_query{'country'} ne $shipping_base) {
  $special_zone = $world_special_zone;
}

open(ZONE, "$special_zone") || &error("Cant open $special_zone in sub shipping");
while (<ZONE>) {
  chop;
  ($country, $zone) = split(/\,/,$_);
  $country =~ s/\"//ig;
  # set this to check for a match either by country or state
  if ($country eq $post_query{'country'} || $country eq $post_query{'state'}) {
    last;
  }
  
}
close(ZONE);

if ($post_query{'country'} ne $shipping_base) {
  $special_rate = $world_special_rate;
}



open(RATE, "$special_rate") ||  &error("Cant open $special_rate");
while (<RATE>) {
  ($ni,$z[1],$z[2],$z[3],$z[4],$z[5],$z[6],$z[7],$z[8],$z[9],$z[10]) =split(/\,/,$_);
  if ($shipping_cost eq "special_items" || $world_shipping_cost eq "special_items") {
    if ($ni =~ m/\-/) {
      ($low,$high) = split(/\-/,$ni);
      if ($num_items_ordered > $low && $num_items_ordered <= $high) {
        $ups_cost{$special_name} = $z[$zone];
        last;
      }
    } elsif ($ni == $num_items_ordered || $ni == $max_item_rate ) {
      $ups_cost{$special_name} = $z[$zone];
      last;
    }
  } elsif ($shipping_cost eq "special_weight" || $world_shipping_cost eq "special_weight") {
    if (!$weight_inc) {
      $weight_inc = 1;
    }
    if ($ni =~ m/\-/) {
      ($low,$high) = split(/\-/,$ni);
      if ($total_wt > $low && $total_wt <= $high) {
        $ups_cost{$special_name} = $z[$zone];
        last;
      }
    } elsif (($total_wt < 1 && $ni == 1) || ($total_wt < $ni && $total_wt>=$ni-$weight_inc)) {
      $ups_cost{$special_name} = $z[$zone];
      last;
    } 
    
  }
}

close(RATE);

# Routine for addition items or weight or max
if ((
     ($shipping_cost eq "special_items" && $post_query{'country'} eq $shipping_base) ||
     ($world_shipping_cost eq "special_items" && $post_query{'country'} ne $shipping_base)
    ) && $num_items_ordered > $max_item_rate) {
    
     $add_cost = $add_item[$zone];
	
	if ( ($num_items_ordered-$max_item_rate) % $item_inc == 0 ) {
	  $add_mod = int(($num_items_ordered-$max_item_rate)/$item_inc);
	  
	} else {
	  $add_mod = int(($num_items_ordered-$max_item_rate)/$item_inc) + 1;
	}  
	$ups_cost{$special_name} += $add_cost * $add_mod;
}

# Routine for addition items or weight or max
if ((
     ($shipping_cost eq "special_weight" && $post_query{'country'} eq $shipping_base) ||
     ($world_shipping_cost eq "special_weight" && $post_query{'country'} ne $shipping_base)
    ) && $total_wt > $max_item_rate) {
    
     $add_cost = $add_item[$zone];
     $ups_cost{$special_name} += $add_cost * ($total_wt-$max_item_rate) + $z[$zone];
}


 
}



return 1;
