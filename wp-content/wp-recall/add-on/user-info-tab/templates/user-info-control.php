<?php
/*  Шаблон дополнения User Info Tab https://codeseller.ru/products/user-info-tab/
    Если вам нужно внести изменения в данный шаблон - скопируйте его в папку /wp-content/wp-recall/templates/
    - сделайте там в нем нужные вам изменения и он будет подключаться оттуда
    Подробно работа с шаблонами описана тут: https://codeseller.ru/?p=11632
*/
?>

<?php global $user_LK;
    do_action('uit_top',$user_LK); // хук инициализации. Не трогать!
?>

<div class="tc_uit_sidebar">
    <?php uit_user_avatar($user_LK); ?>
    <?php // Соц ссылки - если активен доп Social Recall https://codeseller.ru/?p=4637
        uit_social($user_LK, $title='', $fa_icon='');
    ?>
    <?php uit_presents($user_LK); ?>

    <?php uit_feed_data($user_LK,$type = 'subscriptions'); ?>
    <?php uit_feed_data($user_LK,$type = 'followers'); ?>

    <?php uit_video_gallery($user_LK); ?>
</div>

<div class="tc_uit_content">
    <?php // Статус пользователя
        uit_description($user_LK, $title='', $fa_icon='');
    ?>
    <div class="tc_uit_form">

        <?php // дата рождения - если активен доп Birthday in Profile https://codeseller.ru/?p=13377
            uit_birth($arg='dob',$user_LK, $title='День рождения:');
        ?>

        <?php // возраст - если активен доп Birthday in Profile https://codeseller.ru/?p=13377
              // если дополнение указанное здесь и ниже не активно - то ничего не выведет
            uit_birth($arg='age',$user_LK, $title='Возраст:');
        ?>

        <?php // страна и город - если активен доп Сountry & city in profile https://codeseller.ru/?p=10541
            uit_country($user_LK, $title='Проживает:', $fa_icon='');
        ?>


        <?php // баланс - если активен user-balance
            uit_get_balance($user_LK, $title='Account:', $fa_icon='');
        ?>
        
        <?php 
             uit_all_custom_field($user_LK, $title='The details:', $fa_icon='fa-id-card-o');
        ?>
    
    <?php uit_gallery($user_LK); ?>


    <div class="uit_statistics"><!-- блок статистики -->
                <div class="uit_activity"><i class="rcli fa-heartbeat"></i><span>User Activity:</span></div>

                <?php do_action('uit_before_stats',$user_LK); // экшен до блока статистики ?>

                <?php uit_registration_date($user_LK, $title='Check in', $fa_icon='fa-child'); // дата регистрации ?>

                <?php uit_day_after_registration($user_LK, $title='On the site, days', $fa_icon='fa-calendar-check-o'); // считаем дни на сайте ?>

                <?php //uit_comments_count($user_LK, $title='Comments', $fa_icon='fa-comments-o'); // оставил комментариев ?>

                <?php //uit_count_type_post($user_LK, $type='post', $title='Publications', $fa_icon='fa-newspaper-o'); // кол-во публикаций в обычных записях ?>

                <?php //uit_count_type_post($user_LK, $type='post-group', $title='Публикаций в группах', $fa_icon='fa-users'); // кол-во публикаций в группах (доп Groups Wp-Recall) ?>

                <?php //uit_count_type_post($user_LK, $type='products', $title='Товаров', $fa_icon='fa-shopping-cart'); // опубликовал товаров (доп Recall Magazine) ?>

                <?php uit_count_type_post($user_LK, $type='notes', $title='Notes', $fa_icon='fa-sticky-note-o'); // оставил заметок (доп Notes) ?>

                <?php //uit_count_type_post($user_LK, $type='video', $title='Видео', $fa_icon='fa-film'); // кол-во видео в видеогалерее (доп Video Gallery) ?>

                <?php uit_count_type_post($user_LK, $type='attachment', $title='A photo', $fa_icon='fa-picture-o'); // кол-во фото в галерее (доп Gallery Recall) ?>

                <?php uit_count_type_post($user_LK, $type='topic', $title='Вопросов на форуме', $fa_icon='fa-question-circle-o'); // кол-во вопросов на форуме (плагин bbPress) ?>

                <?php uit_count_type_post($user_LK, $type='reply', $title='Ответов на форуме', $fa_icon='fa-reply-all fa-flip-horizontal'); // кол-во ответов на форуме (плагин bbPress) ?>

                <?php uit_asgaros_stat($user_LK, $type='asf_issues', $title='Тем на форуме', $fa_icon='fa-align-left'); // кол-во вопросов на форуме (плагин asgaros) ?>

                <?php uit_asgaros_stat($user_LK, $type='asf_reply', $title='Сообщений на форуме', $fa_icon='fa-quote-left'); // кол-во ответов на форуме (плагин asgaros) ?>

                <?php do_action('uit_after_stats',$user_LK); // экшен после блока статистики ?>

            </div><!-- end uit_statistics -->

    <?php uit_last_notes($user_LK); ?>

</div>