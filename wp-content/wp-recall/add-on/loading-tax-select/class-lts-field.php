<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class-lts-field
 *
 * @author Андрей
 */
class LTS_Field {

    public $taxonomy;
    public $level_names = array();
    public $terms = array();
    public $post_id = 0;
    public $post_terms = array();

    function __construct($taxonomy, $levelNames, $post_id = 0) {

        $this->taxonomy = $taxonomy;
        $this->level_names = $levelNames;
        $this->post_id = $post_id;

        $this->setup_terms();

    }

    function setup_terms(){

        $this->terms = get_terms(array(
            'taxonomy' => $this->taxonomy,
            'hide_empty' => false
        ));

        foreach($this->terms as $k => $term){

            if($term->parent) continue;

            $this->terms[$k]->level = 0;

            $this->setup_childs($term->term_id, 1);

        }

        if($this->post_id){

            $this->post_terms = get_the_terms($this->post_id, $this->taxonomy);

            foreach($this->post_terms as $k => $term){

                if($term->parent) continue;

                $this->post_terms[$k]->level = 0;

                $this->setup_post_childs($term->term_id, 1);

            }

        }

    }

    function setup_post_childs($parent_id, $level){

        foreach($this->post_terms as $k => $term){

            if($term->parent != $parent_id) continue;

            $this->post_terms[$k]->level = $level;

            $this->setup_post_childs($term->term_id, $level+1);

        }

    }

    function setup_childs($parent_id, $level){

        foreach($this->terms as $k => $term){

            if($term->parent != $parent_id) continue;

            $this->terms[$k]->level = $level;

            $this->setup_childs($term->term_id, $level+1);

        }

    }

    function get_content(){

        $content .= '<div class="lts-select-box lts-taxonomy-'.$this->taxonomy.'">';

        $content .= $this->get_field_content();

        $content .= '</div>';

        return $content;

    }

    function get_field_content($parent_id = 0){

        $terms = $this->get_childrens($parent_id);

        if(!$terms) return false;

        $level = $terms[0]->level;

        $firstLevel = array();
        foreach($terms as $term){
            $firstLevel[$term->term_id] = $term->name;
        }

        $CF = new Rcl_Custom_Fields();

        $content = '<label>'.$this->level_names[$level].'<span class="required">*</span></label>';

        $content .= $CF->get_input(array(
            'type' => 'select',
            'slug' => 'lts-'.$this->taxonomy.'-'.$level,
            'classes' => 'lts-level level-'.$level,
            'name' => 'cats['.$this->taxonomy.'][]',
            'default' => $this->get_selected_term($level),
            'empty-first' => __('Ничего не выбрано...'),
            'values' => $firstLevel,
            'required' => true
        ));

        $content .= '<div class="lts-level-childrens lts-level-childrens-'.$level.'">';

        if($this->post_terms){
            $content .= $this->get_post_childrens_content($level);
        }

        $content .= '</div>';

        return $content;

    }

    function get_selected_term($level = 0){

        if(!$this->post_terms) return false;

        foreach($this->post_terms as $k => $term){

            if($term->level != $level) continue;

            return $term->term_id;

        }

    }

    function get_post_childrens_content($level = 0){

        foreach($this->post_terms as $k => $term){

            if($term->level != $level) continue;

            return $this->get_field_content($term->term_id);

        }

    }

    function get_childrens($parent_id = 0){

        $terms = array();

        foreach($this->terms as $term){
            if($term->parent != $parent_id) continue;
            $terms[] = $term;
        }

        return $terms;

    }

    function get_level_terms($level = 0){

        $terms = array();

        foreach($this->terms as $term){
            if($term->level != $level) continue;
            $terms[] = $term;
        }

        return $terms;

    }

}
