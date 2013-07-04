Fuzzy Join
==========
It is supposed to be like join known from linux/gnu/unix, but with additional two options: 
--minus M and --plus P which make it possible to fuzzy-match records with key1 and key2 as long as key2 is between key1-M and key1+P.

What would you need it for?
For example if you have temporal data with timestamps, such as syslog, or access.log and want
to gain insight into what happened just before the crash, etc.
Or if you want to find users who visited main page and then magically got back to login page.
Or if you need to corelate slowlog with OOM errors in syslog.

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


Idea
====
Quite straightforward: I read both files in a single pass, maintaining a small buffor for the second file, 
just large enough to hold all elements which match the current element from the first file.
Each time I advance one line in the first file, I add some lines to the end of the buffer and remove some lines from its begining.
The nice thing is that the time is linear in output plus input size, and memory consumption depends only on the
longest match.
You can try to reverse the roles of the first and the second file (remember to switch --plus and --minus options as well) 
if you hit memory issues.

Installation
============
Currently it is written in PHP, which obviosuly does not make much sense, and forces you to install this crap.
However, this is a temporary sketch, just to test if the algorithm is correct, and proves valuable in realistic scenarios.
Once that's settled, I will rewrite it in C++ or something more reasonable.

If you are interested why given all possible languages in the world I had to wrote it in PHP, then ... 
well, it just happens to be the only language in which I can do explode, implode, and fopen without having to read the specification;)
