#wp_opcache
#php.ini
opcache.enable=1
#check timestamp of each file if modified to update the cache for each file.
opcache.validate_timestamps=1
#in secs. check timestamp for changes to shared memory storage allocation.
opcache.revalidate_freq=60 
#max number of scripts to cache
opcache.max_accelerated_files=10000 
#allocated memory for opcache
opcache.memory_consumption=64 
#reduces memory and improve performance by storing duplicate strings in the code in a single variable
opcache.interned_strings_buffer=8 
#enable shutdown sequence. used for accelerated code. (disable if problem occured)
opcache.fast_shutdown=1 
