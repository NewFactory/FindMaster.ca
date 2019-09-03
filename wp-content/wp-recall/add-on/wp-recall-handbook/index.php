<?php

// Добавляем страницу
function wprh_add_subpage(){
    add_submenu_page('manage-wprecall','WP-Recall Handbook', 'Handbook', 'manage_options', 'wp-recall-handbook', 'wprh_page_content');
}
add_action('admin_menu', 'wprh_add_subpage',20);


// выводим на ней контент
function wprh_page_content(){
    ?>
    <div class="wprh_menu">
        <a class="nav-tab <?php wprh_active_class('wprh_facts') ?>" href="<?php echo add_query_arg( array('page' => 'wp-recall-handbook', 'tab' => 'wprh_facts'), '' ); ?>"><span class="dashicons dashicons-lightbulb"></span> Знаете ли вы что...</a>
        <a class="nav-tab <?php wprh_active_class('wprh_developer') ?>" href="<?php echo add_query_arg( array('page' => 'wp-recall-handbook', 'tab' => 'wprh_developer'), '' ); ?>"><span class="dashicons dashicons-hammer"></span> Старт для разработки</a>
        <a class="nav-tab <?php wprh_active_class('wprh_video') ?>" href="<?php echo add_query_arg( array('page' => 'wp-recall-handbook', 'tab' => 'wprh_video'), '' ); ?>"><span class="dashicons dashicons-video-alt3"></span> Видео</a>
        <a class="nav-tab <?php wprh_active_class('wprh_codeseller') ?>" href="<?php echo add_query_arg( array('page' => 'wp-recall-handbook', 'tab' => 'wprh_codeseller'), '' ); ?>"><span class="dashicons dashicons-awards"></span> Сервис CodeSeller.ru</a>
    </div>
    <?php wprh_catch_get(); ?>

    <span class="rcl_thankyou">
        Онлайн версия этого справочника <a href="https://codeseller.ru/?p=12493">здесь</a><br/><br/><br/>
        Спасибо вам за творчество с <a href="https://codeseller.ru/?page_id=69">WP-Recall</a>
    </span>
    <?php
}


// ловим get и подключаем нужный файл страницы
function wprh_catch_get() {
    if(isset($_GET['tab'])){
        $wprh_get = $_GET['tab'];
        switch ($wprh_get) {
            case 'wprh_facts':
                require_once('tab-1.php');
                break;
            case 'wprh_developer':
                require_once('tab-2.php');
                break;
            case 'wprh_video':
                require_once('tab-3.php');
                break;
            case 'wprh_codeseller':
                require_once('tab-4.php');
                break;
        }
    } else {
        require_once('tab-1.php');
    }
    wprh_style(); // цепляем стили
}


// подсвечиваем активную вкладку
function wprh_active_class($tab_name = null) {
    if (isset($_GET['tab']))
        $wprh_tab = $_GET['tab'];
    else
        $wprh_tab = 'wprh_facts';
    $wprh_out = '';
    if (isset($tab_name) && $tab_name) {
        if ($tab_name == $wprh_tab){
            $wprh_out = 'nav-tab-active';
        }
    }
    echo $wprh_out;
}

function wprh_style() {
   echo '<style type="text/css">
.wprh_menu {
    display: inline-block;
    margin: 30px 0 10px;
    width: 100%;
}
.wprh_blk {
    font: 14px/23px "Droid Sans",sans-serif;
    margin: 10px 20px;
    max-width: 800px;
}
.wprh_menu a.nav-tab-active {
    cursor: default;
}
.wprh_menu a.nav-tab-active span {
    color: rgb(230, 15, 15);
}
.wprh_blk li {
    list-style-type: decimal;
}
.wprh_menu .nav-tab span {
    vertical-align: middle;
}
.wprh_blk.tab_1 code {
    background-color: rgba(0, 0, 0, 0.1);
}
.wprh_blk.tab_3 {
    max-width: 1000px;
}
.tab_3_blk {
    background-color: #fff;
    box-shadow: 3px 4px 7px -2px rgba(0, 0, 0, 0.3), -1px -3px 6px -5px rgba(0, 0, 0, 0.5);
    display: table;
    float: left;
    height: 320px;
    margin: 0.5% 0.5% 20px;
    overflow: hidden;
    width: 49%;
}
.wprh_blk.tab_3 span {
    display: table;
    font-size: 20px;
    line-height: 1;
    padding: 8px;
}
.tab_3_blk iframe {
    height: 100%;
    min-height: 250px;
    padding: 1%;
    width: 98%;
}
.rcl_thankyou {
    clear: both;
    display: block;
    font-style: italic;
    width: 100%;
}
@media screen and (max-width:640px) {
    .wprh_menu .nav-tab span {
        display: table;
        margin: 0 auto;
    }
    .wprh_menu a {
        margin: 3px 0.5%;
        padding: 5px;
        text-align: center;
        white-space: normal;
        width: 26%;
    }
    .wprh_menu a:nth-child(3) {
        max-width: 40px;
        min-width: 40px;
    }
}
@media screen and (max-width:568px) {
    .wprh_menu a {
        min-height: 70px;
        width: 25%;
    }
    .tab_3_blk {
        width: 97%;
    }
}
@media screen and (max-width:480px) {
    .wprh_menu a {
        width: 23%;
    }
}
</style>';
}
