=== Reverse-Proxy Comment IP Fix ===
Contributors: gnotaras
Donate link: http://www.g-loaded.eu/about/donate/
Tags: reverse-proxy, x-forwarded-for, proxy, server, comments
Requires at least: 1.5.2
Tested up to: 4.5
Stable tag: 0.2.0
License: Apache License v2
License URI: http://www.apache.org/licenses/LICENSE-2.0.txt

Sets the comment IP to the client IP provided by the X-Forwarded-For or X-Real-IP headers before the comment is saved to the database.


== Description ==

Sets the comment IP to the client IP provided by the X-Forwarded-For or X-Real-IP headers before the comment is saved to the database.


= Official Project Homepage =

The Reverse-Proxy Comment IP Fix project information and documentation has been moved to the [Reverse-Proxy Comment IP Fix Development Web Site](http://www.codetrax.org/projects/reverse-proxy-comment-ip-fix/wiki).


== Installation ==

1. Extract the compressed (zip) package in the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Does this just work? =

Yes.

== Changelog ==

Please read the dynamic [changelog](http://www.codetrax.org/projects/reverse-proxy-comment-ip-fix/roadmap "Reverse-Proxy Comment IP Fix ChangeLog")

- [0.2.0](http://www.codetrax.org/versions/358)
 - Major refactoring.
 - IP validation supporting both IPv4 and IPv6.
 - Support for the X-Real-IP header in addition to the X-Forwarded-For.
- [0.1.1](http://www.codetrax.org/versions/219)
 - Updated plugin metadata for compatibility with WordPress 3.8.X
- [0.1.0](http://www.codetrax.org/versions/124)
 - Initial release
