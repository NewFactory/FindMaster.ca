function my_send_form_data(action,e){
   
    var form = jQuery(e).parents('form');
   
    if(!rcl_check_form(form)) return false;
   
    if(e && jQuery(e).parents('.preloader-parent')){
        rcl_preloader_show(jQuery(e).parents('.preloader-parent'));
    }
   
    rcl_ajax({
        data: form.serialize() + '&action=' + action,
        success: function(data){
           jQuery('#rcl-tabs .rcl-userlist').replaceWith(data.content);
        }
    });
 
}