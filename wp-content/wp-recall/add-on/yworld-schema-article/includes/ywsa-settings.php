<?php 

if (!defined('ABSPATH')) exit;

add_filter('admin_options_wprecall','options_add_ywsa');
function options_add_ywsa($content){

    $opt = new Rcl_Options(__FILE__);

    $content .= $opt->options(
        __('Микроразметка статей'), 
        array(
            $opt->options_box(
                __('Общие настройки - "Yworld Schema Article"','yw-schema'),
			array(
                array(
                  'type' =>'select',
                  'title'=>__('Включить отображение','yw-schema'),
                  'slug'=>'on_off_ywsa',
                  'values'=>array(
                  0 => __('Нет'),
                  1 => __('Да')                
               
			),
            'childrens' => array(
        1 => array(		
		         
            array(
                'type' =>'url',
                'title'=>__('Ссылка на дефолтную картинку статьи','yw-schema'),
                'slug'=>'ywsa_scheme_img',
				'notice'=>__('Пример: сайт/wp-content/uploads/logo-soc.jpg','yw-schema'),
				'help'=>__('Загрузите картинку в медиафайлы и укажите ссылку на нее, выведена будет если отсутствует миниатюра. По умолчанию выводится миниатюра статьи. Не менее 696px в ширину.','yw-schema')
				
			),
           array(
                'type' =>'text',
                'title'=>__('Название Организации/Сайта','yw-schema'),
                'slug'=>'ywsa_scheme_org',
				'default'=> get_bloginfo("name"),
				'help'=>__('По умочанию название сайта. Не меняйте если не уверены','yw-schema')
			 ),
			array(
                'type' =>'url',
                'title'=>__('Логотип сайта','yw-schema'),
                'slug'=>'ywsa_logo_img',
				'notice'=>__('Пример: сайт/wp-content/uploads/logo-soc.jpg','yw-schema'),
				'help'=>__('Загрузите картинку в медиафайлы и укажите ссылку на нее, например ваш логотип или подходящую картинку. Высота минимум 60px, ширина не больше 600px.','yw-schema')
			),
		   array(
                'type' =>'select',
                'title'=>__('Выбрать тип схемы','yw-schema'),
                'slug'=>'ywsa_scheme_selection',
				'help'=>__('По умочанию Article. Не меняйте если не уверены','yw-schema'),
                'values'=>array(
                'Article' => __('Article','yw-schema'),
                'NewsArticle' => __('NewsArticle','yw-schema')
				)
			),
//           array(
//                'type' =>'select',
//                'title'=>__('При ошибке в валидаторе яндекса включить'),
//                'slug'=>'ywsa_yandex_fix',
//				'help'=>__('Включать только если проверка в валидаторе яндекса показала ошибку для типа Article или NewsArticle','yw-schema'),
//                'values'=>array(
//                0 => __('Нет','yw-schema'),
//                1 => __('Да','yw-schema')
//                                 
//        	   )
//			 )
		   )
         )	   
       )
	 )
   )
 )
);
	
    return $content;
}