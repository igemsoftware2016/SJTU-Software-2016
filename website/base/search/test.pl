#!/usr/bin/perl

use DBI;

my $dbname = "base";
my $host = "115.159.215.213";
my $port = "3306"; 
my $database = "DBI:mysql:$dbname:$host:$port";
my $username = "root";
my $password = "sjtuigem2016";
my $dbh = DBI->connect($database,$username,$password) || die "connection failed: ". DBI->errstr;
$dbh->disconnect();
    exit(0);
