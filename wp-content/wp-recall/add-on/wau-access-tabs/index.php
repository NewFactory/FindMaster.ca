<?php

if(is_admin()){
    require_once 'admin/index.php';
}

if(!is_admin()){ 
    add_filter('rcl_tabs','wat_check_current_user_tab_view', 10);
}
function wat_check_current_user_tab_view($tabs){
    global $user_ID;
    
    if(current_user_can('manage_options')) return $tabs;

    $openTabs = wat_get_current_user_open_tabs();
    
    foreach($tabs as $tab_id => $tab){
        
        if($openTabs && in_array($tab_id, $openTabs)) continue;
        
        $tabs[$tab_id]['public'] = rcl_is_office($user_ID)? -1: 0;

    }

    return $tabs;
}

function wat_get_current_user_open_tabs(){
    global $WAU_User;
    
    $WAUOptions = get_option('wau_options');
        
    $openTabs = isset($WAUOptions['open-tabs'])? $WAUOptions['open-tabs']: array();
    
    if(!$WAU_User->branch_accounts) return $openTabs;
    
    $branchMetas = wau_get_metas(array(
        'object_type' => 'account',
        'object_id__in' => $WAU_User->branch_accounts,
        'meta_key' => 'open-tabs',
        'fields' => array('meta_value')
    ));

    if($branchMetas){
        
        $branchTabs = array();
        foreach($branchMetas as $meta){
            $branchTabs = array_merge($branchTabs, maybe_unserialize($meta->meta_value));
        }
        
        if($branchTabs){
            $openTabs = array_merge($openTabs, array_unique($branchTabs));
        }

    }
    
    return $openTabs;
    
}