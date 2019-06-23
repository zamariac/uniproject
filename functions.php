<?php

function pageBanner($args = NULL){
   //php logic will live here

   if (!$args['title']){
      $args['title'] = get_the_title();
   }

   if(!$args['subtitle']){
      $args['subtitle'] = get_field('page_banner_subtitle');
   }

   if(!$args['photo']){
      if(get_field('page_banner_image')){
         $args['photo'] = get_field('page_banner_image')['sizes']['pageBanner'];
      } else {
         $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
      }
   }

   ?>

<!-- <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php $pageBannerImage = get_field('page_banner_image'); echo $pageBannerImage['sizes']['pageBanner'] ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"> <?php echo $args['title'] ?></h1>
            <div class="page-banner__intro"> 
                <p><?php echo $args['subtitle'] ?></p>
        </div>
    </div>  
</div> -->
   
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"> <?php echo $args['title'] ?></h1>
            <div class="page-banner__intro"> 
                <p><?php echo $args['subtitle'] ?></p>
        </div>
    </div>  
</div>

<?php }


function uniproject_files(){
   wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyAY0TKx_jcO7Dd-cX9MccCwbPD_L3vTM0I', NULL, 1.0, 'true');
    wp_enqueue_script('main_uniproject_js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, 1.0, 'true');
    wp_enqueue_style('custom_google_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('fontawesome_link', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('uniproject_main_styles', get_stylesheet_uri(), NULL, 1.0); 

}


 add_action('wp_enqueue_scripts', 'uniproject_files');


 function uniproject_features(){
    add_theme_support('title-tag');
    //register_nav_menu('headerMenuLocation', 'Header Menu Location');
    //register_nav_menu('footerLocationOne', 'Footer Location One');
    //register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, array('left', 'top'));
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
    
 }

 add_action('after_setup_theme', 'uniproject_features');
  
 function uniproject_adjust_queries($query){
    if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
         $query->set('orderby', 'title');
         $query->set('order', 'ASC');
         $query->set('post_per_page', -1);
      }
    if(!is_admin() AND is_post_type_archive('eventy') AND $query->is_main_query()){
        $today = date('Ymd'); 
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
               'key' => 'event_date', 
               'compare' => '>=',
               'value' => $today,
               'type' => 'numeric'

            )
            ));
 }

}
 add_action('pre_get_posts', 'uniproject_adjust_queries');

 function uniMapKey($api){
    $api['key'] = 'AIzaSyAY0TKx_jcO7Dd-cX9MccCwbPD_L3vTM0I';
    return $api;
 }
 add_filter('acf/fields/google_map/api', 'uniMapKey');
?>