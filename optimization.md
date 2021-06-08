### Optimize Database
wp-config.php
```
define('DISALLOW_FILE_EDIT', true);
define('WP_POST_REVISIONS', 10);
define('EMPTY_TRASH_DAYS', 7);
```
images
```
1. Limit images upload to 300kb below
2. Match the images witdth to container total width
   i.e. div.width { width: 500px; }  /* uploaded images should only have max with 500px */
```
Cache Tools
```
SwiftLite Settings
MEDIA
    Images
      Images Source = Media Library
      Serve WebP = Don't Use WebP
      Preload Sensitivity = 50
    Embeds
      Lazy Load Iframes = true
      Respect Lazyload Standards = true
      Preload Sensitivity = 50
OPTIMIZATION
    General
      Optimize Prebuild Only = true
      Prefetch DNS = true
      Normalize Static Resources = true
    HTML
      Fix Invalid HTML = true
      inify HTML = true
CACHING
    General
      Enable Caching = true
      Early Loader = true
      Cache Path = /var/www/html/ilcweb2020/wp-content/cache/
      Cache Expiry Mode = Time based mode
      Cache Expiry Time = 12hrs
      Garbage Collection Interval = 30min
      Enable Browser Cache = true
      Enable Gzip = true
      Cache 404 pages = true
      AJAX Cache Expiry Time = 1440
    Tweaks
      Strict Host = true
    Ajaxify
      Preload Sensitivity = 50
      Ajaxify Placeholder = Blurred
    Exception
      Exclude Author Pages = true
      Exclude REST URLs = true
      Exclude Feed = true
    Warmup
      Prebuild Cache Automatically = true
      Prebuild Speed = Moderate
      Warmup Table Source = Auto
      URLs per page = 30
      Prebuild Archive true
      Prebuild Terms = true
```
