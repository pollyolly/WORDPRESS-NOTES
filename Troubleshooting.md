Reset admin password 

1. Access phpmyadmin
2. In wp_users update username and passwords. 
```
UPDATE `wp_users` SET `user_pass` = MD5( 'new_password' ) WHERE `wp_users`.`user_login` = "admin_username";
```
3. Now, access the wp-login.php in the url.
