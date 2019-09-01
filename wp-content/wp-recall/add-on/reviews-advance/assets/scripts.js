rcl_add_action('rcl_edit_rating', 'rcl_add_rating_data_review_form');
function rcl_add_rating_data_review_form(data){
    
    if(!data.result['rcl-review']) return;

    if(data.result['rating_value']){
    
        var newVal = parseFloat(data.result['rating_value']);

        jQuery('.rating-wrapper .rating-vote').removeClass('user-vote');

        jQuery('.rating-wrapper').find('.rating-vote').each(function(i){
            if(jQuery(this).data('value') <= newVal) jQuery(this).addClass('user-vote');
        });
    
    }else{
        
        jQuery('.rating-wrapper .rating-vote').removeClass('user-vote');
        
        jQuery('.rating-wrapper').children('.vote-' + data.result['rating_status']).addClass('user-vote');
        
    }
    
    jQuery('#rvs-rating-data').val(data.data);
    
}

function ra_ajax(object,e){
    
    if(object['confirm']){
        if(!confirm(object['confirm'])) return false;
    }
    
    if(e && jQuery(e).parents('.preloader-box')){
        rcl_preloader_show(jQuery(e).parents('.preloader-box'));
    }
    
    rcl_ajax({
        data: object
    });
    
}