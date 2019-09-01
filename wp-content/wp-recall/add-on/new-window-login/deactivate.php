<?php
//////////////////////////////////////////////////////////////////////////////////////////////
//																							//
//	Name: New Window Login (Новые стили всплывающего окна, отключение wp-admin и wp-login)	//
//	Author: Web-Blog                                          							  	//
//	deactivate.php																			//
//																							//
//////////////////////////////////////////////////////////////////////////////////////////////

// удаление при деактивации form-sign.php //
if(file_exists(RCL_TAKEPATH.'templates/form-sign.php')) 
	unlink(RCL_TAKEPATH.'templates/form-sign.php');

if(file_exists(RCL_TAKEPATH.'templates/form-sign-old.php'))
	rename(RCL_TAKEPATH.'templates/form-sign-old.php',RCL_TAKEPATH.'templates/form-sign.php');

// удаление при деактивации form-remember.php //
if(file_exists(RCL_TAKEPATH.'templates/form-remember.php')) 
	unlink(RCL_TAKEPATH.'templates/form-remember.php');

if(file_exists(RCL_TAKEPATH.'templates/form-remember-old.php'))
	rename(RCL_TAKEPATH.'templates/form-remember-old.php',RCL_TAKEPATH.'templates/form-remember.php');

// удаление при деактивации form-register.php //
if(file_exists(RCL_TAKEPATH.'templates/form-register.php')) 
	unlink(RCL_TAKEPATH.'templates/form-register.php');

if(file_exists(RCL_TAKEPATH.'templates/form-register-old.php'))
	rename(RCL_TAKEPATH.'templates/form-register-old.php',RCL_TAKEPATH.'templates/form-register.php');