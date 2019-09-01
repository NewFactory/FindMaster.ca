<?php 

if (!defined('ABSPATH')) exit;

function yw_maintenance_admin_notices() {
	echo '<div id="message" class="error fade"><p>' . __( '<strong>Режим обслуживания активен!<strong>', 'yw-maintenance' ) . ' <a href="admin.php?page=manage-addon-recall">' . __( 'Деактивируйте его, когда работа будет завершена.', 'yw-maintenance' ) . '</a></p></div>';
}
add_action( 'network_admin_notices', 'yw_maintenance_admin_notices' ); 
add_action( 'admin_notices', 'yw_maintenance_admin_notices' ); 
add_filter( 'login_message',
	function() {
		return '<div id="login_error">' . __( '<strong>Режим обслуживания активен!</strong>', 'yw-maintenance' ) . '</div>';
	} );
	
function yw_maintenance_mode(){
nocache_headers();	
if(!current_user_can('edit_themes') || !is_user_logged_in()){
wp_die('<div class="fullwidth">
	<div id="topcontainer" class="bodycontainer">
		<p><img class="icon icons8-Обслуживание" width="64" height="64" src="data:image/png;base64,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"></p>
		<h1><span>Обновление сайта</span></h1><br /><h2>Пожалуйста, зайдите позже</h2>
		<p>Мы станем еще интереснее и современнее</p>
	</div>
</div>
<div class="arrow-separator arrow-white"></div>
	<div class="fullwidth colour2">
	<div id="maincont" class="bodycontainer">
        <h2>В данный момент сайт находится на техническом обслуживании</h2>
        <p>Приносим извинения за временные неудобства</p>
	</div>
</div>
<style type="text/css">
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
body {
    background: #fff;
    max-width: 100% !important;
	padding: 1em 0.1em !important;
}

p {
    margin: 0 0 20px 0;
}

strong {
    font-weight: 600;
}

em {
    font-style: italic;
}

h1, h2, h3 {
    font-size: 60px;
    line-height: 60px;
    margin: 0 0 20px 0;
    letter-spacing: -1px;
    font-weight: 300;
    text-transform: uppercase;
}

h2 {
    font-size: 38px;
    line-height: 38px;
}

h3 {
    font-size: 32px;
    line-height: 32px;
}

.colour1 {
    background: #16A085;
}

.colour2 {
    background: #3bbefb;
}

.colour3 {
    background: #EEE;
}

.arrow-separator {
    position: relative;
}

.arrow-separator:after {
    top: 100%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-width: 12px;
    left: 50%;
    margin-left: -12px;
    z-index: 11;
}

.arrow-white:after {
    border-color: #FFF rgba(255, 255, 255, 0) rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
    /** Using RGB to remove dark line in Firefox **/
}
.fullwidth {
    width: 100%;
    padding: 60px 30px;
    min-width: 280px;
}

.fullwidth .bodycontainer {
    margin: 0 auto;
    width: 100%;
    max-width: 1000px;
    text-align: center;
}

#topcontainer h1 {
    padding: 6px 0 10px 0;
    margin-bottom: 0;
    letter-spacing: -1.5px;
    color: #444;
    font-weight: 400;
}

#topcontainer h1 span {
    font-size: 70px;
    line-height: 70px;
    letter-spacing: -1.4px;
    font-weight: 300;
}

#topcontainer p {
    margin-bottom: 0;
    color: #999;
}

#topcontainer p span {
    font-size: 90px;
    line-height: 90px;
    color: #1abc9c;
}

#maincont {
    color: #FFF;
}

#maincont a {
    color: #FFF;
    opacity: 0.6;
}

#maincont a:hover {
    opacity: 1;
}

#maincont #signupform {
    margin: 0 auto 20px auto;
    width: 80%;
}
#footercont p.backtotop {
    margin: 0 0 40px 0;
}

#footercont p.backtotop a {
    position: relative;
    display: inline-block;
    background: #EEE;
    font-size: 32px;
    line-height: 32px;
    color: #999;
    padding: 5px 12px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}

#footercont p.backtotop a:hover {
    background-color: #1ABC9C;
    color: #FFF;
    text-decoration: none;
}

#footercont p.backtotop a:active {
    top: 2px;
}

@media screen and (max-width: 768px) {
    body {
        font-size: 23px;
        line-height: 29px;
    }
    #topcontainer h1 {
        font-size: 54px;
        line-height: 54px;
        letter-spacing: -1.2px;
    }
    #topcontainer h1 span {
        font-size: 70px;
        line-height: 70px;
    }
    #countdown #countdowncont {
        max-width: 400px;
    }
    #countdown #countdowncont ul#countscript li {
        width: 50%;
        padding: 10px 0;
    }
    #countdown #countdowncont ul#countscript li span {
        font-size: 70px;
        line-height: 70px;
    }
    #quotecont {
        padding: 15px 0;
    }
    #footercont {
        font-size: 19px;
    }
    #footercont #footerleft {
        float: none;
        padding: 30px 0;
        text-align: center;
    }
    #footercont #socialmedia ul li a {
        font-size: 32px;
    }
    #footercont #footerright {
        float: none;
    }
}

@media screen and (max-width: 480px) {
    body {
        font-size: 21px !important;
        line-height: 27px !important;
    }
    #topcontainer h1 {
        font-size: 36px;
        line-height: 36px;
    }
    #topcontainer h1 span {
        font-size: 36px;
        line-height: 36px;
    }
    #countdown #countdowncont ul#countscript li {
        padding: 6px 0;
    }
    #countdown #countdowncont ul#countscript li span {
        font-size: 62px;
        line-height: 62px;
    }
    #countdown #countdowncont ul#countscript li p {
        font-size: 16px;
        line-height: 16px;
    }
    #maincont #signupform {
        margin: 0 auto 20px auto;
        width: 100%;
    }
    #quotecont {
        padding: 5px 0;
    }
    #footercont #socialmedia ul li {
        margin: 0 5px;
    }
    #footercont #socialmedia ul li a {
        font-size: 28px;
    }
    h2 {
    font-size: 30px;
    line-height: 30px;
    }
}
</style>', __( 'Обслуживание', 'yw-maintenance' ), array('response' => '503'));}

}
add_action('get_header', 'yw_maintenance_mode');