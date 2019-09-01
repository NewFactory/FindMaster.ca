<?php

class FNG_Comments extends Rcl_Query{
    
    function __construct() {
        
        $table = array(
            'name' => WP_PREFIX ."fng_comments",
            'as' => 'fng_comments',
            'cols' => array(
                'comment_id',
                'request_id',
                'author_id',
                'comment_content',
                'comment_date'
            )
        );
        
        parent::__construct($table);
    }
    
}