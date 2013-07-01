Fuzzy Join
==========
It is supposed to be like join known from linux/gnu/unix, but with additional to options: 
--minus M and --plus P which make it possible to fuzzy-match records with key1 and key2 as long as key2 is between key1-M and key1+P.

Why would you need that for?
For example if you have temporal data with timestamps, such as syslog, or access.log and want
to gain insight about what happened just before the crash, etc.

Installation
============
Currently it is written in PHP, which obviosuly does not make sense, and forces you to install this crap.
However, this is a temporary sketch, just to test if the algorithm is correct, and proves valuable in realistic scenarios.
Once that's settled, I will rewrite it in C++ or something more reasonable.

If you are interested why given all possible languages of the world I had to wrote it in PHP, then ... 
well, it just happens to be the only language in which I can do explode, implode, and fopen without having to read the specification;)
