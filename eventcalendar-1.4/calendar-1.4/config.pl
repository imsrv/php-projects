#!/usr/bin/perl

#  Simon's Rock Event Calendar
#  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
#  Please read the accompanying files "COPYING" and "COPYRIGHT"
#  for more information
#  $Id: config.pl,v 1.14 2001/05/30 22:14:13 fluffy Exp $

use Time::Local;

# Config variables will be stored in %varhash, then, for each file listed
#  in @filelist, filename.in will be read, replacing all occurrences of
#  "<<varname>>" with $varhash{"varname"} and writing the results to filename

@filelist = ("Makefile", "php-utils/Make.common", "sql-dumps/srccalendar.sql",
	"sql-dumps/auth.sql", "auth/sql/sql.php3", "calendar/sql/sql.php3",
	"po/Makefile" );

@time_arr = localtime;
$time_arr[0] = 0;
$time_arr[1] = 0;
$time_arr[2] = 0;
$varhash{"configdate"} = timelocal(@time_arr);

$varhash{"psql"} = getProgPath("psql");
$varhash{"createdb"} = getProgPath("createdb");
$varhash{"createuser"} = getProgPath("createuser");
$varhash{"dbuser"} = promptUser("Username that can create databases and database users", "postgres");
$varhash{"wwwdir"} = promptUser("Path to install auth and calendar", "/var/www");
$varhash{"owner"} = promptUser("Owner of source files and auth executables", "root");
$varhash{"group"} = promptUser("Group of source files and auth executables", "www");
$varhash{"phputils"} = promptUser("Directory to install auth-module executables", "/usr/local/php3");
$varhash{"authmod"} = promptUser("Authenication module, such as auth-shadow.php3, auth-pam.php3, or auth-nis.php3", "auth-shadow.php3");

if ($varhash{"authmod"} eq "auth-shadow.php3")
{
	$varhash{"getpwinfo"} = $varhash{"phputils"} . "/getpwinfo";
	$varhash{"getuidinfo"} = $varhash{"phputils"} . "/getuidinfo";
	$varhash{"chkpass"} = $varhash{"phputils"} . "/getshcrypt";
}
elsif ($varhash{"authmod"} eq "auth-pam.php3")
{
	$varhash{"getpwinfo"} = $varhash{"phputils"} . "/getpwinfo";
	$varhash{"getuidinfo"} = $varhash{"phputils"} . "/getuidinfo";
	$varhash{"chkpass"} = $varhash{"phputils"} . "/chkpass";
}
elsif ($varhash{"authmod"} eq "auth-nis.php3")
{
	$varhash{"getpwinfo"} = $varhash{"phputils"} . "/getpwinfo.pl";
	$varhash{"getuidinfo"} = $varhash{"phputils"} . "/getpwinfo.pl";
	$varhash{"chkpass"} = $varhash{"phputils"} . "/runshcrypt";
}
else
{
	print("I don't recognize the auth module you specified, so...\n");
	$varhash{"getpwinfo"} = promptUser("getpwinfo", $varhash{"phputils"} . "/getpwinfo");
	$varhash{"getuidinfo"} = promptUser("getuidinfo", $varhash{"phputils"} . "/getuidinfo");
	$varhash{"chkpass"} = promptUser("chkpass", $varhash{"phputils"} . "/getshcrypt");
}
$varhash{"authtarget"} = $varhash{"authmod"};
$varhash{"authtarget"} =~ s/\.php3$//;

$varhash{"adminid"} = promptUser("User ID to grant admin access", $<);

$varhash{"sslreq"} = promptYNUser("SSL required for logins?", 1);

$varhash{"installcss"} = promptYNUser("Install basic.css stylesheet?", 1);
if ($varhash{"installcss"})
{
	$varhash{"installcss"} = "install-css";
	$varhash{"css"} = "../basic.css";
}
else
{
	$varhash{"installcss"} = "";
	$varhash{"css"} = promptUser("Path to stylesheet, relative to index.php3", "../basic.css");
}

$varhash{"installpo"} = promptYNUser("Install calendar translations?", 1);
if ($varhash{"installpo"})
{
	$varhash{"installpo"} = "install-po";
	$varhash{"msgfmt"} = getProgPath("msgfmt");
	$varhash{"textdomain_dir"} = promptUser("Path to install translations", $varhash{"wwwdir"} . "/locale");
	$varhash{"textdomain"} = promptUser("Text domain of translations", "eventcalendar");
	$varhash{"daybeforemonth"} = promptYNUser("Display numeric dates as dd/mm/yy?", 0);
	$varhash{"locale"} = promptUser("Default locale", "C");
}
else
{
	$varhash{"msgfmt"} = "";
	$varhash{"locale"} = "";
	$varhash{"textdomain"} = "";
	$varhash{"textdomain_dir"} = "";
	$varhash{"daybeforemonth"} = 0;
}

