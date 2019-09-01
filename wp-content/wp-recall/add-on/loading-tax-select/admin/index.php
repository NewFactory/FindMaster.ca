<?php

add_filter('rcl_default_public_form_fields', 'lts_add_taxonomy_fields', 10, 3);
function lts_add_taxonomy_fields($fields, $post_type, $class){

    if($class->taxonomies){

        foreach($class->taxonomies as $taxonomy => $object){

            if($class->is_hierarchical_tax($taxonomy)){

                $label = $object->labels->name;

                if($taxonomy == 'groups')
                    $label = __('Group category','wp-recall');

                $options = array();

                if($taxonomy != 'groups'){

                    $options = array(
                        array(
                            'type' => 'dynamic',
                            'slug' => 'level-names',
                            'title' => __('Наименование уровней'),
                            'notice' => __('Укажите наименование для каждого уровня иерархии, например: Страна, Область, Город')
                        )
                    );

                }

                $fields[] = array(
                    'slug' => 'lts-'.$taxonomy,
                    'title' => 'LTS:'. $label,
                    'type' => 'custom',
                    'options-field' => $options
                );

            }

        }

    }

    return $fields;

}