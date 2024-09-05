## WORDPRESS NOTES

### Nginx and WP Super Cache
```nginx
server {
    gzip on;
    gzip_types      text/plain application/xml;
    gzip_proxied    no-cache no-store private expired auth;
    gzip_min_length 1000;
}

server {
	listen 80;
	listen [::]:80;

	#server_name portfolio.iwebitechnology.xyz *.portfolio.iwebitechnology.xyz;
	return 301 https://portfolio.iwebitechnology.xyz$request_uri;
}

server {
	listen 443 ssl;

        server_name portfolio.iwebitechnology.xyz *.portfolio.iwebitechnology.xyz;
	#server_name iwebitechnology.xyz *.iwebitechnology.xyz;

        root /var/www/html/wp_portfolio;
        index index.php index.html;

	access_log /var/log/nginx/wpportfolio_access.log;
    	error_log  /var/log/nginx/wpportfolio_error.log debug;

    	#RSA certificate
        #ssl_certificate /etc/letsencrypt/live/portfolio.iwebitechnology.xyz/fullchain.pem;
        #ssl_certificate_key /etc/letsencrypt/live/portfolio.iwebitechnology.xyz/privkey.pem;
	#include /etc/letsencrypt/options-ssl-nginx.conf;

	ssl_certificate /etc/cloudflare_ssl/cert.pem;
        ssl_certificate_key /etc/cloudflare_ssl/key.pem;
        
	#Start WP Super Cache
	set $cache_uri $request_uri;

    	# POST requests and URLs with a query string should always go to PHP
    	if ($request_method = POST) {
        	set $cache_uri 'null cache';
    	}  
    	if ($query_string != "") {
        	set $cache_uri 'null cache';
    	}   

    	# Don't cache URIs containing the following segments
    	if ($request_uri ~* "(/wp-admin/|/xmlrpc.php|/wp-(app|cron|login|register|mail).php
                          |wp-.*.php|/feed/|index.php|wp-comments-popup.php
                          |wp-links-opml.php|wp-locations.php |sitemap(_index)?.xml
                          |[a-z0-9_-]+-sitemap([0-9]+)?.xml)") {

        	set $cache_uri 'null cache';
    	}  
	
    	# Don't use the cache for logged-in users or recent commenters
    	if ($http_cookie ~* "comment_author|wordpress_[a-f0-9]+
                         |wp-postpass|wordpress_logged_in") {
        	set $cache_uri 'null cache';
    	}

	# Use cached or actual file if it exists, otherwise pass request to WordPress
    	location / {
        	try_files /wp-content/cache/supercache/$http_host/$cache_uri/index.html 
			  #.htaacess support and default wordpress redirection if cache not available
			  $uri $uri/ /index.php?$args;
    	} 
	#End WP Super Cache

        location = /favicon.ico {
                log_not_found off;
                access_log off;
        }

        location = /robots.txt {
                allow all;
                log_not_found off;
                access_log off;
        }

        #location / {
        #        try_files $uri $uri/ /index.php?$args;
        #}

	#location / {
        #	try_files $uri $uri/ /index.php?$args;
	#}
        # THIS NEEDS TO BE AT THE BOTTOM BEFORE OTHER PHP CONFIGS
        location ~ \.php$ {
		#fastcgi_split_path_info ^(/wp_hotel_booking)(/.*)$; #subdirectory
                #NOTE: You should have "cgi.fix_pathinfo = 0;" in php.ini
                include fastcgi_params;
                fastcgi_intercept_errors on;
                #fastcgi_pass php;
		#fastcgi_pass unix:/run/php/php7.4-fpm.sock;
                fastcgi_pass unix:/run/php/php8.1-fpm.sock;
		fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }

        #location ~* \.(js|css|png|jpg|jpeg|gif|ico)$ {
        #        expires max;
        #        log_not_found off;
        #}
	#Start WP Super Cache
	# Cache static files for as long as possible
    	location ~* \.(ogg|ogv|svg|svgz|eot|otf|woff|mp4|ttf|css|rss|atom|js|jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|doc|xls|exe|ppt|tar|mid|midi|wav|bmp|rtf)$ {
        	expires max;
        	log_not_found off;
        	access_log off;
    	}
	#End WP Super Cache
}
```
### Security Settings
- make sure you have right [folder permissions](https://github.com/pollyolly/WORDPRESS-NOTES/blob/master/wordpress-files-folder-permissions.md)
- always update to latest version
- use wp-login [Login Recaptcha](https://wordpress.org/plugins/login-recaptcha/) or [Login Security Captcha](https://wordpress.org/plugins/login-security-recaptcha/)
- use wp-config [Generate Salt](https://api.wordpress.org/secret-key/1.1/salt/)
- restrict access to .config files and .htaccess
```nginx
## Disable .htaccess and other hidden files; Allow .well-known for letsencrypt
   location ~ /\.well-known { 
    allow all;
    }
   location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }
```
- use [Lets Encrypt](https://certbot.eff.org/) or [Cloudflare SSL](https://www.cloudflare.com/application-services/products/ssl/)
- clean URL using Permalinks: %category%/%postname%
- hide wp-login url using [WPS Hide](https://wordpress.org/plugins/wps-hide-login/)
- use logs user activity using [WP Activity Log](https://wordpress.org/plugins/wp-security-audit-log/)
- disable php error reporting
```php
<?php
error_reporting(0);
@ini_set(‘display_errors’, 0);
```
- turn off debugging
```php
<?php
define( 'DISALLOW_FILE_EDIT', true );
```
- turn off file editing
```php
<?php
define( 'DISALLOW_FILE_EDIT', true );
```
- deny accessing xmlrpc
```nginx
location = /xmlrpc.php {
    deny all;
    access_log off;
    log_not_found off;
    return 403; #404
}
```
- deny accessing php files in a folder
```nginx
location ~* (/wp-content/.*\.php$|/wp-includes/.*\.php$|/xmlrpc\.php$|/(?:uploads|files)/.*\.php$|/\.ht|^/\.user\.ini) {
            deny all;
            access_log off;
            log_not_found off;
        }
```
- allow single IP Address to access wp-login (only for static IP's)
```nginx
location ~ ^/(wp-admin|wp-login\.php) {
                allow 1.2.3.4;
                deny all;
}
```
### Security Scanner
[WPScan](https://github.com/wpscanteam/wpscan)
