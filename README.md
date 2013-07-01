Fuzzy Join
==========
It is supposed to be like join known from linux/gnu/unix, but with additional to options: 
--minus M and --plus P which make it possible to fuzzy-match records with key1 and key2 as long as key2 is between key1-M and key1+P.

Why would you need that for?
For example if you have temporal data with timestamps, such as syslog, or access.log and want
to gain insight about what happened just before the crash, etc.
