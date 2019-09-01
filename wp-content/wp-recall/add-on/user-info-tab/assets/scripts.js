/* global Rcl */

// отключим прокрутку рекол
rcl_add_filter('rcl_options_url_params','uit_scroll_tab_off');
function uit_scroll_tab_off(options){
    options.scroll = 0;
    return options;
}

// и сделаем свою прокрутку
function uit_scroll(){
    var sl = ['on'];
    var slide = rcl_apply_filters('uit_slide_cabinet',sl); // возможность отключить скролл
    if(slide[0] === 'off') return false;
    var offsetTop = jQuery('#rcl-office').offset().top;
    jQuery('body,html').animate({scrollTop:offsetTop - 30}, 1000);
}
rcl_add_action('rcl_footer','uit_scroll');
rcl_add_action('rcl_upload_tab','uit_scroll');

 // реинициализация загрузчика авы при ajax и мы в своем кабинете (для Theme Control)
function uit_ava_upload_reload(e){
    var dTabId = e.result.post.tab_id;
    if(dTabId === 'user-info' && e.result.post.master_id == Rcl.user_ID){
        rcl_avatar_uploader();
    }
}
rcl_add_action('rcl_upload_tab','uit_ava_upload_reload');

// прокрутим к окну формы чата
function uit_scroll_chat_form(e){
    var uitChat = e.result.post.tab_id;
    var h = window.innerHeight;                     // высота окна браузера

    if(uitChat === 'chat'){                         // мы во вкладке чат
        var chatForm = jQuery('.chat-form');        // наша форма
        if(chatForm.length < 1) return false;       // а это если мы в своем лк - ее нет (или гость)
        var offsetToChat = chatForm.offset().top;   // отступ до формы
        if((h + 250) < offsetToChat){ // если окно браузера огромное - не будем прокручивать
            jQuery('body,html').animate({scrollTop:offsetToChat - (h - 140)}, 1000); // 140 допуск на высоту формы
        }
    }
}
rcl_add_action('rcl_upload_tab','uit_scroll_chat_form');



function uit_width_rcl_office(){
    var tabUserInfo = jQuery('#tab-user-info');
    var rclOW = tabUserInfo.outerWidth();
    jQuery(tabUserInfo).removeClass('uit_w_400 uit_w_550 uit_w_700 uit_w_800');
    switch(true){
        case (rclOW < 400):
            jQuery(tabUserInfo).addClass('uit_w_400');
            break;
        case (rclOW < 550):
            jQuery(tabUserInfo).addClass('uit_w_550');
            break;
        case (rclOW < 700):
            jQuery(tabUserInfo).addClass('uit_w_700');
            break;
        case (rclOW < 800):
            jQuery(tabUserInfo).addClass('uit_w_800');
            break;
    }
}

rcl_add_action('rcl_upload_tab','uit_width_rcl_office');

jQuery(document).ready(function() {
    uit_width_rcl_office();
});
jQuery(window).resize(function() { // действия при ресайзе окна
    uit_width_rcl_office();
});



// если нет сессий - скроем спойлер
function uit_hide_empty_spoiler(){
    var spoilerContent = jQuery('.uits_3 .uit_spoiler_content');
    if( !jQuery.trim(spoilerContent.html()).length ){
        spoilerContent.prev().hide();
    }
}
rcl_add_action('rcl_upload_tab','uit_hide_empty_spoiler');
rcl_add_action('rcl_footer','uit_hide_empty_spoiler');



// uit спойлер
function uit_spoiler(e) {
    var textStart = jQuery(e).text();
    var textOpen = jQuery(e).data('open');
    var textClose = jQuery(e).data('close');
    jQuery(e).text(textStart === textOpen ? textClose : textOpen);
    
    // раскрытие
    jQuery(e).next('.uit_spoiler_content').toggleClass('uit_open');
}


// удалим класс если хук вернул нам любые табы
// ставим класс на нужный id - нужно для ajax ссылок в контенте UI-Tab
function tc_reset(e){
    var elm = e.result.post.tab_id;

    jQuery('#lk-menu .recall-button, #tc_counters .recall-button').removeClass('tc_active');
    
    jQuery('#lk-menu #tab-button-'+elm+' a, #tc_counters #tab-button-'+elm+' a').addClass('tc_active');
}
rcl_add_action('rcl_upload_tab','tc_reset');

