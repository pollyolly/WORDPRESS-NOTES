```
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');
/* THIS IS CUSTOM CODE CREATED AT ZEROFRACTAL TO MAKE SITE ACCESS DYNAMIC */
$currenthost = "http://".$_SERVER['HTTP_HOST'];
$currentpath = preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME']));
$currentpath = preg_replace('/\/wp.+/','',$currentpath);
define('WP_HOME',$currenthost.$currentpath);
define('WP_SITEURL',$currenthost.$currentpath);
define('WP_CONTENT_URL', $currenthost.$currentpath.'/wp-content');
define('WP_PLUGIN_URL', $currenthost.$currentpath.'/wp-content/plugins');
define('DOMAIN_CURRENT_SITE', $currenthost.$currentpath );
@define('ADMIN_COOKIE_PATH', './');

```
