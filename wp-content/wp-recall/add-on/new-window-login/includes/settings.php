<?php 
//////////////////////////////////////////////////////////////////////////////////////////////
//																							//
//	Name: New Window Login (Новые стили всплывающего окна, отключение wp-admin и wp-login)	//
//	Author: Web-Blog                                          							  	//
//	includes/setting.php																	//
//																							//
//////////////////////////////////////////////////////////////////////////////////////////////

add_filter('admin_options_wprecall','add_options_nwl');
function add_options_nwl($options){

$img_uri = rcl_addon_url('img',__FILE__);
$admin_img_uri = rcl_addon_url('img/admin',__FILE__);
$percent = '%';

    $opt = new Rcl_Options();
	
    $options .= $opt->options(
        'New Window Login', array(
		
        $opt->option_block(
            array(
                $opt->title('Основные настройки'),

           			$opt->label('Выбрать шаблон для всплывающей формы'),
					$opt->option('select',array(
						'name'=>'nwl_options_style',
						'parent'=>true,
						'options'=>array(
							'none_tempelate'=>'Всплывающая форма Wp-Recall',
							'twenty_sixteen'=>'Twenty Sixteen',
							'sparkling'=>'Sparkling',
							'hueman'=>'Hueman',
							'flat'=>'Flat',
							// '5'=>'шаблон 5',
							'full_pop'=>'Full Pop',
							//'mdesign'=>'Material Design',
							'none_theme'=>'Нет подходящего',)
                    )),
					
						$opt->child(
							array(
								'name'=>'nwl_options_style',
								'value'=>'none_tempelate'),
									array( 
									
										$opt->notice('<img class="img-admin" src="'.$img_uri.'/none_tempelate.jpg">'),
										$opt->title('Настройки всплывающей формы WP-Recall'),
										
										$opt->label('Цвет формы'),
										$opt->option('text',array(
												'default'=>'#FFFFFF',
												'name'=>'nwl_style_none_tempelate_background_form')),
										
									$opt->extend(array(	
										$opt->label('Ширина формы'),
										$opt->option('number',array(
												'default'=>'320'.$qqq.'',
												'name'=>'nwl_style_none_tempelate_width')),
												
											$opt->label('<small id="admin-px-2">'),
											$opt->option('select',array(
												'help'=>'Ширину формы можно указать в (рх) или в (%), выравнивание формы по центру экрана будет произведен автоматически исходя из указаного значения, по умолчанию ширина формы (320рх)</p><img class="img-admin" src="'.$admin_img_uri.'/nwl_style_none_tempelate_width.jpg" width="365">',
												'name'=>'nwl_style_none_tempelate_width_px',
												'options'=>array(
													'px'=>'px',
													''.$percent.''=>'%',))),
											$opt->label('</small>'),
											
										$opt->label('Высота формы'),
										$opt->notice('Оставьте поле пустым, по умолчанию васто формы (auto)'),
										$opt->option('number',array( 
												'help'=>'<p>ВНИМАНИЕ!</p><p>Оставте поле пустым, если вам точно не нужно указывать высоту всплывающей формы! </p><p>С помощью данной настройки можно сделать круглу форму, для этого нужно установить одинаковое значение ширины формы (в рх), высоты и радиус скругления формы, а также настроить отступ от внутреннего края формы!</p><img class="img-admin" src="'.$admin_img_uri.'/nwl_style_none_tempelate_height.jpg" width="365"><p>Для получения круглой всплывающей формы, используйте следующие настроки:</br></br>ширина формы - 500 в (px)</br>высота формы - 500</br>радиус скругление формы - 500</br>отступ от внутреннего края формы - 90</p>',
												'default'=>''.$qqq.'',
												'name'=>'nwl_style_none_tempelate_height')),
										
											
										$opt->label('Радиус скругления формы'),
										$opt->option('number',array(
											'help'=>'По умолчанию радиус скругления формы (2рх)</p><img class="img-admin" src="'.$admin_img_uri.'/nwl_style_none_tempelate_border_radius.jpg" width="365">',
											'name'=>'nwl_style_none_tempelate_border_tab_radius',
												'default'=>'3',
												'name'=>'nwl_style_none_tempelate_border_radius')),

										$opt->label('Скруглить углы вкладок'),
										$opt->option('select',array(
											'help'=>'Скругление углов вкладок равно радиусу скругления формы </p><img class="img-admin" src="'.$admin_img_uri.'/nwl_style_none_tempelate_border_tab_radius.jpg" width="365">',
											'name'=>'nwl_style_none_tempelate_border_tab_radius',
											'options'=>array(
												'yes'=>'Да',
												'no'=>'Нет',))), 
												
										$opt->label('Отступ от внутреннего края формы'),
										$opt->option('number',array(
												'help'=>'По умолчанию отступ от края формы равен (0рх)</p><img class="img-admin" src="'.$admin_img_uri.'/nwl_style_none_tempelate_padding_form.jpg" width="365">',
												'default'=>'10',
												'name'=>'nwl_style_none_tempelate_padding_form')),
									)),
												
										$opt->label('Цвет границы формы'),
										$opt->option('text',array(
												'default'=>'#CCCCCC',
												'name'=>'nwl_style_none_tempelate_border_color')),
										
									$opt->extend(array(	
										$opt->label('Толщина границы формы<small id="admin-px">px</small>'),
										$opt->option('number',array(
												'default'=>'1',
												'name'=>'nwl_style_none_tempelate_border_width')),	


									)),
											
										$opt->label('Цвет затемнения сайта'),
										$opt->option('text',array(
												'default'=>'#1E384B',
												'name'=>'nwl_style_none_tempelate_background_site')),
									
									$opt->extend(array(	
										$opt->label('Плотность затемнения сайта'),
										$opt->option('select',array(
											'name'=>'nwl_style_none_tempelate_background_site_opacity',
											'options'=>array(
												'1'=>'100%',
												'0.9'=>'90%',
												'0.8'=>'80%',
												'0.7'=>'70%',
												'0.6'=>'60%',
												'0.5'=>'50%',
												'0.4'=>'40%',
												'0.3'=>'30%',
												'0.2'=>'20%',
												'0.1'=>'10%',
												'0'=>'0%',))),												
												
										$opt->label('Пользовательские CSS формы'),
										$opt->option('textarea',array(
											'name'=>'nwl_style_none_tempelate_custom')),
										$opt->notice('Пользовательские CSS сохраняются даже при выборе другого шаблона всплывающей формы'),
									)),

										$opt->notice('Настройки всплывающей формы сохраняются даже при выборе другого шаблона'),	
						)),
						$opt->child(
							array(
								'name'=>'nwl_options_style',
								'value'=>'twenty_sixteen'),
									array( 
										$opt->notice('<img class="img-admin" src="'.$img_uri.'/twenty_sixteen.jpg">'),
										$opt->notice('Шаблон всплывающей формы для Wordpress темы <a href="https://ru.wordpress.org/themes/twentysixteen/" target="_blank">Twenty Sixteen</a>'), 
						)),
						$opt->child(
							array(
								'name'=>'nwl_options_style',
								'value'=>'sparkling'),
									array( 
										$opt->notice('<img class="img-admin" src="'.$img_uri.'/sparkling.jpg">'),
										$opt->notice('Шаблон всплывающей формы для Wordpress темы <a href="https://ru.wordpress.org/themes/sparkling/" target="_blank">Sparkling</a>'),
										
										$opt->title('Настройки всплывающей формы Sparkling'),
										
										$opt->label('Цвет формы'),
										$opt->option('text',array(
												'default'=>'#F8F8F8',
												'name'=>'nwl_style_sparkling_background_form')),
												
////////////////////////////////////////// $opt->label('Border-Radius форм и кнопки<small id="admin-px">PX (оставьте поле пустым, что бы было 50px)</small>'),
										// $opt->option('number',array(
												// 'default'=>'50',
////////////////////////////////////////////////// 'name'=>'nwl_style_hueman_border_radius')),

										$opt->label('Цвет заголовка'),
										$opt->option('text',array(
												'default'=>'#DA4453',
												'name'=>'nwl_style_sparkling_color_title')),
												
										$opt->label('Цвет текста'),
										$opt->option('text',array(
												'default'=>'#6B6B6B',
												'name'=>'nwl_style_sparkling_color_text')),
												
										$opt->label('Цвет кнопки'),
										$opt->option('text',array(
												'default'=>'#DA4453',
												'name'=>'nwl_style_sparkling_color_button')),
												
										$opt->label('Цвет кнопки при наведении'),
										$opt->option('text',array(
												'default'=>'#333333',
												'name'=>'nwl_style_sparkling_color_button_hover')),
												
										$opt->label('Цвет текста кнопки'),
										$opt->option('text',array(
												'default'=>'#FFFFFF',
												'name'=>'nwl_style_sparkling_color_button_text')),

												$opt->label('Цвет ссылок'),
										$opt->option('text',array(
												'default'=>'#DA4453',
												'name'=>'nwl_style_sparkling_color_uri')),
												
										$opt->label('Цвет ссылок при наведении'),
										$opt->option('text',array(
												'default'=>'#B9B9B9',
												'name'=>'nwl_style_sparkling_color_uri_hover')),

									$opt->extend(array(													
										$opt->label('Пользовательские CSS формы'),
										$opt->option('textarea',array(
											'name'=>'nwl_style_sparkling_custom')),
									)),	
										$opt->notice('Настройки всплывающей формы сохраняются даже при выборе другого шаблона'),
						)),
						$opt->child(
							array(
								'name'=>'nwl_options_style',
								'value'=>'hueman'),
									array( 
										$opt->notice('<img class="img-admin" src="'.$img_uri.'/hueman.jpg">'),
										$opt->notice('Шаблон всплывающей формы для Wordpress темы <a href="https://ru.wordpress.org/themes/hueman/" target="_blank">Hueman</a>'),
										
										$opt->title('Настройки всплывающей формы Hueman'),
										
										$opt->label('Цвет формы'),
										$opt->option('text',array(
												'default'=>'#F1F1F1',
												'name'=>'nwl_style_hueman_background_form')),
												
										$opt->label('Цвет границы формы'),
										$opt->option('text',array(
												'default'=>'#DDDDDD',
												'name'=>'nwl_style_hueman_border_color')),

////////////////////////////////////////// $opt->label('Border-Radius форм и кнопки<small id="admin-px">PX (оставьте поле пустым, что бы было 50px)</small>'),
										// $opt->option('number',array(
												// 'default'=>'50',
////////////////////////////////////////////////// 'name'=>'nwl_style_hueman_border_radius')),
												
										$opt->label('Цвет текста'),
										$opt->option('text',array(
												'default'=>'#777777',
												'name'=>'nwl_style_hueman_color_text')),
												
										$opt->label('Цвет кнопки'),
										$opt->option('text',array(
												'default'=>'#3B8DBD',
												'name'=>'nwl_style_hueman_color_button')),
												
										$opt->label('Цвет кнопки при наведении'),
										$opt->option('text',array(
												'default'=>'#444444',
												'name'=>'nwl_style_hueman_color_button_hover')),
												
										$opt->label('Цвет текста кнопки'),
										$opt->option('text',array(
												'default'=>'#FFFFFF',
												'name'=>'nwl_style_hueman_color_button_text')),

												$opt->label('Цвет ссылок'),
										$opt->option('text',array(
												'default'=>'#777777',
												'name'=>'nwl_style_hueman_color_uri')),
												
										$opt->label('Цвет ссылок при наведении'),
										$opt->option('text',array(
												'default'=>'#444444',
												'name'=>'nwl_style_hueman_color_uri_hover')),
												
									$opt->extend(array(			
										$opt->label('Пользовательские CSS формы'),
										$opt->option('textarea',array(
											'name'=>'nwl_style_hueman_custom')),
									)),
									
										$opt->notice('Настройки всплывающей формы сохраняются даже при выборе другого шаблона'),
						)),
						$opt->child(
							array(
								'name'=>'nwl_options_style',
								'value'=>'flat'),
									array( 
										$opt->notice('<img class="img-admin" src="'.$img_uri.'/flat.jpg">'),
										$opt->notice('Шаблон всплывающей формы для Wordpress темы <a href="https://ru.wordpress.org/themes/flat/" target="_blank">Flat</a>'),
						)),
						// $opt->child(
							// array(
								// 'name'=>'nwl_options_style',
								// 'value'=>'5'),
									// array( 
										// $opt->notice('<img class="img-admin" src="">'),
////////////////////////// )),
						$opt->child(
							array(
								'name'=>'nwl_options_style',
								'value'=>'full_pop'),
									array( 
										$opt->notice('<img class="img-admin" src="'.$img_uri.'/full_pop.jpg">'),
										
										$opt->title('Настройки всплывающей формы Full Pop'),
										
										$opt->label('Цвет формы'),
										$opt->option('text',array(
												'default'=>'#3B8DBD',
												'name'=>'nwl_style_full_pop_background_form')),

										$opt->label('Радиус скругления полей и кнопок формы<small id="admin-px">px (оставьте поле пустым, что бы было 50px)</small>'),
										$opt->option('number',array(
												'default'=>'50',
												'name'=>'nwl_style_full_pop_border_radius')),
												
										$opt->label('Цвет текста'),
										$opt->option('text',array(
												'default'=>'#FFFFFF',
												'name'=>'nwl_style_full_pop_color_text')),
												
										$opt->label('Цвет ссылок'),
										$opt->option('text',array(
												'default'=>'#FFFFFF',
												'name'=>'nwl_style_full_pop_color_uri')),
												
										$opt->label('Цвет ссылок при наведении'),
										$opt->option('text',array(
												'default'=>'#FFFFFF',
												'name'=>'nwl_style_full_pop_color_uri_hover')),
												
									$opt->extend(array(		
										$opt->label('Пользовательские CSS формы'),
										$opt->option('textarea',array(
											'name'=>'nwl_style_full_pop_custom')),
									)),
									
										$opt->notice('Настройки всплывающей формы сохраняются даже при выборе другого шаблона'),
						)),
						// $opt->child(
							// array(
								// 'name'=>'nwl_options_style',
								// 'value'=>'mdesign'),
									// array( 
										// $opt->notice('<img class="img-admin" src="">'),
						// )),
						$opt->child(
							array(
								'name'=>'nwl_options_style',
								'value'=>'none_theme'),
									array( 
										$opt->notice('<p>Вы не нашли подходящего шаблона всплывающего окна для вашего сайта?<p/><p>Тогда напишите мне, что хотите больше шаблонов всплывающего окна WP-Recall для дополнения "New Window Login"!</p><p>Перейдите на страницу <a href="http://web-blog.su/contact/" target="_blank"><strong>ОБРАТНОЙ СВЯЗИ</strong></a> на моем сайте, выберите тему сообщения "Техничкеские вопросы/поддержка" и укажите в сообщении название вашей темы Wordpress, оставьте ссылку на ваш сайт или на демо необходимой темы, свои пожелания к новому шаблону всплывающей формы и отправьте сообщение.</p><p>Возможно, в ближайших обновлениях я добавлю шаблон всплывающего окна для вашей темы!</p><p><a href="http://web-blog.su/contact/" target="_blank"><strong>ОБРАТНАЯ СВЯЗЬ</strong></a></p>'),
						)),
			)),
				
			$opt->option_block(
            array(
			
                $opt->title('Дополнительные настройки'),
				
           			$opt->label('Включить Google ReCaptcha в форме регистрации'),
					$opt->option('select',array(
						'name'=>'nwl_options_recap',
						'parent'=>true,
						'options'=>array(
							'Нет',
							'Да')
                    )),
					$opt->notice('Предварительно необходимо зарегистрировать свой сайт в сервисе <a href="https://www.google.com/recaptcha/admin" target="_blank">Google ReCaptcha API</a>'),
					
						$opt->child(
							array(
								'name'=>'nwl_options_recap',
								'value'=>'1'),
									array( 
										$opt->label('Ключ'),
										$opt->option('text',array(
											'name'=>'nwl_recap_public_key')
										),
										$opt->notice(''),
										
										$opt->label('Секретный ключ'),
										$opt->option('text',array(
											'name'=>'nwl_recap_secret_key')
										),
										$opt->notice(''),
						)),
				
					$opt->option('checkbox',array(
						'name'=>'nwl_off_wp_admin',
						'parent'=>true,
						'options'=>array(
							'Отключить страницу wp-admin')
					)),
						$opt->option('text',array(
										'name'=>'nwl_redirect_url_wp_admin')
									),
						$opt->notice('Задайте URL-адрес перенаправления пользователя, оставьте поле пустым для перенаправления на страницу ошибки "404"'),
					
					$opt->option('checkbox',array(
						'name'=>'nwl_off_wp_login',
						'parent'=>true,
						'options'=>array(
							'Отключить страницу wp-login')
					)),
						$opt->option('text',array(
										'name'=>'nwl_redirect_url_wp_login')
									),
						$opt->notice('Задайте URL-адрес перенаправления пользователя, оставьте поле пустым для перенаправления на страницу ошибки "404"'),
						
					$opt->option('checkbox',array(
						'name'=>'nwl_off_wp_register',
						'parent'=>true,
						'options'=>array(
							'Отключить страницу регистрации')
					)),
						$opt->option('text',array(
										'name'=>'nwl_redirect_url_wp_register')
									),
						$opt->notice('Задайте URL-адрес перенаправления пользователя, оставьте поле пустым для перенаправления на страницу ошибки "404"'),
						
/* 					$opt->option('checkbox',array(
						'name'=>'nwl_off_wp_logout_redirect',
						'parent'=>true,
						'options'=>array(
							'Редирект пользователя после выхода')
					)), */
						// $opt->option('text',array(
										// 'name'=>'nwl_redirect_url_wp_logout')
									// ),
						// $opt->notice('Задайте URL-адрес перенаправления пользователя, оставьте поле пустым для перенаправления на главную страницу'),

					$opt->option('checkbox',array(
						'name'=>'nwl_off_wp_register_email',
						'parent'=>true,
						'options'=>array(
							'Отключить авторизации пользователя по e-mail')
					)),				
					
			)),
				
			$opt->option_block(
			array(
			
				$opt->title('От автора'),
				
					$opt->notice('Все замечания и предложения по работе дополнения, пишите в <strong><a href="https://codeseller.ru/author/ulogin_vkontakte_220251751/" target="_blank">приватном чате автора</a></strong> дополнения <strong>"New Window Login"</strong></br></br>'),
						
					$opt->notice('Наш сайт <strong><a href="http://web-blog.su" target="_blank">Web-Blog.su</a></strong>'),
					
					$opt->notice('Наша группа в VK <strong><a href="http://vk.com/web_blog_su" target="_blank">vk.com/web_blog_su</a></strong>'),
					
					// $opt->notice('Мы пишем в своем блоге:<iframe src="http://web-blog.su/lat-art/" width="500" height="105" scrolling="no"></iframe>')
            ))
));
     
    return $options;
}