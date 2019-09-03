<?php
//profile progress

rcl_block('top','otfm_count_procent');
rcl_block('top','otfm_count_procent_avatar');
rcl_block('actions','otfm_count_procent_menu');
add_action('counters','otfm_count_procent_counters');
add_action('rcl_setup_tabs','rating_procent_add_subtab',10);

function otfm_count_procent(){
    global $user_ID;
//	global  $rcl_options;
    if(!rcl_is_office($user_ID)) return false; // мы не в своем кабинете
    
    // что имеем в таблице usermeta
    $all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_ID) );
    $user = get_userdata($user_ID); // добавим из таблицы users данные
    $full_meta_user = array_merge((array)$user->data, $all_meta_for_user);// объединим массивы
    $full_meta_user_clear = array_filter($full_meta_user); // очистим массив от пустых ключей

    // что ищем (у меня все есть нет тока user_url)
    $who_search = explode(',',rcl_get_option('rcl_progress_metakey'));
    $who_search = array_map('trim',$who_search);
    
    // что нашли (нашел я 3 только - т.к. выше нет тока user_url у меня)
    $who_find = 0;
    foreach ($who_search as $one){
        if($one && array_key_exists($one, $full_meta_user_clear)){
            $who_find++;
        }
    }
    $count_search = count($who_search); // сколько у нас значений
    // математика
	global $procent;
//    $procent = 100 / $count_search * $who_find;
	$procent = ceil(100 / $count_search * $who_find);
	
		$content = '<div class="'.rcl_get_option('rcl_progress_enable').'"><div id="i-have-a-tooltip" data-description="'.rcl_get_option('rcl_progress_tooltip').'"><p style="color:'.rcl_get_option('color_font_name').';background-color:'.rcl_get_option('color_background_name').';" class="profile-progress-text">'.rcl_get_option('rcl_progress_text').'</p></div>
				  	<div class="profile-progress-bar" role="progressbar" aria-valuenow="'.$procent.'" aria-valuemin="0" aria-valuemax="100" style="color:'.rcl_get_option('color_font_interest').';background-color:'.rcl_get_option('color_background_scale').';width:'.$procent.'%">
				   '.$procent.'%
				  	</div>
				</div>';
		if ($procent == 100) {
 $content = '<div class="profile-progress-img '.rcl_get_option('rcl_progress_enable').'" style="top:'.rcl_get_option('rcl_progress_top').'%;"><img src="'.rcl_get_option('rcl_progress_img').'" alt="Ваш профиль полностью заполнен" title="Ваш профиль полностью заполнен"></div>';
}		
return $content;				
}
add_action('init', 'otfm_count_procent');
// без картинки над аватарой
function otfm_count_procent_avatar(){
	global $user_ID;
	global $procent;
//	global  $rcl_options;
    if(!rcl_is_office($user_ID)) return false; // мы не в своем кабинете
$content = '<div class="'.rcl_get_option('rcl_progress_enable3').'"><div id="i-have-a-tooltip" data-description="'.rcl_get_option('rcl_progress_tooltip').'"><p style="color:'.rcl_get_option('color_font_name').';background-color:'.rcl_get_option('color_background_name').';" class="profile-progress-text">'.rcl_get_option('rcl_progress_text').'</p></div>
				  	<div class="profile-progress-bar" role="progressbar" aria-valuenow="'.$procent.'" aria-valuemin="0" aria-valuemax="100" style="color:'.rcl_get_option('color_font_interest').';background-color:'.rcl_get_option('color_background_scale').';width:'.$procent.'%">
				   '.$procent.'%
				  	</div>
				</div>';		
return $content;				
}
add_action('init', 'otfm_count_procent_avatar');
//в меню
function otfm_count_procent_menu(){
	global $user_ID;
	global $procent;
//	global  $rcl_options;
    if(!rcl_is_office($user_ID)) return false; // мы не в своем кабинете
	$content = '<span class="'.rcl_get_option('rcl_progress_enable2').'"style="background-color:'.rcl_get_option('color_background_name').';"><a href="'.rcl_format_url(get_author_posts_url($user_ID),'rating&subtab=rating-procent').'" title="Посмотреть подробности"><div class="profile-progress-menu-text" style="color:'.rcl_get_option('color_font_interest').'"><i class="fa fa-id-card"></i>&nbsp;'.rcl_get_option('rcl_progress_text').' '.$procent.'%</div></span></a>';
				
return $content;			
				
}
//add_action('init', 'otfm_count_procent_menu');

// в рейтинг
function rating_procent_add_subtab(){
 
   $subtab = array(
        'id'=> 'rating-procent',
        'name'=> 'Заполненность профиля',
        'icon' => 'fa-id-card',
		'public'=>1,
        'callback'=>array(
            'name'=>'otfm_count_procent_subtab'
        )
    );
   
    rcl_add_sub_tab('rating',$subtab);
}
function otfm_count_procent_subtab(){
    global $user_ID;
//	global  $rcl_options;
    if(!rcl_is_office($user_ID)) return false; // мы не в своем кабинете
    global $procent;
	
		$content = '<div class="profile-progress-profile"><p>'.rcl_get_option('rcl_progress_tooltip').'</p><div><p style="color:'.rcl_get_option('color_font_name').';background-color:'.rcl_get_option('color_background_name').';" class="profile-progress-text">'.rcl_get_option('rcl_progress_text').'</p></div>
				  	<div class="profile-progress-bar" role="progressbar" aria-valuenow="'.$procent.'" aria-valuemin="0" aria-valuemax="100" style="color:'.rcl_get_option('color_font_interest').';background-color:'.rcl_get_option('color_background_scale').';width:'.$procent.'%">
				   '.$procent.'%
				  	</div>
				</div>';
return $content;				
}
add_action('init', 'otfm_count_procent_subtab');	