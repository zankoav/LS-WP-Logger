=== LS WP Logger ===
Contributors: lightningsoft
Tags: log, logs, data logs
Requires at least: 5.4
Tested up to: 5.8
Stable tag: 2.0.0
Requires PHP: 7.0
License: GPLv2 or later

This plugin stores logs for your application

== Description ==

This plugin stores logs for your application with different types: *error* and *info*

== Installation ==

Upload the LS WP Logger plugin to your blog and activate it.


== How to use ==
In any php file you can use methods: 

`
Ls\Wp\Log::info("My Title", [any object]);
Ls\Wp\Log::error("My Title", [any object]);
`

or add namespace

`
use Ls\Wp\Log as Log;

Log::info("My Title", [any object]);
Log::error("My Title", [any object]);
`


== Changelog ==

= 2.0.0 =
* 
Add namespace usage.
Add pritty view for array and object values
*

= 1.0.0 =
* 
Release Date - 15 December 2020 
*