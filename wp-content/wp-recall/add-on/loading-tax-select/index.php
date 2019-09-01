<?php

require_once 'class-lts-field.php';

if (is_admin())
    require_once 'admin/index.php';

if (!is_admin()):
    add_action('rcl_enqueue_scripts','lts_scripts',10);
endif;

function lts_scripts(){
    rcl_enqueue_style('ocs-style', rcl_addon_url('style.css', __FILE__));
    rcl_enqueue_script('lts-scripts', rcl_addon_url('js/scripts.js', __FILE__));
}

add_filter('rcl_public_form_fields', 'lts_add_public_fields', 10, 3);
function lts_add_public_fields($fields, $formData, $class){

    $taxField = array();

    if($class->taxonomies){

        foreach($class->taxonomies as $taxname => $object){

            $taxField[] = 'lts-'.$taxname;

        }

    }

    foreach($fields as $k => $field){

        if($class->taxonomies && in_array($field['slug'],$taxField)){

            foreach($class->taxonomies as $taxname => $object){

                if($field['slug'] == 'lts-'.$taxname) break;

            }

            $lts = new LTS_Field($taxname, $field['level-names'], $formData->post_id);

            $fields[$k]['content'] = $lts->get_content();

        }

    }

    return $fields;

}

rcl_ajax_action('lts_ajax_get_children_items', true);
function lts_ajax_get_children_items(){

    rcl_verify_ajax_nonce();

    $taxonomy = $_POST['taxonomy'];
    $level = $_POST['level'];
    $form_id = $_POST['form_id'];
    $post_id = $_POST['post_id'];
    $post_type = $_POST['post_type'];
    $term_id = $_POST['term_id'];

    $formFields = new Rcl_Public_Form_Fields(array(
        'post_type' => $post_type,
        'form_id' => $form_id
    ));

    $content = false;

    if($formFields->exist_active_field('lts-'.$taxonomy)){

        $field = $formFields->get_field('lts-'.$taxonomy);

        $lts = new LTS_Field($taxonomy, $field['level-names']);

        $content = $lts->get_field_content($term_id);

    }

    wp_send_json(array(
        'content' => $content
    ));

}