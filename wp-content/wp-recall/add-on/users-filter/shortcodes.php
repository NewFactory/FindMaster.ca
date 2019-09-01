<?php

add_shortcode('rcl-users-filter', 'usf_get_form');
function usf_get_form($atts = false){
    global $wpdb;

    extract(shortcode_atts(array(
        'column'=> 1
    ),
    $atts));

    $fields = usf_get_form_fields();

    if(!$fields) return '<p>'.__('Поисковая форма не была сформирована или поля формы не были найдены.').'</p>';

    foreach($fields as $k => $field){

        $fields[$k]['value_in_key'] = true;

        if(isset($_GET[$field['slug']])){
            $fields[$k]['default'] = $_GET[$field['slug']];
        }

    }

    $fields[] = array(
        'type' => 'hidden',
        'slug' => 'usf',
        'value' => '1'
    );

    $content = '<div class="usf-form column-'.$column.'">';

    $content .= rcl_get_form(array(
        'fields' => $fields,
        'method' => 'get',
        'action' => get_permalink(rcl_get_option('users_page_rcl')),
        'submit' => __('Искать')
    ));

    $content .= '</div>';

    return $content;

}

/*add_shortcode('my-users-filter', 'my_get_form');
function my_get_form($atts = false){
    global $wpdb;

    extract(shortcode_atts(array(
        'column'=> 1
    ),
    $atts));

    $fields = usf_get_form_fields();

    if(!$fields) return '<p>'.__('Поисковая форма не была сформирована или поля формы не были найдены.').'</p>';

    foreach($fields as $k => $field){

        $fields[$k]['value_in_key'] = true;

        if(isset($_GET[$field['slug']])){
            $fields[$k]['default'] = $_GET[$field['slug']];
        }

    }

    $fields[] = array(
        'type' => 'hidden',
        'slug' => 'usf',
        'value' => '1'
    );

    $content = '<div class="usf-form column-'.$column.'">';

    $content .= rcl_get_form(array(
        'fields' => $fields,
        'method' => 'get',
        'onclick' => "my_send_form_data(\"my_ajax_get_userlist\", this);return false;",
        'submit' => __('Искать')
    ));

    $content .= '</div>';

    return $content;

}

rcl_ajax_action('my_ajax_get_userlist', false);
function my_ajax_get_userlist(){
    global $rcl_user,$rcl_users_set,$user_ID;

    require_once RCL_PATH.'classes/class-rcl-users-list.php';

    $users = new Rcl_Users_List(array('template'=>'rows'));

    $count_users = false;

    if(!isset($atts['number'])){

        $count_users = $users->count();

        $id_pager = ($users->id)? 'rcl-users-'.$users->id: 'rcl-users';

        $pagenavi = new Rcl_PageNavi($id_pager,$count_users,array('in_page'=>$users->query['number']));

        $users->query['offset'] = $pagenavi->offset;
    }

    usf_edit_users_query($users->query);

    $usersdata = $users->get_users();

    $userlist = $users->get_filters($count_users);

    $userlist .= '<div class="rcl-userlist">';

    if(!$usersdata){
        $userlist .= '<p align="center">'.__('Users not found','wp-recall').'</p>';
    }else{

        if(!isset($atts['number']) && $pagenavi->in_page)
            $userlist .= $pagenavi->pagenavi();

        $userlist .= '<div class="userlist '.$users->template.'-list">';

        $rcl_users_set = $users;

        foreach($usersdata as $rcl_user){ $users->setup_userdata($rcl_user);
            $userlist .= rcl_get_include_template('user-'.$users->template.'.php');
        }

        $userlist .= '</div>';

        if(!isset($atts['number']) && $pagenavi->in_page)
            $userlist .= $pagenavi->pagenavi();

    }

    $userlist .= '</div>';

    $users->remove_filters();

    wp_send_json(array(
        'content' => $userlist
    ));
}*/