### Load CSS Asynchronous
function.php
```

add_filter('style_loader_tag','add_preload_plugins_themes',10,2);
function add_preload_plugins_themes($html, $handle){
        if(strpos($handle, 'elementor') == 0){
                $preloading = 'rel="preload" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" data-async-style';
                $html = str_replace('rel=\'stylesheet\'',$preloading,$html);
        }
        return $html;
}
```
script.js
```
$("[data-async-style]").each(function(){
        loadCSS($(this).attr('href'));
});
function loadCSS( href, before, media ){
        "use strict";
        var ss = window.document.createElement( "link" );
        var ref = before || window.document.getElementsByTagName( "script" )[ 0 ];
        ss.rel = "stylesheet";
        ss.href = href;
        ss.media = "only x";
        ref.parentNode.insertBefore( ss, ref );
        setTimeout( function(){
                ss.media = media || "all";
        } );
        return ss;
}
```
