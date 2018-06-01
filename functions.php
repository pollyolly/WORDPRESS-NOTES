/* MOVE SCRIPTS & CSS TO BOTTOM AND TOP */
add_action( 'wp_enqueue_scripts', 'my_theme_js');
function my_theme_js() {
   remove_action('wp_head', 'wp_print_scripts');
   remove_action('wp_head', 'wp_print_head_scripts');
   remove_action('wp_head', 'wp_enqueue_scripts');

   wp_register_script('my-jsscript', get_stylesheet_directory_uri() . '/js/sample.js', array('jquery'),'1.0',true);
   wp_localize_script('my-jsscript', 'ajaxUrl', array(
      'ajax_url' => admin_url('admin-ajax.php')
   ));

   add_action('wp_footer', 'wp_print_scripts');
   add_action('wp_footer', 'wp_enqueue_scripts');
   add_action('wp_footer', 'wp_print_head_scripts');

   wp_enqueue_script('my-jsscript');
}

/* ADD CUSTOM IMAGE SIZE */
add_action( 'after_setup_theme', 'custom_imagesize' );
function custom_imagesize() {
    add_image_size( "ilcimage-size", 865, 9999 ); // 865 px wide (and max 9999 height)
    add_image_size( "ilcfeatured-image-size", 368);
}
add_filter( 'image_size_names_choose', 'ilc_imagecustom_sizes' );
function ilc_imagecustom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'ilcimage-size' => __( 'ILC Image size' ),
	'ilcfeatured-image-size' => __( 'ilc featured-image size' ),
    ) );
}
/* WP SECURITY MEASURES */
function remove_version() {
 return '';
 }
 add_filter('the_generator', 'remove_version');

 function wrong_login() {
 return 'Wrong username or password.';
 }
 add_filter('login_errors', 'wrong_login');

/* CHANGE LOGIN LOGO */
function my_login_logo() { 
?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url('');
		height:200px;
		width:200px;
		background-size: 200px 200px;
		background-repeat: no-repeat;
        	padding-bottom: 10px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
/* CHANGE WP LOGIN URL */
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
/* CHANGE ELIPSIS */
function change_excerpt_elipsis($post){
  return '<a rel="nofollow" href="'. get_permalink($post->ID) . '" target="_blank">' . '  Read more...' . '</a>';;
}
add_filter('excerpt_more', 'change_excerpt_elipsis');

/* META TAGS */
add_action('ogmeta_tags', 'add_metatags');
function add_metatags(){

?>
	<meta property="og:description" content="<?php echo 'sample'; ?>" />
    	<meta property="og:type" content="website" />
	<meta property="og:title" content="Sample Title" />
	<meta property="og:image" content="http://sample.com/wp-content/uploads/2017/06/image.jpg" />
	<meta property="og:url" content="http://sample.com" />
	<meta property="og:site_name" content="Sample Name" />
<?php } else {
	$article_link = get_permalink($post->ID);
	$featured_img = get_the_post_thumbnail_url($post->ID);
	$article_title = get_the_title($post->ID);
	//$article_excerpt = get_the_excerpt($post->ID); 
?>
	<meta property="og:description" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?php echo $article_title; ?>" />
        <meta property="og:image" content="<?php echo $featured_img; ?>" />
        <meta property="og:url" content="<?php echo $article_link; ?>" />
	<meta property="og:image:width" content="600" />
	<meta property="og:image:height" content="315" />
	<meta property="fb:app_id" content="229919550916869">
<?php
 }
}
?>



