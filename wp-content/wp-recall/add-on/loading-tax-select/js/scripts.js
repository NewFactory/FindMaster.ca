jQuery(function($){
    
    $('body').on('change','select.lts-level',function(){
        
        var select = $(this);
        
        select.parents('.rcl-field-input').next('.lts-level-childrens').empty();

        var level = 0;
        
        if(select.hasClass('level-1')){ 
            level = 1;
        }else if(select.hasClass('level-2')){
            level = 2;
        }else if(select.hasClass('level-3')){
            level = 3;
        }else if(select.hasClass('level-4')){
            level = 4;
        }
        
        var term_id = select.find(':selected').val();
        
        if(!term_id){
            return;
        }
        
        var form = select.parents('form');
        
        var taxonomy = select.attr('name').slice(5,-3);
        
        rcl_ajax({
            data: {
                action: 'lts_ajax_get_children_items',
                taxonomy: taxonomy,
                term_id: term_id,
                level: level,
                post_id: form.data('post_id'),
                post_type: form.data('post_type'),
                form_id: form.data('form_id')
            },
            success: function(result){
                
                if(!result.content) return;

                select.parents('.rcl-field-input').next().html(result.content);
                
            }
            
        });
        
    });
    
});

