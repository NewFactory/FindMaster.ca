<?php

class FNG_Requests extends Rcl_Query{
    
    function __construct() {
        
        $table = array(
            'name' => WP_PREFIX ."fng_requests",
            'as' => 'fng_requests',
            'cols' => array(
                'request_id',
                'author_id',
                'task_id',
                'request_content',
                'request_price',
                'request_date',
                'parent_id',
                'request_status'
            )
        );
        
        parent::__construct($table);
    }
    
}