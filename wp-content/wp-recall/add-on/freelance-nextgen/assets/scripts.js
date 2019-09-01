
function fng_ajax(object,e){
    
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

function fng_ajax_add_answer(e){
    
    var form = jQuery(e).parents('form');
    
    if(e && jQuery(e).parents('.preloader-parent')){
        rcl_preloader_show(jQuery(e).parents('.preloader-parent'));
    }
    
    rcl_ajax({
        data: form.serialize() + '&action=fng_ajax_add_answer',
        success: function(result){
            
            jQuery(e).parents('.request').find('.comments-list').append(result.answer);
            
            form.find('textarea').val('');
            
        }
    });
    
}

function fng_ajax_get_answer_form(request_id, e){

    rcl_preloader_show(jQuery(e).parents('.preloader-box'));
    
    rcl_ajax({
        data: {
            action: 'fng_ajax_get_answer_form',
            request_id: request_id
        },
        success: function(result){
            
            if(!result.form) return false;
            
            jQuery(e).parent().html(result.form);
            
        }
    });
    
    return false;
    
}