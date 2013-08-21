CookieCatcher
=============

CookieCatcher is an open source application which was created to assist in the exploitation of XSS (Cross Site Scripting) vulnerabilities within web applications to steal user session IDs (aka Session Hijacking). The use of this application is purely educational and should not be used without proper permission from the target application.

For more information on XSS visit the following link:
https://www.owasp.org/index.php/Cross-site_Scripting_(XSS)

For more information on Session Hijacking visit the following link:
https://www.owasp.org/index.php/Session_hijacking_attack

Features
-------
* Prebuilt payloads to steal cookie data
* Just copy and paste payload into a XSS vulnerability
* Will send email notification when new cookies are stolen
* Will attempt to refresh cookies every 3 minutes to avoid inactivity timeouts
* Provides full HTTP requests to hijack sessions through a proxy (BuRP, etc)
* Will attempt to load a preview when viewing the cookie data
* PAYLOADS
* * Basic AJAX Attack
* * HTTPONLY evasion for Apache CVE-20120053
* * More to come

Requirements
------------

CookieCatcher is built for a LAMP stack running the following:

* PHP 5.x.x
* PHP-cURL
* MySQL
* Lynx & crontab

Installation
------------
* Download the source from github `git clone https://github.com/DisK0nn3cT/CookieCatcher.git` or use the ZIP file and extract it on your server. 
* Setup the directory as a virtualhost in Apache (I won't go over these details, however, you may ask me via email it google it.)
* Create a database for the application and load the SETUP.sql file.
* Setup a cron job as shown in the SETUP.cron file.

DEMO
----
A demo of the application can be viewed at http://m19.us. Small domain names are recommended to cut down on the character space needed for the payloads.

Contribute
----------
If you have ideas or suggestions on how to improve upon the existing application and would like to offer your time, please contact me via email.

Credits
-------
@disk0nn3ct - Author
danny.chrastil@gmail.com
