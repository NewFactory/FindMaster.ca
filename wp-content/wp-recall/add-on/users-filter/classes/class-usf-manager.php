<?php

class Usf_Manager extends Rcl_Custom_Fields_Manager{
    
    public $default_fields = array();
    
    function __construct($typeFields, $args = false) {
        
        parent::__construct($typeFields, $args);
        
        $ProfileManager = new Rcl_Profile_Fields('profile');
        
        //$this->default_fields = $ProfileManager->get_default_profile_fields();

        if($ProfileManager->fields){
            
            $types = array(
                'text',
                'textarea',
                'select',
                'multiselect',
                'checkbox',
                'radio',
                'number',
                'date',
                'dynamic',
                'runner',
                //'range'
            );
            
            foreach($ProfileManager->fields as $field){
                if(!in_array($field['type'], $types)) continue;
                $this->default_fields[] = $field;
            }
            
        }
        
        add_filter('rcl_default_custom_fields',array($this, 'add_default_filter_fields'));
        add_filter('rcl_inactive_custom_fields',array($this, 'activate_type_editor'));
        add_filter('rcl_active_custom_fields',array($this, 'activate_type_editor'));
        add_filter('rcl_custom_field_types', array($this, 'edit_field_types'), 10, 2);
        add_filter('rcl_custom_fields_form',array($this, 'add_users_page_option'));
        
    }
    
    function activate_type_editor($fields){
        foreach($fields as $k => $field){
            $fields[$k]['type-edit'] = true;
        }
        return $fields;
    }
    
    function add_default_filter_fields($fields){

        if($this->default_fields)
            $fields = array_merge($fields, $this->default_fields);

        return $fields;
        
    }

    function active_fields_box(){
        
        $content = $this->manager_form(
            
            array(
        
                array(
                    'type' => 'textarea',
                    'slug'=>'notice',
                    'title'=>__('field description','wp-recall')
                )
                
            )
  
        );
        
        return $content;
        
    }
    
    function edit_field_types($types, $field){
        
        $profileTypeField = isset($field['profile-type-field'])? $field['profile-type-field']: $field['type'];

        if(in_array($profileTypeField, array(
            'text', 'textarea'
        ))){
            $types = array(
                'text' => $types['text'],
                'textarea' => $types['textarea']
            );
        }else if(in_array($profileTypeField, array(
            'checkbox', 'multiselect'
        ))){
            $types = array(
                'select' => $types['select'],
                'radio' => $types['radio'],
                'checkbox' => $types['checkbox'],
                'multiselect' => $types['multiselect']
            );
        }else if(in_array($profileTypeField, array(
            'number', 'runner', 'range'
        ))){
            $types = array(
                'number' => $types['number'],
                'runner' => $types['runner'],
                'range' => $types['range']
            );
        }else if(in_array($profileTypeField, array(
            'select', 'radio'
        ))){
            $types = array(
                'select' => $types['select'],
                'radio' => $types['radio']
            );
        }else{
            $types = array(
                $field['type'] => $types[$field['type']]
            );
        }
        
        return $types;
    }

    function add_users_page_option($content){
        
        $content .= '<h4>'.__('Users page','wp-recall').'</h4>'
                . '<style>#users_page_rcl{max-width:100%;}</style>'
                . wp_dropdown_pages( array(
                    'selected'   => rcl_get_option('users_page_rcl'),
                    'name'       => 'users_page_rcl',
                    'show_option_none' => __('Not selected','wp-recall'),
                    'echo'             => 0 )
                )
                .'<p>'.__('Укажите страницу, на которой производится вывод пользователей через шорткод [userlist]').'</p>';
        
        $content .= '<h4>'.__('Правило подбора по параметрам').'</h4>'
                . '<p><select name="usf-relation">
                    <option '.selected(rcl_get_option('usf-relation','AND'),'AND',false).' value="AND">И</option>
                    <option '.selected(rcl_get_option('usf-relation'),'OR',false).' value="OR">ИЛИ</option>
                </select></p>'
                .'<p>'.__('Правило "ИЛИ" увеличивает нагрузку на базу данных').'</p>';
        
        return $content;
        
    }
    
}
