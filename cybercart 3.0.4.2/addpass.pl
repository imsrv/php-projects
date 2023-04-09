#!/usr/bin/perl -I. -T

# Script to add a merchant to a password file for CyberCart.
# Prevents duplicate entries.

# Takes two arguments:
# - username to add
# - file to add to

# Get the arguments:
($user, $file) = @ARGV;

# Check that we got two arguments:
$file ||
    die "addpass: Add user utility for adding merchants to password file for CyberCart.\n",
    "Usage: addpass.pl username filespec\n";

$file =~ /(.+)/;
$safefile = $1;

# First check that the user does not already exist:
&UserDefined($user, $safefile) && 
    die "User \"$user\" already exists in file \"$safefile\".\n";

# Get the encrypted password:
$password = &GetPword;

# Store the new username and password:
&SetPword($safefile, $user, $password);

# End

# Library of Apache user, group, password etc utilities.
#

# Subroutine to prompt for and return (encrypted) password.
sub GetPword {

    my ( $pwd1, $pwd2, $salt, $crypted );
    my @saltchars = (a .. z, A .. Z, 0 .. 9);
	
    print "Enter password: ";
    $pwd1 = <STDIN>;
    chop($pwd1);
    length($pwd1) >= 8 || 
        die "Password length must be eight characters or more.\n";
	
    print "Enter the password again: ";
    $pwd2 = <STDIN>;
    chop($pwd2);
	
    # Check that they match:
    ($pwd1 eq $pwd2 ) || die
        "Sorry, the two passwords you entered do not match.\n";
	
    # Generate a random salt value for encryption:
    srand(time || $$);
    $salt = $saltchars[rand($#saltchars)] . $saltchars[rand($#saltchars)];
    
    return crypt($pwd1, $salt);
}


# Return 1 if user defined in named text file
sub UserDefined  {

    my ( $username, $filespec ) = @_;

    # No file, no user
    open(USERFILE, $filespec) || return 0;

    # Check each line for username:
    while (<USERFILE>)  {
	if ( /^$username:/ )  {
	    close USERFILE;
	    return 1;
	}
    }
    close USERFILE;
    return 0;
}


# Store a user's password in a user definition file
# Arguments: 
# - user file spec
# - user name
# - password
sub SetPword  {
    my( $filespec, $user, $pword ) = @_;

    # Open user file for appending:
    
    open(USERFILE, "+>>$filespec") || 
	die "Could not open user file \"$filespec\" for appending: $!\n";
    
    # Write to the user file
    print USERFILE "$user:$pword\n" || 
	die "Failed to write the user/password to file \"$filespec\".\n";
    
    # Tidy up:
    
    close USERFILE;
}


# Subroutine to extract group member list from group file
# Input: file spec of group membership file
# Returns: Associative array of groups, members.

sub GetGroupMembers {
    my( $filespec ) = @_;
    my ($thisgrp, $grpmembers, %groupmembers);
    
    # Just return now if file does not exist:
    -e $filespec || return;

    # Open the group file:
    open(GFILE, "$filespec") || 
	die "Could not open user file \"$filespec\" for reading: $!\n";
    
    while (<GFILE>)  {
	chop;
	($thisgrp, $grpmembers) = split(':' , $_);
	$groupmembers{$thisgrp} = $grpmembers;
    }

    close GFILE;

    return %groupmembers;
}


# Subroutine to store group member list in group file
# Input: file spec of group membership file, 
#        associative array of groups/users

sub SetGroupMembers {
    my( $filespec, %groups ) = @_;
    my ($grp);

    # Open the group file:
    open(GFILE, ">$filespec") || 
	die "Could not open group file \"$filespec\" for writing: $!\n";
    
    foreach $grp ( keys %groups )  {
	print GFILE "$grp: $groups{$grp}\n";
    }
    
    close GFILE;
}


# Subroutine to delete a user from a user file
# Input: Username, filespec

sub DeleteUser  {

    my ($user, $filespec) = @_;
    my ($thisusr, $thispw, $elem, %passwords);
    
    # Open the file for reading:
    open(USERFILE, "$filespec") || 
        die "Could not open user file \"$filespec\" for reading: $!\n";

    # Grab the contents of the user file in an associative array:
    while (<USERFILE>)  {
        chop;
        ($thisusr, $thispw) = split(':', $_) ;
        $passwords{$thisusr} = $thispw;
    }
    close USERFILE;


    # Check that the named user exists:
    $passwords{$user} || 
        die "User \"$user\" not found in file \"$filespec\".\n";

    # Now delete the user from the array:
    delete $passwords{$user};

    # Now write the whole user/password array to the user file:

    # First re-open the user file for writing:
    open(USERFILE, ">$filespec") || 
        die "Could not open user file \"$filespec\" for reading: $!\n";

    # Now write each element of the array in the correct format:
    foreach $elem ( keys %passwords )  {
        print USERFILE $elem, ":", $passwords{$elem}, "\n" ||
            die "Failed to write user/password to file \"$filespec\": $!.\n";
    }

    close USERFILE;
}






