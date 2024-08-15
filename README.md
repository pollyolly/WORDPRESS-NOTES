### WORDPRESS NOTES

### Nginx
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
