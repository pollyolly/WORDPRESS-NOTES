#all php files will be readonly, (note php files in readonly can execute script but in readonly means you cannot write directly to php file ie. adding code from command.)
```
sudo find . -type f -exec chmod 644 {} +
```
#all folders will be 755 which means wordpress can read, write, edit, delete
```
sudo find . -type d -exec chmod 755 {} +
```
#wp-config.php will be read only
```
chmod 660 wp-config.php 
```
