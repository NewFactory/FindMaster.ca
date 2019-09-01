<?php 

if (!defined('ABSPATH')) exit;

add_filter('admin_options_wprecall','options_private_office_rcl');
function options_private_office_rcl($options){
		
    $opt = new Rcl_Options();
	
    $options .= $opt->options(
        'Шорткоды в ЛК', array(
		
        $opt->option_block(
            array(
                $opt->title('Основные настройки'),
							
                $opt->label('Включить шорткоды в ЛК'),
                $opt->option('select',array(
                    'name'=>'on_off_private_office_rcl',
                    'parent'=>true,
                    'options'=>array(
                        'office-rcl-hide'=>'Нет',
                        'office-rcl'=>'Да',
                        )
                )),
				$opt->notice('Шорт коды выводятся в заданных областях ЛК<hr />'),
				
				$opt->child(
					array(
						'name'=>'on_off_private_office_rcl',
						'value'=>'office-rcl'
					),
				
					array(
				
						$opt->label('Шорткод в область before'),
						$opt->option('text',array(
							'name'=>'shortcodes_po_before')),
							
				    $opt->notice('Пример: [do_widget id=text-5]<hr />'),
					
					$opt->label('Цвет и прозрачность фона'),
						$opt->option('text',array(
							'name'=>'background_po_before')),
							
				    $opt->notice('Пример, вводим в формате rgba: 0, 170, 238, 0.9<hr />'),
					
					$opt->label('Шорткод в область top'),
						$opt->option('text',array(
							'name'=>'shortcodes_po_top')),
							
				    $opt->notice('Пример: [do_widget id=text-5]<hr />'),
					
					$opt->label('Цвет и прозрачность фона'),
						$opt->option('text',array(
							'name'=>'background_po_top')),
					
                    $opt->notice('Пример, вводим в формате rgba: 0, 170, 238, 0.9<hr />'),				
					
																		
					)),
				
				)
            ),

		)	
   );
     
    return $options;
}