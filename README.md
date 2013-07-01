Fuzzy Join
==========
It is supposed to be like join known from linux/gnu/unix, but with additional to options: 
--minus M and --plus P which make it possible to fuzzy-match records with key1 and key2 as long as key2 is between key1-M and key1+P.

Why would you need that for?
For example if you have temporal data with timestamps, such as syslog, or access.log and want
to gain insight about what happened just before the crash, etc.

Usage
=====
My goal is to support the usuall options of http://linux.die.net/man/1/join.
However, to get the MVP I just chosen this small subset:

 * -1 FIELD  (defaults to first field)
 * -2 FIELD  (defaults to first field)
 * -d CHAR (defaults to "\t")

Also, by default I split on tabs (not on whitespace/non-whitespace transition) and support "-" as a nickname for php://stdin.
So to find all entries in /var/log/syslog which happen at most 2 seconds after visits to /main in access.log you could use something like this
(assuming unrealistically that in both files the first field is a linux timestamp):

     grep -f "/main" access.log | fuzzy_join.php -11 -21 -d' ' --plus 2 --minus 0 - /var/log/syslog


Installation
============
Currently it is written in PHP, which obviosuly does not make much sense, and forces you to install this crap.
However, this is a temporary sketch, just to test if the algorithm is correct, and proves valuable in realistic scenarios.
Once that's settled, I will rewrite it in C++ or something more reasonable.

If you are interested why given all possible languages in the world I had to wrote it in PHP, then ... 
well, it just happens to be the only language in which I can do explode, implode, and fopen without having to read the specification;)
