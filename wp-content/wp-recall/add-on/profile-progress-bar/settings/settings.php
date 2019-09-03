<?php 

if (!defined('ABSPATH')) exit;

add_filter('admin_options_wprecall','options_profile_progress_bar');
function options_profile_progress_bar($options){
		
    $opt = new Rcl_Options();
    	$options .= $opt->options(
        (__('Заполненность профиля','rcl-progress')),
        $opt->option_block(
            array(
			    $opt->title(__('Прогресс бар заполненности профиля','rcl-progress')),
                  $opt->option('select',array(
                    'name'=>'rcl_progress_included',
                    'parent'=>true,
                    'options'=>array(
                        '1'=>(__('Не показывать','rcl-progress')),
                        '2'=>(__('Показать','rcl-progress')),
                        )
                )),
				$opt->child(
				array(
                    'name'=>'rcl_progress_included',
                    'value'=>'2'
                    ),
					array(
					$opt->label(__('Над аватаркой с картинкой','rcl-progress')),
					$opt->option('select',array(
					'name'=>'rcl_progress_enable',
                    'parent'=>true,
                    'options'=>array(
                        'profile-element-hide'=>(__('Не показывать','rcl-progress')),
                        'profile-progress'=>(__('Показать','rcl-progress')),
                        ),
					)),
					$opt->label(__('Над аватаркой без картикни','rcl-progress')),
					$opt->option('select',array(
					'name'=>'rcl_progress_enable3',
                    'parent'=>true,
                    'options'=>array(
                        'profile-element-hide'=>(__('Не показывать','rcl-progress')),
                        'profile-progress'=>(__('Показать','rcl-progress')),
                        ),
					)),
                   
                    $opt->label(__('Под ником','rcl-progress')),
					$opt->option('select',array(
					'name'=>'rcl_progress_enable2',
                    'parent'=>true,
                    'options'=>array(
                        'profile-element-hide'=>(__('Не показывать','rcl-progress')),
                        'profile-progress-menu'=>(__('Показать','rcl-progress')),
                        ),
					)),					
					$opt->option('textarea',array('name'=>'rcl_progress_metakey','label'=>__('MetaKey полей участвующих в подсчете.','rcl-progress'),'help'=>__('Впишите MetaKey полей участвующих в подсчете через запятую! Несколько полей которые вы можете включить не считая своих:<br /> first_name,last_name,user_url,rcl_avatar,rcl_cover','rcl-progress'),'notice'=>__('Вписывать через запятую: last_name,first_name','rcl-progress'))),
					$opt->option('textarea',array('name'=>'rcl_progress_tooltip','label'=>__('Текст подсказки пользователю.','rcl-progress'),'help'=>__('Немного информации, перечслить какие надо заполнить поля','rcl-progress'),'notice'=>__('Пример: Доброе время суток! Для 100% заполнения профиля..','rcl-progress'))),
					$opt->option('text',array('name'=>'rcl_progress_text','label'=>__('Название прогресса.','rcl-progress'),'help'=>__('Короткое название прогресс бара','rcl-progress'),'notice'=>__('Пример: Ваш профиль заполнен на:','rcl-progress'))),
					$opt->option('url',array('name'=>'rcl_progress_img','label'=>__('URL картинки при 100%.','rcl-progress'),'help'=>__('Адрес картинки при достижении 100%, работает только над аватарой','rcl-progress'),'notice'=>__('Пример: http://вашсайт.ru/wp-content/uploads/2017/04/icon.png','rcl-progress'))),
					$opt->option('number',array('name'=>'rcl_progress_top','label'=>__('Позиционирование по вертикале','rcl-progress'),'help'=>__('Парметр top, вы можете подвинуть  картинку выше/ниже.','rcl-progress'),'notice'=>__('Пример: 10','rcl-progress'))),
					$opt->label(__('Цвет шрифта названия','rcl-progress')),
					        $opt->option('text',array(
								'name'=>'color_font_name',
								'default'=>'')),
					$opt->label(__('Цвет фона названия','rcl-progress')),
					        $opt->option('text',array(
								'name'=>'color_background_name',
								'default'=>'')),
					$opt->label(__('Цвет процентов','rcl-progress')),
					        $opt->option('text',array(
								'name'=>'color_font_interest',
								'default'=>'')),
					$opt->label(__('Цвет фона шкалы','rcl-progress')),
					        $opt->option('text',array(
								'name'=>'color_background_scale',
								'default'=>'')),			
				$opt->notice('</br><hr />'),
							)
                        ),
				    
				
				)
            )

		);	
    return $options;
}