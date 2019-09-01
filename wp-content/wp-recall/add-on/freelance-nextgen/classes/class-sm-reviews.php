<?php

class SM_Reviews extends Rcl_Query{
    
    function __construct() {
        
        $table = array(
            'name' => WP_PREFIX ."fng_reviews",
            'as' => 'fng_reviews',
            'cols' => array(
                'review_id',
                'task_id',
                'object_id',
                'object_type',
                'author_id',
                'review_content',
                'rating_value',
                'user_id',
                'review_date',
                'review_status'
            )
        );
        
        parent::__construct($table);
    }
    
}

