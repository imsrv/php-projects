#
# Jon Orwant, <orwant@media.mit.edu>
#
# 12 July 96
#
# Copyright 1995 Jon Orwant.  All rights reserved.
# This program is free software; you can redistribute it and/or
# modify it under the same terms as Perl itself.
# 
# Version 0.1.  Module list status is "Rdpf."


# These subroutines tell you whether a credit card number is
# self-consistent -- whether the last digit of the number is a valid
# checksum for the preceding digits.  
#
# The validate() subroutine returns 1 if the card number provided passes
# the checksum test, and 0 otherwise.
#
# The cardtype() subroutine returns a string containing the type of
# card: "MasterCard", "VISA", and so on.  My list is not complete;
# I welcome additions.
#
# The generate_last_digit() subroutine computes and returns the last
# digit of the card given the preceding digits.  With a 16-digit card,
# you provide the first 15 digits; the subroutine returns the sixteenth.
  
# This module does I<not> tell you whether the number is on an actual
# card, only whether it might conceivably be on a real card.  To verify
# whether a card is real, or whether it's been stolen, or what its
# balance is, you need a Merchant ID, which gives you access to credit
# card databases.  The Perl Journal (http://work.media.mit.edu/tpj) has
# a Merchant ID so that I can accept MasterCard and VISA payments; it
# comes with the little pushbutton/slide-your-card-through device you've
# seen in restaurants and stores.  That device calculates the checksum
# for you, so I don't actually use this module.

# These subroutines will also work if you provide the arguments
# as numbers instead of strings, e.g. C<validate(5276440065421319)>.  

# To install this module, change directories to wherever
# your system keeps Perl modules (e.g. C</usr/local/lib/perl5>) and
# create a C<Business> directory if there's isn't one already.
# Then copy this file there.  That's it!

sub cardtype {
    my ($number) = @_;

    $number =~ s/\D//g;

    return "VISA card" if substr($number,0,1) == "4";
    return "MasterCard" if substr($number,0,1) == "5";
    return "Discover card" if substr($number,0,1) == "6";
    return "American Express card" if substr($number,0,2) == "37";
    return "Diner's Club, Transmedia, or other dining/entertainment card" if substr($number,0,1) == "3";
    return "Unknown";
}

sub generate_last_digit {
    my ($number) = @_;
    my ($i, $sum, $weight);

    $number =~ s/\D//g;

    for ($i = 0; $i < length($number); $i++) {
	$weight = substr($number, -1 * ($i + 1), 1) * (2 - ($i % 2));
	$sum += (($weight < 10) ? $weight : ($weight - 9));
    }

    return (10 - $sum % 10) % 10;
}

sub validate {
    my ($number) = @_;
    my ($i, $sum, $weight);

    $number =~ s/\D//g;

    for ($i = 0; $i < length($number) - 1; $i++) {
	$weight = substr($number, -1 * ($i + 2), 1) * (2 - ($i % 2));
	$sum += (($weight < 10) ? $weight : ($weight - 9));
    }

    return 1 if substr($number, -1) == (10 - $sum % 10) % 10;
    return 0;
}

1;


