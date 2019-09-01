<?php

if (!defined('ABSPATH')) exit;
/* схема */

      
add_action ( 'wp_head', 'yworld_article_add_json_markup', 0 );


function yworld_article_add_json_markup(){
    global $post;
	if(rcl_get_option('on_off_ywsa')!=1) return false;
	if(!is_singular() || $post->post_type!='post') return false;
	$ratingBox = new Rcl_Rating_Box(array(
        'rating_type' => 'post', //тип записи
        'object_id' => $post->ID, //ИД записи
        'object_author' => $post->post_author //автор записи
    ));

    //тут инициализируем все данные
    $ratingBox->setup_box();

    //максимальный рейтинг
    $ratingBox->vote_max;

    //кол-во голосов
    $ratingBox->vote_count;

    //минимальное значение
    $item_value = round( $ratingBox->vote_max / $ratingBox->item_count, 1 );

    //среднее значение всех голосов (выводится для звезд в качестве значения)
    $average_rating = $ratingBox->vote_count? round( $ratingBox->total_rating / $ratingBox->vote_count, 1 ): 0;

      $schema_name = rcl_get_option('ywsa_scheme_org');
      $schema_article_type = rcl_get_option('ywsa_scheme_selection');
      $schema_logo = rcl_get_option('ywsa_logo_img');
      $schema_image = rcl_get_option('ywsa_scheme_img');
      $images = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
      if( isset($images) && empty($images) ) {
        $images[0] = $schema_image;
      }
      if( empty($schema_article_type) ) {
        $schema_article_type = "Article";
      }
      $excerpt = $post->post_excerpt;
      $content = wp_trim_words($post->post_content , '25', '...');
	  $description = $excerpt;
	   if (empty($excerpt)){
       $description = $content;
      }
	  
      $schema_post_id = site_url() . str_replace(site_url(), "",get_permalink($post->ID));
      $args = array(
        "@context" => "http://schema.org",
        "@type"    => $schema_article_type,
        "mainEntityOfPage" => array(
          "@type" => "WebPage",
          "@id"   => $schema_post_id
        ),
        "headline" => $post->post_title,
        "image"    => array(
          "@type"  => "ImageObject",
          "url"    => $images[0],
          "width"  => "auto",
          "height" => "auto"
        ),
        "datePublished" => get_the_time( DATE_ISO8601, $post->ID ),
        "dateModified"  => get_post_modified_time(  DATE_ISO8601, __return_false(), $post->ID ),
        "author" => array(
          "@type" => "Person",
          "name"  => get_the_author_meta( 'display_name', $post->post_author )
        ),
        "publisher" => array(
          "@type" => "Organization",
          "name"  => $schema_name,
          "logo"  => array(
            "@type"  => "ImageObject",
            "url"    => $schema_logo,
            "width"  => "auto",
            "height" => "auto"
          )
        ),
		"aggregateRating" => array(
          "@type" => "AggregateRating",
          "bestRating"  =>  $ratingBox->vote_max,
          "worstRating"  =>  "$item_value",
          "ratingValue"  =>  "$average_rating",
          "ratingCount"  =>  $ratingBox->vote_count
       ),
        "description" => $description
      );
      

echo '<script type="application/ld+json">' , PHP_EOL;
    echo json_encode( $args, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) , PHP_EOL;
    echo '</script>' , PHP_EOL;
  }
//фикс для яндекса  
//function yw_yandex_fix($lang) {
//if(rcl_get_option('ywsa_yandex_fix')!=1) return false;
//$lang_prefix = 'prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article# profile: http://ogp.me/ns/profile# fb: http://ogp.me/ns/fb#"';
//$lang_fix = preg_replace('!prefix="(.*?)"!si', $lang_prefix, $lang);
//return $lang_fix;
//}
//add_filter( 'language_attributes', 'yw_yandex_fix',20,1);