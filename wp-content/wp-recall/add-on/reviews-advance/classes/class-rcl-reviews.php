<?php

class Rcl_Reviews extends Rcl_Query{
    
    function __construct() {
        
        $table = array(
            'name' => RCL_PREF ."reviews",
            'as' => 'rcl_reviews',
            'cols' => array(
                'review_id',
                'object_id',
                'rating_type',
                'object_author',
                'user_id',
                'review_content',
                'review_comment',
                'rating_value',
                'review_date',
                'review_status'
            )
        );
        
        parent::__construct($table);
    }
    
}

