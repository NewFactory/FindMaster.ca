<?php
/*  Шаблон дополнения User Info Tab https://codeseller.ru/products/user-info-tab/
    Если вам нужно внести изменения в данный шаблон - скопируйте его в папку /wp-content/wp-recall/templates/
    - сделайте там в нем нужные вам изменения и он будет подключаться оттуда
    Подробно работа с шаблонами описана тут: https://codeseller.ru/?p=11632
*/
?>

<?php global $user_LK;
    do_action('uit_top',$user_LK); // хук инициализации
?>

<div class="uit_basic_info">
    <div class="uit_general_title">User information:</div>

    <?php  // отображаемое имя
        uit_display_name($user_LK);
    ?>

    <?php // информация видна только автору кабинета. Ссылка на редактирование профиля
          // Здесь и ниже мы видим что можно передавать в функцию свой текст и название иконки Font Awesome
          // иконки можно выбрать здесь http://fontawesome.io/icons/
        uit_user_message($user_LK, $title='You can fill in / change this data in your profile. Go to <i class="rcli fa-angle-double-right"></i>', $fa_icon='fa-wrench');
    ?>

    <?php  // экшен до блока информации. Передает id кабинета
           // вы можте зацепиться за них и вывести тут свою информацию
           // это так же могут использовать сторонние дополнения - поэтому в этом файле 4 хука не удаляйте
        do_action('uit_before_info',$user_LK);
    ?>

    <?php // возраст - если активен доп Birthday in Profile https://codeseller.ru/?p=13377
          // если дополнение указанное здесь и ниже не активно - то ничего не выведет
        uit_birth($arg='age',$user_LK, $title='Возраст:');
    ?>

    <?php // дата рождения - если активен доп Birthday in Profile https://codeseller.ru/?p=13377
        uit_birth($arg='dob',$user_LK, $title='');
    ?>

    <?php // страна и город - если активен доп Сountry & city in profile https://codeseller.ru/?p=10541
        uit_country($user_LK, $title='Проживает:', $fa_icon='fa-globe');
    ?>

    <?php // баланс - если активен user-account
        uit_get_balance($user_LK, $title='Account:', $fa_icon='fa-money');
    ?>

    <?php // Эта функция выводит все произвольные поля профиля.
          // если все поля профиля массово не надо выводить - и вы хотите вывести и оформить каждое поле в отдельности
          // - используйте функцию get_user_meta() http://wp-kama.ru/function/get_user_meta
          // а строчку ниже закомментируйте
        uit_all_custom_field($user_LK, $title='Details:', $fa_icon='fa-id-card-o');
    ?>

    <?php // последняя страница - если активен доп LastPage https://codeseller.ru/?p=8190
        uit_last_page($user_LK, $title='Activity:', $fa_icon='fa-eye');
    ?>

    <?php // Статус пользователя
        uit_description($user_LK, $title='Additionally:', $fa_icon='fa-info');
    ?>

    <?php // Соц ссылки - если активен доп Social Recall https://codeseller.ru/?p=4637
        uit_social($user_LK, $title='Contacts:', $fa_icon='fa-envelope-open-o');
    ?>

    <?php do_action('uit_after_info',$user_LK); // экшен после блока информации ?>
</div><!-- end uit_basic_info -->

<div class="uit_statistics"><!-- блок статистики -->
    <div class="uit_activity"><i class="rcli fa-heartbeat"></i><span>User Activity:</span></div>

    <?php do_action('uit_before_stats',$user_LK); // экшен до блока статистики ?>

    <?php uit_registration_date($user_LK, $title='Check in', $fa_icon='fa-child'); // дата регистрации ?>

    <?php uit_day_after_registration($user_LK, $title='On the site, days', $fa_icon='fa-calendar-check-o'); // считаем дни на сайте ?>

    <?php// uit_comments_count($user_LK, $title='Комментариев', $fa_icon='fa-comments-o'); // оставил комментариев ?>

    <?php uit_count_type_post($user_LK, $type='post', $title='Публикаций', $fa_icon='fa-newspaper-o'); // кол-во публикаций в обычных записях ?>

    <?php uit_count_type_post($user_LK, $type='post-group', $title='Публикаций в группах', $fa_icon='fa-users'); // кол-во публикаций в группах (доп Groups Wp-Recall) ?>

    <?php uit_count_type_post($user_LK, $type='products', $title='Товаров', $fa_icon='fa-shopping-cart'); // опубликовал товаров (доп Recall Magazine) ?>

    <?php uit_count_type_post($user_LK, $type='notes', $title='Заметок', $fa_icon='fa-sticky-note-o'); // оставил заметок (доп Notes) ?>

    <?php uit_count_type_post($user_LK, $type='video', $title='Видео', $fa_icon='fa-film'); // кол-во видео в видеогалерее (доп Video Gallery) ?>

    <?php uit_count_type_post($user_LK, $type='attachment', $title='Фото', $fa_icon='fa-picture-o'); // кол-во фото в галерее (доп Gallery Recall) ?>

    <?php uit_count_type_post($user_LK, $type='topic', $title='Вопросов на форуме', $fa_icon='fa-question-circle-o'); // кол-во вопросов на форуме (плагин bbPress) ?>

    <?php uit_count_type_post($user_LK, $type='reply', $title='Ответов на форуме', $fa_icon='fa-reply-all fa-flip-horizontal'); // кол-во ответов на форуме (плагин bbPress) ?>

    <?php uit_asgaros_stat($user_LK, $type='asf_issues', $title='Тем на форуме', $fa_icon='fa-align-left'); // кол-во вопросов на форуме (плагин asgaros) ?>

    <?php uit_asgaros_stat($user_LK, $type='asf_reply', $title='Сообщений на форуме', $fa_icon='fa-quote-left'); // кол-во ответов на форуме (плагин asgaros) ?>

    <?php do_action('uit_after_stats',$user_LK); // экшен после блока статистики ?>

</div><!-- end uit_statistics -->

<div class="uit_footer"><!-- блок uit_footer -->

    <?php  // сессии пользователя. Этот блок видит администратор и хозяин личного кабинета
        $notice = 'This information is visible only to you and the administration. It shows when you logged in, from which device and IP address';
        uit_get_session_data($user_LK, $title='Sessions:', $fa_icon='fa-hourglass-end', $notice);
    ?>

    <?php do_action('uit_footer',$user_LK); // экшен срабатывает в самом низу ?>
</div><!-- end uit_footer -->
