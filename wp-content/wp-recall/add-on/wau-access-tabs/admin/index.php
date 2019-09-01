<?php

add_filter('wau_options_array', 'wat_add_settings', 10);
function wat_add_settings($fields){
    global $rcl_tabs;
    
    if($rcl_tabs){
        
        $settings = array();
        foreach($rcl_tabs as $tab_id => $tab){
            $settings[$tab_id] = $tab['name'];
        }
        
        $fields[] = array(
            'type' => 'checkbox',
            'slug' => 'open-tabs',
            'title' => __('Вкладки доступные всем'),
            'values' => $settings,
            'notice' => __('Укажите вкладки личного кабинета, которые будут доступны всем пользователям независимо от доступа.')
        );
        
    }
    
    return $fields;
}

add_filter('wau_account_fields', 'wat_add_settings_account', 10, 2);
function wat_add_settings_account($fields, $account){
    global $rcl_tabs;
    
    if($rcl_tabs){
        
        $WAUOptions = get_option('wau_options');
        
        $openTabs = isset($WAUOptions['open-tabs'])? $WAUOptions['open-tabs']: array();
        
        $settings = array();
        foreach($rcl_tabs as $tab_id => $tab){
            if($openTabs && in_array($tab_id, $openTabs)) continue;
            $settings[$tab_id] = $tab['name'];
        }
        
        $fields[] = array(
            'type' => 'checkbox',
            'slug' => 'meta[open-tabs]',
            'title' => __('Доступ к вкладкам личного кабинета'),
            'values' => $settings,
            'default' => $account? wau_get_meta($account->account_id, 'account', 'open-tabs'): '',
            'notice' => __('Укажите вкладки личного кабинета доступные для этого аккаунта доступа.')
        );
        
    }
    
    return $fields;
}

add_action('wau_save_account', 'wat_save_account_tabs', 10);
function wat_save_account_tabs($account_id){
    
    if(isset($_POST['meta']['open-tabs']) && $_POST['meta']['open-tabs']){
        wau_update_meta($account_id, 'account', 'open-tabs', $_POST['meta']['open-tabs']);
    }else{
        wau_delete_meta($account_id, 'account', 'open-tabs');
    }
    
}