$varhash{"authdb"} = promptUser("Database for auth tables", "auth");
$varhash{"caldb"} = promptUser("Database for calendar tables", "srccalendar");

$varhash{"dbro"} = promptUser("Read-only user for " . $varhash{"authdb"} .
	" and " . $varhash{"caldb"} . " database", "guest");
$varhash{"createdbro"} = promptYNUser("Does " . $varhash{"dbro"} .
	" need to be created?", 0);
if ($varhash{"createdbro"})
{
	$varhash{"createdbro"} = "create-dbro";
}
else
{
	$varhash{"createdbro"} = "";
}

$varhash{"dbrw"} = promptUser("Read-write user for " . $varhash{"authdb"} .
	" and " . $varhash{"caldb"} . " database", "srccalendar");
$varhash{"createdbrw"} = promptYNUser("Does " . $varhash{"dbrw"} .
	" need to be created?", 0);
if ($varhash{"createdbrw"})
{
	$varhash{"createdbrw"} = "create-dbrw";
}
else
{
	$varhash{"createdbrw"} = "";
}


print <<"EOF";

Using the following configuration:
             Path to psql: $varhash{"psql"}
         Path to createdb: $varhash{"createdb"}
       Path to createuser: $varhash{"createuser"}
Installing php3 source to: $varhash{"wwwdir"}
 Installing auth utils to: $varhash{"phputils"}
               Stylesheet: $varhash{"css"}
 User to create databases: $varhash{"dbuser"}
 Owner of installed files: $varhash{"owner"}
 Group of installed files: $varhash{"group"}
        Using auth module: $varhash{"authmod"}
                getpwinfo: $varhash{"getpwinfo"}
               getuidinfo: $varhash{"getuidinfo"}
                  chkpass: $varhash{"chkpass"}
  SSL required for logins: $varhash{"sslreq"}
            Admin user ID: $varhash{"adminid"}
            Auth database: $varhash{"authdb"}
        Calendar database: $varhash{"caldb"}
           Read-only user: $varhash{"dbro"}
          Read-write user: $varhash{"dbrw"}
EOF

if ($varhash{"installpo"})
{
	print <<"EOF";
===
Internationalization:
           Path to msgfmt: $varhash{"msgfmt"}
    Installing locales to: $varhash{"textdomain_dir"}
Using gettext text domain: $varhash{"textdomain"}
     Using default locale: $varhash{"locale"}
    Reversing date order?: $varhash{"daybeforemonth"}
EOF
}

for $file (@filelist)
{
	print("Generating $file...\n");
	open(INFILE, "$file.in") or die "Can't open $file.in for reading";
	open(OUTFILE, ">$file") or die "Can't open $file for writing";

	while ($line = <INFILE>)
	{
		$line =~ s/\<\<([^>]*?)\>\>/$varhash{$1}/g;
		print(OUTFILE $line);
	}
	close(INFILE);
	close(OUTFILE);
}


# Prompt the user with the argument to the function, return what they enter.
sub promptUser
{
	my $prompt = shift;
	my $default = shift;
	my $result = "";

	print("$prompt " . ($default ? "[$default]" : "") . ": ");
	chomp($result = <STDIN>);

	if ($result eq "")
	{
		$result = $default;
	}

	return $result;
}

# Prompt the user with the argument to the function, returning 1 for yes,
# or 0 for no
sub promptYNUser
{
	my $prompt = shift;
	my $default = shift;
	my $result = "";

	$result = promptUser("$prompt (Y/N)", ($default ? "Y" : "N"));

	if ($result eq "")
	{
		$result = $default;
	}
	elsif (($result eq "Y") || ($result eq "y"))
	{
		$result = 1;
	}
	else
	{
		$result = 0;
	}

	return $result;
}



# Try to find the program named in the function call using which.
# If what's found is not executable, prompt the user.
sub getProgPath
{
	my $progname = shift;
	my $prog = "";

	chomp($prog = `which $progname`);

	if ( !-x "$prog" )
	{
		print("Can't find $progname.\n");
		$prog = promptUser("Please enter the full path to $progname");
		if ( !-x "$prog" )
		{
			print("\"$prog\" is not executable by the current user, but I'll take your word for it.\n");
		}
	}
	else
	{
		print("$progname found at: $prog\n");
	}

	return $prog;
}
