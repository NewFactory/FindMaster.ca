<?php
//////////////////////////////////////////////////////////////////////////////////////////////
//																							//
//	Name: New Window Login (Новые стили всплывающего окна, отключение wp-admin и wp-login)	//
//	Author: Web-Blog                                          							  	//
//	activate.php																			//
//																							//
//////////////////////////////////////////////////////////////////////////////////////////////

// создание при активации form-sign.php //
if(file_exists(RCL_TAKEPATH.'templates/form-sign.php'))
	rename(RCL_TAKEPATH.'templates/form-sign.php',RCL_TAKEPATH.'templates/form-sign-old.php');
		$dir_add_on = dirname(__FILE__);
		$form_sign = 'form-sign.php';
			if(copy($dir_add_on . '/files/' . $form_sign,RCL_TAKEPATH.'templates/'.$form_sign)){}

// создание при активации form-remember.php //
if(file_exists(RCL_TAKEPATH.'templates/form-remember.php'))
	rename(RCL_TAKEPATH.'templates/form-remember.php',RCL_TAKEPATH.'templates/form-remember-old.php');
		$dir_add_on = dirname(__FILE__);
		$form_remember = 'form-remember.php';
			if(copy($dir_add_on . '/files/' . $form_remember,RCL_TAKEPATH.'templates/'.$form_remember)){}

// создание при активации form-register.php //
if(file_exists(RCL_TAKEPATH.'templates/form-register.php'))
	rename(RCL_TAKEPATH.'templates/form-register.php',RCL_TAKEPATH.'templates/form-register-old.php');
		$dir_add_on = dirname(__FILE__);
		$form_register = 'form-register.php';
			if(copy($dir_add_on . '/files/' . $form_register,RCL_TAKEPATH.'templates/'.$form_register)){}
